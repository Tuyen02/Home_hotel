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
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: booking -->
            <tr>
                <td class="text-center">{BOOKING.booking_id}</td>
                <td>
                    <!-- BEGIN: room -->
                    <b>{ROOM.room_name} x {ROOM.quanlity}</b><p class="text-danger"><b>Giá :</b>{ROOM.price}₫</p>
                    <!-- END: room -->
                </td>
                <td>
                    <p><b>Tên:</b> {BOOKING.user_name}</p>
                    <p><b>Email:</b> {BOOKING.user_email}</p>
                    <p><b>SĐT:</b> {BOOKING.user_phone}</p>
                </td>
                <td class="text-center">{BOOKING.checkin}</td>
                <td class="text-center">{BOOKING.checkout}</td>
                <td class="text-center">
                    <p ><b>Tổng tiền:</b> <span class="text-danger">{BOOKING.total_price} ₫</span></p>

                </td>
                <td class="text-center">{BOOKING.status_label}</td>
                <td class="text-center">
                   <!-- BEGIN: pending_action -->
                   <a href="{BOOKING.confirm_url}" class="btn btn-success">Xác nhận</a>
                   <a href="{BOOKING.cancel_url}" class="btn btn-danger">Hủy</a>
                   <!-- END: pending_action -->
                   
                   <!-- BEGIN: no_action -->
                   Không có hành động
                   <!-- END: no_action -->
                </td>
            </tr>
            <!-- END: booking -->
        </tbody>
    </table>
</div>
<!-- END: main -->
