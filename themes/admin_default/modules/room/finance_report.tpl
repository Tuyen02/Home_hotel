<!-- BEGIN: main -->
<style>
    .chart {
        padding-bottom: 30px;
    }
</style>
<div class="container chart">
    <h2 class="fw-bold">Doanh thu theo tháng của năm {CURRENT_YEAR}</h2>
    
    <!-- Form chọn năm -->
    <form method="GET" action="{NV_BASE_SITEURL}admin.php">
        <input type="hidden" name="op" value="your_module_operation" />
        <select name="year" onchange="this.form.submit()">
            <!-- Hiển thị danh sách các năm -->
            <!-- BEGIN: years -->
            <option value="{YEAR}" {SELECTED}>{YEAR}</option>
            <!-- END: years -->
        </select>
    </form>
    
    <!-- Biểu đồ -->
    <canvas id="monthlyChart" width="400" height="200"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dữ liệu từ PHP
    var months = {MONTHS};
    var totals = {TOTALS};

    // Vẽ biểu đồ cột
    var ctx = document.getElementById('monthlyChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months.map(month => 'Tháng ' + month), // Hiển thị tháng dưới dạng 'Tháng 1', 'Tháng 2', ...
            datasets: [{
                label: 'Tổng giá (₫)',
                data: totals, // Dữ liệu là tổng giá theo tháng
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' ₫'; // Định dạng giá tiền
                        }
                    }
                }
            }
        }
    });
</script>
<!-- END: main -->
