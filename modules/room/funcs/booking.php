<?php
if (!defined('NV_IS_MOD_ROOM')) {
    exit('Stop!!!');
}

$checkin = $nv_Request->get_title('checkin', 'get', '');
$checkout = $nv_Request->get_title('checkout', 'get', '');
$adult = $nv_Request->get_int('adult', 'get', 0);
$children = $nv_Request->get_int('children', 'get', 0);
$selected_rooms = $nv_Request->get_array('selected_room', 'get', []);
$selected_rooms = array_count_values($selected_rooms);

$filter_sql = "WHERE 1=1";
$params = [];

if ($adult > 0) {
    $filter_sql .= " AND r.adult >= :adult";
    $params[':adult'] = $adult;
}

if ($children > 0) {
    $filter_sql .= " AND r.children >= :children";
    $params[':children'] = $children;
}

if ($checkin && $checkout) {
    $filter_sql .= " AND NOT EXISTS (
        SELECT 1 
        FROM " . NV_PREFIXLANG . "_" . $module_data . "_booking_details AS bd 
        INNER JOIN " . NV_PREFIXLANG . "_" . $module_data . "_booking as b ON bd.booking_id=b.booking_id
        WHERE bd.room_id = r.id
        AND b.check_in <= :checkout AND b.check_out >= :checkin
    )";
    $params[':checkin'] = $checkin;
    $params[':checkout'] = $checkout;
}

$sql = "SELECT r.*, 
            GROUP_CONCAT(DISTINCT f.name) AS features, 
            GROUP_CONCAT(DISTINCT fac.name) AS facilities,
            (SELECT image FROM " . NV_PREFIXLANG . "_room_images WHERE room_id = r.id AND active = 1 LIMIT 1) AS room_image 
        FROM " . NV_PREFIXLANG . "_" . $module_data . "_rooms AS r 
        LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_roomxfacilities AS rf ON r.id = rf.room_id 
        LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_facilities AS fac ON rf.facilities_id = fac.id 
        LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_roomxfeatures AS rxf ON r.id = rxf.room_id 
        LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_features AS f ON rxf.features_id = f.id 
        $filter_sql 
        GROUP BY r.id 
        ORDER BY r.id ASC";

$stmt = $db->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$xtpl = new XTemplate('booking.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('CHECKIN', $checkin);
$xtpl->assign('CHECKOUT', $checkout);
$xtpl->assign('ADULT', $adult);
$xtpl->assign('CHILDREN', $children);
$xtpl->assign('JSON_SELECTED_ROOMS', json_encode($selected_rooms));

if (!empty($rooms)) {
    foreach ($rooms as $room) {
        $room['price_formatted'] = number_format($room['price'], 0, ',', '.') . '₫';
        $room['image'] = !empty($room['room_image']) ? NV_BASE_SITEURL . 'uploads/room/images/' . $room['room_image'] : NV_BASE_SITEURL . 'themes/default/images/no_image.jpg';
        $room['features'] = !empty($room['features']) ? explode(',', $room['features']) : [];
        $room['facilities'] = !empty($room['facilities']) ? explode(',', $room['facilities']) : [];
        $room['selected_count'] = isset($selected_rooms[$room['id']]) ? $selected_rooms[$room['id']] : 0;

        $xtpl->assign('ROOM', $room);

        foreach ($room['features'] as $feature) {
            $xtpl->assign('FEATURE', $feature);
            $xtpl->parse('main.room.feature');
        }

        foreach ($room['facilities'] as $facility) {
            $xtpl->assign('FACILITY', $facility);
            $xtpl->parse('main.room.facility');
        }

        if ($room['selected_count'] > 0) {
            $xtpl->assign('SELECTED_COUNT', $room['selected_count']);
            $xtpl->parse('main.room.selected');
        } else {
            $xtpl->parse('main.room.not_selected');
        }

        $xtpl->parse('main.room');
    }
} else {
    $xtpl->parse('main.no_rooms');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
