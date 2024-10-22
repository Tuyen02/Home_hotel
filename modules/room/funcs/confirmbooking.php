<?php
if (!defined('NV_IS_MOD_ROOM')) {
    exit('Stop!!!');
}

$checkin = $nv_Request->get_title('checkin', 'get, post', '');
$checkout = $nv_Request->get_title('checkout', 'get, post', '');
$adult = $nv_Request->get_int('adult', 'get, post', 0);
$children = $nv_Request->get_int('children', 'get, post', 0);
$selected_rooms = $nv_Request->get_title('selected_rooms', 'get, post', '');
$selected_rooms = trim($selected_rooms, characters: ',');

$room_ids = array_filter(array_map('intval', explode(',', $selected_rooms)));
$room_counts = array_count_values($room_ids);
$message = 0;


if ($nv_Request->isset_request("submit", "post, get")) {
    $isFormSubmitted = true;

    // Lấy thông tin từ form
    $fullname = $nv_Request->get_title('fullname', 'post', '', 1);
    $email = $nv_Request->get_title('email', 'post', '', 1);
    $phone = $nv_Request->get_title('phone', 'post', '', 1);
    $address = $nv_Request->get_title('address', 'post', '', 1);
    $payment_method = $nv_Request->get_int('payment_method', 'post', 0);

    if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $checkin, $m)) {
        $checkin_time = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $error = 'Thông tin ngày nhận phòng không hợp lệ.';
    }

    if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $checkout, $m)) {
        $checkout_time = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
        if ($checkout_time <= $checkin_time) {
            $error = 'Ngày trả phòng phải sau ngày nhận phòng.';
        }
    } else {
        $error = 'Thông tin ngày trả phòng không hợp lệ.';
    }

    try {
        $db->beginTransaction();

        // 1. Tạo một đơn đặt phòng mới
        $stmt = $db->prepare("INSERT INTO nv4_vi_room_booking 
            (booking_id, userid, check_in, check_out, booking_status, rate_review, datentime) 
            VALUES (:booking_id, :userid, :check_in, :check_out, :booking_status, :rate_review, :datentime)");

        $booking_id = null; // Cần xác định nếu có
        $booking_status = 'pending'; // Trạng thái đặt phòng
        $datentime = time();
        $userid = 0;

        // Gán giá trị cho các tham số
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT); // Nếu không có userid, có thể bỏ qua
        $stmt->bindParam(':check_in', $checkin_time, PDO::PARAM_INT);
        $stmt->bindParam(':check_out', $checkout_time, PDO::PARAM_INT);
        $stmt->bindParam(':booking_status', $booking_status, PDO::PARAM_STR);
        $stmt->bindParam(':rate_review', $rate_review, PDO::PARAM_STR); // Cần xác định nếu có
        $stmt->bindParam(':datentime', $datentime, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $booking_id = $db->lastInsertId(); // Lấy ID đặt phòng mới tạo
        } else {
            echo "Có lỗi xảy ra khi thực thi câu lệnh SQL.";
            die();
        }
        // 2. Thêm thông tin chi tiết đặt phòng
        $stmt = $db->prepare("INSERT INTO nv4_vi_room_booking_details 
            (id, booking_id, room_id, room_name, price, quanlity, total_pay, user_name, phonenum, address) 
            VALUES (:id, :booking_id, :room_id, :room_name, :price, :quanlity, :total_pay, :user_name, :phonenum, :address)");

        foreach ($room_counts as $room_id => $quanlity) {
            // Lấy thông tin phòng
            $room = $db->query("SELECT name, price FROM " . NV_PREFIXLANG . "_" . $module_data . "_rooms WHERE id = " . $room_id)->fetch();
            $room_name = $room['name'];
            $price = $room['price'];
            $total_pay = $price * $quanlity; // Hoặc tính toán tổng tiền nếu có số lượng phòng

            // Gán giá trị cho các tham số
            $id = null; // Cần xác định nếu có
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
            $stmt->bindParam(':room_name', $room_name, PDO::PARAM_STR);
            $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':quanlity', $quanlity, PDO::PARAM_INT);
            $stmt->bindParam(':total_pay', $total_pay, PDO::PARAM_INT);
            $stmt->bindParam(':user_name', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':phonenum', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR); // Gán địa chỉ vào tham số
            $stmt->execute();
        }

        $db->commit();
        // Nếu thành công
        // chuuyen huowng
        nv_redirect_location(nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=processbooking&booking_id=' . $booking_id, true));

        $message = "Gửi thông tin đăng ký thành công!";
    } catch (PDOException $e) {
        $db->rollBack();
        // Nếu có lỗi
        print_r($e);
        die;
    }
}

