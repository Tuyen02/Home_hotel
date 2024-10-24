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
        MONTH(FROM_UNIXTIME(check_in)) AS month,
        SUM(d.total_pay * CEIL((FROM_UNIXTIME(check_out) - FROM_UNIXTIME(check_in)) / 86400)) AS total_price
    FROM " . NV_PREFIXLANG . "_room_booking b
    JOIN " . NV_PREFIXLANG . "_" . $module_data . "_booking_details d ON b.booking_id = d.booking_id
    WHERE b.booking_status = 1 AND YEAR(FROM_UNIXTIME(b.check_in)) = " . $current_year . "
    GROUP BY month
    ORDER BY month";

    $result = $db->query($sql);
    $monthly_totals = array_fill(1, 12, 0); // Mảng cho 12 tháng, khởi tạo giá trị = 0

    // Tính tổng giá cho từng tháng
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $monthly_totals[$row['month']] = (float) $row['total_price']; // Lưu tổng giá vào tháng tương ứng
    }

    // Chuyển đổi dữ liệu thành JSON cho JavaScript
    $months = range(1, 12);  // Danh sách 12 tháng
    $totals = array_values($monthly_totals);  // Tổng giá cho từng tháng

    $xtpl = new XTemplate('finance_report.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    // Gán dữ liệu cho TPL để sử dụng trong JavaScript
    $xtpl->assign('MONTHS', json_encode($months));
    $xtpl->assign('TOTALS', json_encode($totals));
    $xtpl->assign('CURRENT_YEAR', $current_year);
    $xtpl->assign('LANG', $lang_module);

    // Lấy danh sách các năm có booking trong cơ sở dữ liệu
    $years_sql = "SELECT DISTINCT YEAR(FROM_UNIXTIME(check_in)) AS year FROM " . NV_PREFIXLANG . "_room_booking WHERE booking_status = 1 ORDER BY year DESC";
    $years_result = $db->query($years_sql);
    $years = $years_result->fetchAll(PDO::FETCH_COLUMN);
    
    // Gán dữ liệu cho TPL
    foreach ($years as $year) {
        $xtpl->assign('YEAR', $year);
        $xtpl->assign('SELECTED', ($year == $current_year) ? 'selected' : '');
        $xtpl->parse('main.years');
    }
} catch (PDOException $e) {
    die("Lỗi cơ sở dữ liệu: " . $e->getMessage());
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
