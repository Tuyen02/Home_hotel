<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['booking_content'];

// Lấy danh sách booking từ cơ sở dữ liệu
try {
    $sql = "
    SELECT 
        b.booking_id,  
        b.check_in, 
        b.check_out, 
        b.datentime AS booking_date, 
        b.booking_status,  
        u.username AS user_name, 
        bd.phonenum AS user_phone,  
        u.email AS user_email, 
        r.name AS room_name, 
        r.price AS room_price,
        b.arrival AS cancel_request  -- Lấy thông tin yêu cầu hủy
    FROM " . NV_PREFIXLANG . "_room_booking b
    INNER JOIN " . NV_PREFIXLANG . "_room_rooms r ON b.room_id = r.id
    INNER JOIN " . NV_PREFIXLANG . "_room_booking_details bd ON b.booking_id = bd.booking_id  
    INNER JOIN " . NV_USERS_GLOBALTABLE . " u ON b.userid = u.userid
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
    $checkin = $booking['check_in'];   
    $checkout = $booking['check_out']; 
    $days_stayed = ceil(($checkout - $checkin) / 86400); 
    $total_price = $days_stayed * $booking['room_price'];
    $lang_module['pending'] = 'Chờ xác nhận';
    $lang_module['confirmed'] = 'Đã xác nhận';
    $lang_module['canceled'] = 'Đã hủy';

    // Đảm bảo rằng ngôn ngữ đã được định nghĩa
    $status_label = '';
    if ($booking['booking_status'] == 1) {
        $status_label = $lang_module['pending']; // Pending
    } elseif ($booking['booking_status'] == 2) {
        $status_label = $lang_module['confirmed']; // Confirmed
    } elseif ($booking['booking_status'] == 0) {
        $status_label = $lang_module['canceled']; // Canceled
    }

    $xtpl->assign('BOOKING', array(
        'booking_id' => $booking['booking_id'],
        'user_name' => $booking['user_name'],
        'user_email' => $booking['user_email'],
        'user_phone' => $booking['user_phone'],
        'room_name' => $booking['room_name'],
        'room_price' => number_format($booking['room_price'], 0, ',', '.'), 
        'total_price' => number_format($total_price, 0, ',', '.'), 
        'booking_date' => date('d/m/Y', $booking['booking_date']), 
        'checkin' => date('d/m/Y', $checkin), 
        'checkout' => date('d/m/Y', $checkout), 
        'status' => $booking['booking_status'],  
        'status_label' => $status_label,
        'confirm_url' => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&action=confirm&id=" . $booking['booking_id'],
        'cancel_url' => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&action=cancel&id=" . $booking['booking_id']
    ));
    
    // Hiển thị trạng thái và các hành động
    if ($booking['booking_status'] == 1) {
        $xtpl->parse('main.booking.pending_action');
    } elseif ($booking['cancel_request'] == 1) {
        // Hiển thị khi có yêu cầu hủy từ khách hàng
        $xtpl->parse('main.booking.cancel_request');
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
