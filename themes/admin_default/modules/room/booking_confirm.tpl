<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="container">
    <div class="alert alert-danger">
        {ERROR}
    </div>
</div>
<!-- END: error -->

<h3>Danh sách booking</h3>
<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Phòng</th>
                <th class="text-center">Người dùng</th>
                <th class="text-center">Ngày nhận phòng</th>
                <th class="text-center">Ngày trả phòng</th>
                <th class="text-center">Tổng giá</th>
                <th class="text-center">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: booking -->
            <tr>
                <td class="text-center">{BOOKING.booking_id}</td>
                <td>{BOOKING.room_name}</td>
                <td>{BOOKING.user_name}</td>
                <td>{BOOKING.checkin}</td>
                <td>{BOOKING.checkout}</td>
                <td>{BOOKING.total_price} ₫
                </td>
                <td class="text-center">
                    <p>Đã xác nhận</p>
                    <a href="#" target="_blank" class="btn btn-primary">In hóa đơn</a> <!-- Thêm nút in hóa đơn -->
                </td>
            </tr>
            <!-- END: booking -->
        </tbody>
    </table>
</div>
<!-- END: main -->