$rooms_info = [];
if (!empty($room_ids)) {
    $room_ids_imploded = implode(',', $room_ids);

    if (empty($room_ids_imploded) || !preg_match('/^\d+(,\d+)*$/', $room_ids_imploded)) {
        die('Invalid room IDs');
    }

    $sql = "SELECT r.*, 
                GROUP_CONCAT(DISTINCT f.name ORDER BY f.name ASC SEPARATOR ', ') AS features, 
                GROUP_CONCAT(DISTINCT fac.name ORDER BY fac.name ASC SEPARATOR ', ') AS facilities,
                (SELECT image FROM " . NV_PREFIXLANG . "_" . $module_data . "_images 
                    WHERE room_id = r.id AND active = 1 LIMIT 1) AS room_image 
            FROM " . NV_PREFIXLANG . "_" . $module_data . "_rooms AS r 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_roomxfacilities AS rf ON r.id = rf.room_id 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_facilities AS fac ON rf.facilities_id = fac.id 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_roomxfeatures AS rxf ON r.id = rxf.room_id 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_features AS f ON rxf.features_id = f.id 
            WHERE r.id IN ($room_ids_imploded)
            GROUP BY r.id 
            ORDER BY r.id ASC";

    try {
        $result = $db->query($sql);

        while ($row = $result->fetch()) {
            $price_formatted = number_format($row['price'], 0, ',', '.') . '₫';
            $selected_count = isset($room_counts[$row['id']]) ? $room_counts[$row['id']] : 0; // Lấy số lượng đã chọn

            $rooms_info[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'price_formatted' => $price_formatted,
                'description' => $row['description'],
                'image' => NV_BASE_SITEURL . NV_UPLOADS_DIR . '/room/images/' . $row['room_image'],
                'features' => $row['features'],
                'facilities' => $row['facilities'],
                'selected_count' => $selected_count
            ];
        }
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}

// Đưa dữ liệu vào template
$xtpl = new XTemplate('confirmbooking.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/room');
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('CHECKIN', nv_date('d/m/Y', strtotime($checkin)));
$xtpl->assign('CHECKOUT', nv_date('d/m/Y', strtotime($checkout)));
$xtpl->assign('ADULT', $adult);
$xtpl->assign('CHILDREN', $children);
$xtpl->assign('SELECTED_ROOMS', $selected_rooms);
$xtpl->assign('FULLNAME', isset($fullname) ? $fullname : '');
$xtpl->assign('EMAIL', isset($email) ? $email : '');
$xtpl->assign('PHONE', isset($phone) ? $phone : '');

// Hiển thị thông tin phòng đã chọn
foreach ($rooms_info as $room) {
    $xtpl->assign('ROOM', $room);

    if (!empty($room['features'])) {
        $xtpl->assign('FEATURES', $room['features']);
        $xtpl->parse('main.selected_rooms.features');
    }

    if (!empty($room['facilities'])) {
        $xtpl->assign('FACILITIES', $room['facilities']);
        $xtpl->parse('main.selected_rooms.facilities');
    }

    $xtpl->parse('main.selected_rooms');
}

if ($message) {
    $xtpl->assign('MESSAGE', $message);
    $xtpl->parse('main.message');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
