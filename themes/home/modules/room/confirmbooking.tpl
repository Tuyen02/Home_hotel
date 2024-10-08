<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/home/css/custom.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <style>
        .confirm-booking {
            margin-top: 20px;
        }

        .confirm-booking h2 {
            margin-bottom: 20px;
        }

        .confirm-booking p {
            font-size: 16px;
            line-height: 1.5;
        }

        .form-check-label {
            margin-left: 10px;
        }
        
        .form-control {
            font-size: 18px;
        }
    </style>
<div class="container confirm-booking pt-5 mt-5">
    <!-- BEGIN: message -->
<div class="alert alert-info">
    {MESSAGE}
</div>
<!-- END: message -->
    <div class="row bg-white rounded border p-3">
        <!-- Thông tin phòng đã chọn -->
        <div class="col-md-6 border-end">
            <h1 class="mb-3">Thông tin đặt phòng</h1>
            <div class="mb-3">
                Thời gian đặt phòng:
                <label class="form-label">
                    {CHECKIN} <i class="fa fa-arrows-h"></i> {CHECKOUT}
                </label>
                <p>Quý khách vui lòng có mặt trước 12h ngày {CHECKIN} để checkin nhận phòng</p>
            </div>
            <div class="mb-3">
                Số lượng khách:
                <label class="form-label">{ADULT} người lớn, {CHILDREN} trẻ em</label>
            </div>
            <div class="selected-rooms pe-2">
                Phòng đã chọn: 
                <!-- BEGIN: selected_rooms -->
                <div class="room row border rounded mb-3" id="room_{ROOM.id}">
                    <div class="col-lg-5">
                        <img src="{ROOM.image}" alt="{ROOM.name}" class="img-fluid">
                    </div>
                    <div class="col-lg-7">
                        <h2>{ROOM.name}</h2>
                        <p>Giá: {ROOM.price}₫</p>
                        <p>Số lượng: {ROOM.selected_count}</p>
                    </div>
                </div>
                <!-- END: selected_rooms -->
            </div>
        </div>

        <!-- Form nhập thông tin cá nhân và phương thức thanh toán -->
        <div class="col-md-6">
            <h1 class="mb-3">Thông tin khách hàng</h1>
            <form class="confirm-reload" method="post" action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" id="booking-form">
                <input type="hidden" name="checkin" value="{CHECKIN}">
                <input type="hidden" name="checkout" value="{CHECKOUT}">
                <input type="hidden" name="adult" value="{ADULT}">
                <input type="hidden" name="children" value="{CHILDREN}">
                <input type="hidden" name="selected_rooms" value="{SELECTED_ROOMS}">
                <input type="hidden" name="payment_method" value="{POST.payment_method}">
                
                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="{POST.fullname}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{POST.email}" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{POST.phone}" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" name="address" value="{POST.address}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Phương thức thanh toán</label>
                    <select class="form-control" name="payment_method" required>
                        <option class="form-label fw-light" selected disabled>Lựa chọn phương thức thanh toán</option>
                        <option class="form-label" value="0">Thanh toán trực tiếp</option>
                        <option class="form-label" value="1">Thanh toán online</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary form-control my-4" name="submit" value="1">Gửi yêu cầu đặt phòng</button>
            </form>
        </div>
    </div>
</div>
<script>
</script>

<!-- END: main -->
