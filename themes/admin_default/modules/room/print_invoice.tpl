<!-- BEGIN: main -->
<h1>Hóa Đơn Đặt Phòng</h1>
<p>Mã Đặt Phòng: {BOOKING.booking_id}</p>
<p>Tên Người Dùng: {BOOKING.user_name}</p>
<p>Email: {BOOKING.user_email}</p>
<p>SĐT: {BOOKING.user_phone}</p>
<p>Tên Phòng: {BOOKING.room_name}</p>
<p>Giá Phòng: {BOOKING.room_price} ₫</p>
<p>Ngày Nhận Phòng: {BOOKING.checkin}</p>
<p>Ngày Trả Phòng: {BOOKING.checkout}</p>
<p>Tổng Giá: {BOOKING.total_price} ₫</p>
<button onclick="window.print()">In hóa đơn</button>
<!-- END: main -->