    <?php
    if (!defined('NV_IS_MOD_ROOM')) {
        exit('Stop!!!');
    }

    // Lấy thông tin từ yêu cầu
    $checkin = $nv_Request->get_title('checkin', 'get,post', '');
    $checkout = $nv_Request->get_title('checkout', 'get,post', '');
    $adult = $nv_Request->get_int('adult', 'get,post', 0);
    $children = $nv_Request->get_int('children', 'get,post', 0);
    $facilities_filter = $nv_Request->get_array('facilities', 'get,post', []);

    // Kiểm tra thông tin tìm kiếm có được gửi hay không
    $is_search = !empty($checkin) && !empty($checkout);

    // Nếu không có thông tin tìm kiếm, chỉ cần hiển thị tất cả các phòng
    if (!$is_search) {
        $conditions[] = "1"; // Để lấy tất cả các phòng
    }

    // Còn lại phần xử lý ngày tháng như trước
    $error = '';

    // Kiểm tra ngày nhận phòng và trả phòng
    if ($is_search) {
        if (preg_match('/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/', $checkin, $m)) {
            $checkin_time = mktime(0, 0, 0, $m[2], $m[3], $m[1]);
        } else {
            $error = 'Thông tin ngày nhận phòng không hợp lệ.';
        }

        if (preg_match('/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/', $checkout, $m)) {
            $checkout_time = mktime(0, 0, 0, $m[2], $m[3], $m[1]);
            if ($checkout_time <= $checkin_time) {
                $error = 'Ngày trả phòng phải sau ngày nhận phòng.';
            }
        } else {
            $error = 'Thông tin ngày trả phòng không hợp lệ.';
        }

        // Thêm điều kiện lọc
        if (!empty($checkin_time) && !empty($checkout_time)) {
            $conditions[] = "r.id NOT IN (
           SELECT 1 FROM " . NV_PREFIXLANG . "_" . $module_data . "_booking_details AS bd INNER JOIN " . NV_PREFIXLANG . "_" . $module_data . "_booking as b ON bd.booking_id=b.booking_id
            WHERE ('$checkin_time' BETWEEN check_in AND check_out OR '$checkout_time' BETWEEN check_in AND check_out)
            OR (check_in BETWEEN '$checkin_time' AND '$checkout_time')
        )";
        }

        // Lọc theo số lượng người lớn và trẻ em
        // Lọc theo số lượng người lớn và trẻ em (thỏa mãn cả hai điều kiện)
        if ($adult > 0 && $children > 0) {
            $conditions[] = "(r.adult >= " . intval($adult) . " AND r.children >= " . intval($children) . ")";
        }

        // Lọc theo tiện ích
        if (!empty($facilities_filter)) {
            $facilities_filter_sql = implode(',', array_map('intval', $facilities_filter));
            $conditions[] = "r.id IN (
                SELECT room_id FROM " . NV_PREFIXLANG . "_room_roomxfacilities 
                WHERE facilities_id IN ($facilities_filter_sql)
            )";
        }
    }

    $perpage = 10;
    $page = $nv_Request->get_int('page', 'get,post', 1);
    $offset = ($page - 1) * $perpage;

    // Xây dựng truy vấn SQL lấy danh sách phòng với đặc điểm và tiện ích
    $sql = "SELECT r.*, 
                GROUP_CONCAT(DISTINCT f.name) AS features, 
                GROUP_CONCAT(DISTINCT fac.name) AS facilities,
                (SELECT image FROM " . NV_PREFIXLANG . "_room_images WHERE room_id = r.id AND active = 1 LIMIT 1) AS room_image 
            FROM " . NV_PREFIXLANG . "_" . $module_data . "_rooms AS r 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_roomxfacilities AS rf ON r.id = rf.room_id 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_facilities AS fac ON rf.facilities_id = fac.id 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_roomxfeatures AS rxf ON r.id = rxf.room_id 
            LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_features AS f ON rxf.features_id = f.id 
            WHERE " . implode(' AND ', $conditions) . " 
            GROUP BY r.id 
            ORDER BY r.id ASC 
            LIMIT $offset, $perpage";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);

    // Hiển thị thông báo lỗi (nếu có)
    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }

    // Hiển thị danh sách phòng
    if (!empty($rooms)) {
        foreach ($rooms as $room) {
            $room['price_formatted'] = number_format($room['price'], 0, ',', '.') . '₫';
            $room['image'] = !empty($room['room_image']) ? NV_BASE_SITEURL . 'uploads/room/images/' . $room['room_image'] : NV_BASE_SITEURL . 'themes/default/images/no_image.jpg';
            $room['features'] = !empty($room['features']) ? explode(',', $room['features']) : [];
            $room['facilities'] = !empty($room['facilities']) ? explode(',', $room['facilities']) : [];
            $room['booking_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=booking';
            $room['view_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view&amp;id=' . $room['id'];

            $xtpl->assign('ROOM', $room);

            // Hiển thị các đặc điểm của phòng
            foreach ($room['features'] as $feature) {
                $xtpl->assign('FEATURE', $feature);
                $xtpl->parse('main.room.feature');
            }

            // Hiển thị tiện ích của phòng
            if (!empty($room['facilities'])) {
                foreach ($room['facilities'] as $facility) {
                    $xtpl->assign('FACILITY', $facility);
                    $xtpl->parse('main.room.facility');
                }
            }

            $xtpl->parse('main.room');
        }
    } else {
        $xtpl->parse('main.no_rooms');
    }

    // Phân trang
    $generate_page = nv_generate_page(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, $total_rooms, $perpage, $page);
    $xtpl->assign('GENERATE_PAGE', $generate_page);

    // Kết thúc và xuất ra giao diện
    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
