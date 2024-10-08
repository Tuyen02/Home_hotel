<?php
if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_summary')) {
    function nv_block_summary($block_config)
    {
        global $nv_Request, $db, $module_data;

        $checkin = $nv_Request->get_string('checkin', 'get', '');
        $checkout = $nv_Request->get_string('checkout', 'get', '');
        $adult = $nv_Request->get_int('adult', 'get', 0);
        $children = $nv_Request->get_int('children', 'get', 0);
        $selected_rooms = $nv_Request->get_array('selected_room', 'get', []);

        $xtpl = new XTemplate('global.summary.tpl', NV_ROOTDIR . '/themes/' . $GLOBALS['module_info']['template'] . '/blocks');

        $xtpl->assign('CHECKIN', date('d/m/Y', strtotime($checkin)));
        $xtpl->assign('CHECKOUT', date('d/m/Y', strtotime($checkout)));
        $xtpl->assign('ADULT', $adult);
        $xtpl->assign('CHILDREN', $children);

        if ($checkin && $checkout) {
            // Tính số đêm
            $checkin_date = new DateTime($checkin);
            $checkout_date = new DateTime($checkout);
            $number_of_nights = $checkout_date->diff($checkin_date)->days;
            $xtpl->assign('NUMBER_OF_NIGHTS', $number_of_nights);

            // Xử lý danh sách phòng đã chọn
            $room_list = '';
            $total_price = 0;
            if (!empty($selected_rooms)) {
                $room_counts = array_count_values($selected_rooms);
                $room_ids = array_unique($selected_rooms);
                
                if (!empty($room_ids)) {
                    $room_ids_str = implode(',', array_map('intval', $room_ids));
                    $sql = "SELECT id, name, price FROM " . NV_PREFIXLANG . "_" . $module_data . "_rooms WHERE id IN (" . $room_ids_str . ")";
                    $result = $db->query($sql);
                    while ($row = $result->fetch()) {
                        $room_count = $room_counts[$row['id']];
                        $room_price = $row['price'] * $number_of_nights * $room_count;
                        $total_price += $room_price;
                        $room_list .= "<li>{$row['name']} (x{$room_count}) - " . number_format($room_price, 0, ',', '.') . "₫</li>";
                    }
                }
            }
            
            if (empty($room_list)) {
                $room_list = "<li>Không có phòng nào được chọn.</li>";
            }

            $confirm_url = NV_BASE_SITEURL . NV_LANG_DATA . '/room/confirmbooking';

            $xtpl->assign('ROOM_LIST', $room_list);
            $xtpl->assign('TOTAL_PRICE', number_format($total_price, 0, ',', '.') . '₫');
            
            // Thêm form chuyển tiếp tới bookingconfirm.php
            $xtpl->assign('CHECKIN_VALUE', $checkin);
            $xtpl->assign('CHECKOUT_VALUE', $checkout);
            $xtpl->assign('ADULT_VALUE', $adult);
            $xtpl->assign('CHILDREN_VALUE', $children);
            $xtpl->assign('SELECTED_ROOMS', implode(',', $selected_rooms));
            $xtpl->assign('CONFIRM_URL', $confirm_url);
            $xtpl->parse('main.has_dates');
        } else {
            $xtpl->parse('main.no_dates');
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_summary($block_config);
}
