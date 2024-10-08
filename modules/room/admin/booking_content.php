<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['booking_content'];

// Xử lý xác nhận hoặc hủy booking
$action = $nv_Request->get_string('action', 'get');
$booking_id = $nv_Request->get_int('id', 'get');

if ($action === 'confirm' && !empty($booking_id)) {
    // Cập nhật trạng thái booking thành "Đã xác nhận"
    $sql = "UPDATE " . NV_PREFIXLANG . "_room_booking SET booking_status = 1 WHERE booking_id = :booking_id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':booking_id' => $booking_id]);
}

if ($action === 'cancel' && !empty($booking_id)) {
    // Cập nhật trạng thái booking thành "Đã hủy"
    $sql = "UPDATE " . NV_PREFIXLANG . "_room_booking SET booking_status = 2 WHERE booking_id = :booking_id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':booking_id' => $booking_id]);
}

// Lấy danh sách booking từ cơ sở dữ liệu
try {
    $sql = "
    SELECT 
        *   
    FROM " . NV_PREFIXLANG . "_room_booking b
    where booking_status = 0
    ORDER BY b.booking_id ASC";

    $result = $db->query($sql);
    $bookings = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi cơ sở dữ liệu: " . $e->getMessage());
}

// Khởi tạo template
$xtpl = new XTemplate('booking_content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

$xtpl->assign('LANG', $lang_module);

// Xử lý danh sách booking
foreach ($bookings as $booking) {
    $total_price = 0;
    $checkin = $booking['check_in'];   
    $checkout = $booking['check_out']; 
    $_booking_details = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_booking_details WHERE booking_id = ". $booking['booking_id']);
    while ($booking_details = $_booking_details->fetch()) {
        $booking['user_name'] = $booking_details['user_name'];
        $booking['user_phone'] = $booking_details['phonenum'];
    
        $booking_details['price']= number_format($booking_details['price']);
        
        $days_stayed = ceil(($checkout - $checkin) / 86400); 
        $total_price += $days_stayed * $booking_details['total_pay'];
        
        $xtpl->assign('ROOM', $booking_details);
        $xtpl->parse('main.booking.room');
    }
    
    $lang_module['pending'] = 'Chờ xác nhận';
    $lang_module['confirmed'] = 'Đã xác nhận';
    $lang_module['canceled'] = 'Đã hủy';

    // Đảm bảo rằng ngôn ngữ đã được định nghĩa
    $status_label = '';
    if ($booking['booking_status'] == 0) {
        $status_label = $lang_module['pending']; // Pending
    } elseif ($booking['booking_status'] == 1) {
        $status_label = $lang_module['confirmed']; // Confirmed
    } elseif ($booking['booking_status'] == 2) {
        $status_label = $lang_module['canceled']; // Canceled
    }

    
    $xtpl->assign('BOOKING', array(
        'booking_id' => $booking['booking_id'],
        'user_name' => $booking['user_name'],
        'user_phone' => $booking['user_phone'],

        'total_price' => number_format($total_price, 0, ',', '.'), 
        'checkin' => date('d/m/Y', $checkin), 
        'checkout' => date('d/m/Y', $checkout), 
        'status' => $booking['booking_status'],  
        'status_label' => $status_label,
        'confirm_url' => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&action=confirm&id=" . $booking['booking_id'],
        'cancel_url' => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&action=cancel&id=" . $booking['booking_id']
    ));
    
    // Hiển thị trạng thái và các hành động
    if ($booking['booking_status'] == 0) {
        $xtpl->parse('main.booking.pending_action');
    } else {
        $xtpl->parse('main.booking.no_action');
    }
    
    // Parse từng booking vào khối 'main'
    $xtpl->parse('main.booking');
}

// Hiển thị lỗi (nếu có)
if (!empty($err)) {
    $xtpl->assign('ERROR', implode(', ', $err));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
