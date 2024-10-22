<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/home/css/custom.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<div class="container mt-5">
    <div class="invoice-container p-4 border rounded shadow-sm">
        <h2 class="text-center mb-4">{LANG.bill}</h2>

        <!-- Thông tin khách sạn -->
        <div class="hotel-info text-center mb-5">
            <p class="fw-bold">{LANG.hotel_name}</p>
            <p>{LANG.hotel_address}</p>
            <p>{LANG.hotel_phone}</p>
            <p>{LANG.hotel_email}</p>
        </div>

        <!-- Thông tin đặt phòng -->
        <div class="invoice-details mb-4">
            <p><strong>{LANG.book_id}:</strong> {BOOKING.booking_id}</p>
            <p><strong>{LANG.guest_name}:</strong> {BOOKING.user_name}</p>
            <p><strong>{LANG.phone_number}:</strong> {BOOKING.user_phone}</p>
            <p><strong>{LANG.check_in}:</strong> {BOOKING.checkin}</p>
            <p><strong>{LANG.check_out}:</strong> {BOOKING.checkout}</p>
            <p><strong>{LANG.total_price}:</strong> {BOOKING.total_price} VND</p>
            <p><strong>{LANG.status}:</strong> {BOOKING.status_label}</p>
            <p>{LANG.note1}</p>
        </div>

        <!-- Chi tiết các phòng đã đặt -->
        <div class="room-details mb-4">
            <h3 class="mb-3">{LANG.book_detail}</h3>
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th scope="col">{LANG.room_name}</th>
                        <th scope="col" class="text-end">{LANG.room_price}</th>
                        <th scope="col" class="text-end">{LANG.sum_bill}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: booking.room -->
                    <tr>
                        <td>{ROOM.room_name}</td>
                        <td class="text-end">{ROOM.price} VND</td>
                        <td class="text-end">{BOOKING.total_price} VND</td>
                    </tr>
                    <!-- END: booking.room -->
                </tbody>
            </table>
        </div>

        <!-- Thông tin thanh toán -->
        <div>
            <p><strong>Hình thức thanh toán:</strong></p>
            <p>Nếu khách hàng <strong>thanh toán trực tuyến</strong> thì vui lòng chuyển khoản với nội dung: <strong>Tên khách hàng: ... Mã đặt phòng: ... đã thanh toán.</strong></p>
            <p>Vui lòng thanh toán chuyển khoản vào tài khoản sau:</p>
            <div class="text-center">
                <img src="/uploads/room/qr.jpg" alt="QR Code" class="img-fluid" style="max-width: 300px;">
            </div>
            <p class="mt-3 text-danger">Quý khách vui lòng có mặt tại sảnh khách sạn trước 1h chiều ngày {BOOKING.checkin} để nhận phòng.</p>
            <p class=" text-danger">Trong trường hợp khách hàng không đến hoặc đến muộn, đơn đặt phòng sẽ bị hủy.</p>
            <p class=" text-danger">Khách hàng sẽ trao đổi với khách sạn để được xử lý trong trường hợp này.</p>
            <p class=" text-danger">Trường hợp khách hàng chọn thanh toán trực tiếp cũng tương tự như vậy.</p>
        </div>
        <div>
            <h2 class="mt-4 text-center title">Cảm ơn đã sử dụng dịch vụ của khách sạn</h2>
        </div>
    </div>
</div>
<!-- END: main -->
