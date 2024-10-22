<?php
if (!defined('NV_IS_MOD_ROOM')) {
    exit('Stop!!!');
}

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Truy vấn lấy thông tin chi tiết phòng theo ID
$sql = "SELECT r.*, 
        GROUP_CONCAT(DISTINCT f.name SEPARATOR ', ') AS features, 
        GROUP_CONCAT(DISTINCT fa.name SEPARATOR ', ') AS facilities,
        GROUP_CONCAT(DISTINCT i.image SEPARATOR ',') AS room_images
        FROM nv4_vi_room_rooms r
        LEFT JOIN nv4_vi_room_roomxfeatures rf ON r.id = rf.room_id
        LEFT JOIN nv4_vi_room_features f ON rf.features_id = f.id
        LEFT JOIN nv4_vi_room_roomxfacilities rfa ON r.id = rfa.room_id
        LEFT JOIN nv4_vi_room_facilities fa ON rfa.facilities_id = fa.id
        LEFT JOIN nv4_vi_room_images i ON r.id = i.room_id
        WHERE r.id = :id
        GROUP BY r.id
        LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    nv_error_log('PDO Error: ' . $e->getMessage());
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

if (!$room) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Tạo template cho trang chi tiết phòng
$xtpl = new XTemplate('view.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);

// Chuyển đổi chuỗi đặc điểm và tiện nghi thành mảng
$room['price'] = number_format($room['price'], 0, ',', '.') . '₫';
$room['features'] = !empty($room['features']) ? explode(',', $room['features']) : [];
$room['facilities'] = !empty($room['facilities']) ? explode(',', $room['facilities']) : [];
$room['room_images'] = !empty($room['room_images']) ? explode(',', $room['room_images']) : [];
$room['booking_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=booking';

// Gán ảnh vào carousel
foreach ($room['room_images'] as $image) {
    $xtpl->assign('IMAGE', NV_BASE_SITEURL . 'uploads/room/images/' . $image);
    $xtpl->parse('main.carousel');
}

// Hiển thị các đặc điểm phòng
foreach ($room['features'] as $feature) {
    $xtpl->assign('FEATURE', $feature);
    $xtpl->parse('main.feature');
}

// Hiển thị các tiện nghi phòng
foreach ($room['facilities'] as $facility) {
    $xtpl->assign('FACILITY', $facility);
    $xtpl->parse('main.facility');
}

// Gán dữ liệu phòng vào template
$xtpl->assign('ROOM', $room);

// Parse nội dung chính và hiển thị
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';