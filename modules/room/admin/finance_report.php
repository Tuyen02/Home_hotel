<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

// Lấy năm từ tham số GET hoặc mặc định là năm hiện tại
$current_year = $nv_Request->get_int('year', 'get', date('Y'));

try {
    // Lấy danh sách booking đã xác nhận theo tháng của năm được chọn
    $sql = "
    SELECT 
        *, MONTH(FROM_UNIXTIME(check_in)) AS month, YEAR(FROM_UNIXTIME(check_in)) AS year
    FROM " . NV_PREFIXLANG . "_room_booking
    WHERE booking_status = 1 AND YEAR(FROM_UNIXTIME(check_in)) = " . $current_year;

    $result = $db->query($sql);
    $bookings = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Biến để lưu tổng giá theo tháng
    $monthly_totals = array_fill(1, 12, 0);  // Mảng cho 12 tháng, khởi tạo giá trị = 0

    // Tính tổng giá cho từng tháng
    foreach ($bookings as $booking) {
        $checkin = strtotime($booking['check_in']); // Chuyển đổi ngày check-in thành timestamp   
        $checkout = strtotime($booking['check_out']); // Chuyển đổi ngày check-out thành timestamp
        $month = date('m', $checkin); // Lấy tháng từ check_in

        $_booking_details = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_booking_details WHERE booking_id = ". $booking['booking_id']);
        
        while ($booking_details = $_booking_details->fetch()) {
            $days_stayed = ceil(($checkout - $checkin) / 86400); 
            $total_price = $days_stayed * $booking_details['total_pay'];

            // Cộng tổng giá vào tháng tương ứng
            $monthly_totals[(int)$month] += $total_price;
        }
    }

    // Chuyển đổi dữ liệu thành JSON cho JavaScript
    $months = range(1, 12);  // Danh sách 12 tháng
    $totals = array_values($monthly_totals);  // Tổng giá cho từng tháng

    $xtpl = new XTemplate('finance_report.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

    // Gán dữ liệu cho TPL để sử dụng trong JavaScript
    $xtpl->assign('MONTHS', json_encode($months));
    $xtpl->assign('TOTALS', json_encode($totals));
    $xtpl->assign('CURRENT_YEAR', $current_year);

    // Lấy danh sách các năm có booking trong cơ sở dữ liệu
    $years_sql = "SELECT DISTINCT YEAR(FROM_UNIXTIME(check_in)) AS year FROM " . NV_PREFIXLANG . "_room_booking WHERE booking_status = 1 ORDER BY year DESC";
    $years_result = $db->query($years_sql);
    $years = $years_result->fetchAll(PDO::FETCH_COLUMN);
    $xtpl->assign('YEARS', $years);

} catch (PDOException $e) {
    die("Lỗi cơ sở dữ liệu: " . $e->getMessage());
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
