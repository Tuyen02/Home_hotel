<?php
if (!defined('NV_IS_MOD_ROOM')) {
    exit('Stop!!!');
}

// Xử lý thông tin từ các trường lọc
$checkin_date = $nv_Request->get_title('checkin', 'post', '');
$checkout_date = $nv_Request->get_title('checkout', 'post', '');
$adults = $nv_Request->get_int('adults', 'post', 0);
$children = $nv_Request->get_int('children', 'post', 0);
$facilities_filter = $nv_Request->get_array('facilities', 'post', []);

// Lấy danh sách tiện ích từ cơ sở dữ liệu
$sql_facilities = "SELECT * FROM nv4_vi_room_facilities";
$stmt_facilities = $db->prepare($sql_facilities);

try {
    $stmt_facilities->execute();
    $facilities_list = $stmt_facilities->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Lỗi truy vấn tiện ích: ' . $e->getMessage());
}

// Xây dựng câu truy vấn SQL để lấy thông tin phòng
$sql = "SELECT r.*, 
        GROUP_CONCAT(DISTINCT f.name) AS features, 
        GROUP_CONCAT(DISTINCT fa.name) AS facilities,
        GROUP_CONCAT(DISTINCT i.image) AS room_images
        FROM nv4_vi_room_rooms r
        LEFT JOIN nv4_vi_room_roomxfeatures rf ON r.id = rf.room_id
        LEFT JOIN nv4_vi_room_features f ON rf.features_id = f.id
        LEFT JOIN nv4_vi_room_roomxfacilities rfa ON r.id = rfa.room_id
        LEFT JOIN nv4_vi_room_facilities fa ON rfa.facilities_id = fa.id
        LEFT JOIN nv4_vi_room_images i ON r.id = i.room_id AND i.active = 1";

// Thêm điều kiện lọc
$conditions = [];
if (!empty($checkin_date)) {
    $conditions[] = "r.id NOT IN (SELECT room_id FROM nv4_vi_room_bookings WHERE checkin_date < '$checkout_date' AND checkout_date > '$checkin_date')";
}
if (!empty($facilities_filter)) {
    $facilities_filter_sql = implode("', '", array_map('addslashes', $facilities_filter));
    $conditions[] = "r.id IN (SELECT room_id FROM nv4_vi_room_roomxfacilities WHERE facilities_id IN ('$facilities_filter_sql'))";
}

// Lọc theo số lượng người lớn và trẻ em
if ($adults > 0) {
    $conditions[] = "r.max_adults >= " . intval($adults);
}
if ($children > 0) {
    $conditions[] = "r.max_children >= " . intval($children);
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " GROUP BY r.id ORDER BY r.id ASC";

$stmt = $db->prepare($sql);

try {
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Lỗi truy vấn dữ liệu: ' . $e->getMessage());
}

// Kiểm tra nếu là yêu cầu Ajax
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trả về danh sách phòng dưới dạng HTML cho Ajax
    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

    if (!empty($rooms)) {
        foreach ($rooms as $room) {
            $room['price'] = number_format($room['price'], 0, ',', '.') . '₫';
            $room_images = !empty($room['room_images']) ? explode(',', $room['room_images']) : [];
            $room['image'] = !empty($room_images) ? NV_BASE_SITEURL . 'uploads/room/images/' . $room_images[0] : NV_BASE_SITEURL . 'themes/default/images/no_image.jpg';
            $room['features'] = !empty($room['features']) ? explode(',', $room['features']) : [];
            $room['facilities'] = !empty($room['facilities']) ? explode(',', $room['facilities']) : [];
            $room['booking_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=booking&amp;id=' . $room['id'];
            $room['detail_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=detail&amp;id=' . $room['id'];

            $xtpl->assign('ROOM', $room);

            foreach ($room['features'] as $feature) {
                $xtpl->assign('FEATURE', $feature);
                $xtpl->parse('main.room.feature');
            }

            foreach ($room['facilities'] as $facility) {
                $xtpl->assign('FACILITY', $facility);
                $xtpl->parse('main.room.facility');
            }

            $xtpl->parse('main.room');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    } else {
        echo '<p>Hiện tại không có phòng nào phù hợp với tiêu chí tìm kiếm.</p>';
    }
    exit(); // Kết thúc xử lý Ajax
}

// Gán dữ liệu vào XTemplate nếu không phải Ajax
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

// Gán danh sách tiện ích vào XTemplate
if (!empty($facilities_list)) {
    foreach ($facilities_list as $facility) {
        $xtpl->assign('FACILITY_FILTER', $facility);
        $xtpl->parse('main.facility_filter');
    }
}

// Hiển thị danh sách phòng nếu không có yêu cầu Ajax
if (!empty($rooms)) {
    foreach ($rooms as $room) {
        $room['price'] = number_format($room['price'], 0, ',', '.') . '₫';
        $room_images = !empty($room['room_images']) ? explode(',', $room['room_images']) : [];
        $room['image'] = !empty($room_images) ? NV_BASE_SITEURL . 'uploads/room/images/' . $room_images[0] : NV_BASE_SITEURL . 'themes/default/images/no_image.jpg';
        $room['features'] = !empty($room['features']) ? explode(',', $room['features']) : [];
        $room['facilities'] = !empty($room['facilities']) ? explode(',', $room['facilities']) : [];
        $room['booking_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=booking&amp;id=' . $room['id'];
        $room['view_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view&amp;id=' . $room['id'];

        $xtpl->assign('ROOM', $room);

        foreach ($room['features'] as $feature) {
            $xtpl->assign('FEATURE', $feature);
            $xtpl->parse('main.room.feature');
        }

        foreach ($room['facilities'] as $facility) {
            $xtpl->assign('FACILITY', $facility);
            $xtpl->parse('main.room.facility');
        }

        $xtpl->parse('main.room');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
} else {
    $xtpl->assign('NO_ROOMS_MESSAGE', 'Hiện tại không có phòng nào.');
    $xtpl->parse('main.no_rooms');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
