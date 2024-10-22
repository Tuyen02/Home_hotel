<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

if (isset($_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']);

    // Lấy thông tin booking từ cơ sở dữ liệu
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
            r.price AS room_price
        FROM " . NV_PREFIXLANG . "_room_booking b
        INNER JOIN " . NV_PREFIXLANG . "_room_rooms r ON b.room_id = r.id
        INNER JOIN " . NV_PREFIXLANG . "_room_booking_details bd ON b.booking_id = bd.booking_id  
        INNER JOIN " . NV_USERS_GLOBALTABLE . " u ON b.userid = u.userid
        WHERE b.booking_id = :booking_id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            die("Không tìm thấy booking.");
        }
    } catch (PDOException $e) {
        die("Lỗi cơ sở dữ liệu: " . $e->getMessage());
    }

    // Tính toán tổng giá
    $checkin = $booking['check_in'];
    $checkout = $booking['check_out'];
    $days_stayed = ceil(($checkout - $checkin) / 86400);
    $total_price = $days_stayed * $booking['room_price'];

    // Khởi tạo template
    $xtpl = new XTemplate('print_invoice.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

    // Gán dữ liệu vào template
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
    ));

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo $contents; // Hiển thị hóa đơn
    include NV_ROOTDIR . '/includes/footer.php';
} else {
    die("Mã đặt phòng không hợp lệ.");
}
