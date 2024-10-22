<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/home/css/custom.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<div class="container confirm-booking pt-5 mt-5">
    <!-- BEGIN: message -->
<div class="alert alert-info">
    {MESSAGE}
</div>
<!-- END: message -->
    <div class="row bg-white rounded border p-3">
        <!-- Thông tin phòng đã chọn -->
        <div class="col-md-6 border-end">
            <h1 class="mb-3">{LANG.book_info}</h1>
            <div class="mb-3">
                {LANG.book_time}:
                <label class="form-label">
                    {CHECKIN} <i class="fa fa-arrows-h"></i> {CHECKOUT}
                </label>
                <p>{LANG.rule1} {CHECKIN} {LANG.rule2}</p>
            </div>
            <div class="mb-3">
                {LANG.guest}
                <label class="form-label">{ADULT} {LANG.adult}, {CHILDREN} {LANG.children}</label>
            </div>
            <div class="selected-rooms pe-2">
                {LANG.selected_room}: 
                <!-- BEGIN: selected_rooms -->
                <div class="room row border rounded mb-3" id="room_{ROOM.id}">
                    <div class="col-lg-5">
                        <img src="{ROOM.image}" alt="{ROOM.name}" class="img-fluid">
                    </div>
                    <div class="col-lg-7">
                        <h2>{ROOM.name}</h2>
                        <p>{LANG.price}: {ROOM.price}₫</p>
                        <p>{LANG.quantity}: {ROOM.selected_count}</p>
                    </div>
                </div>
                <!-- END: selected_rooms -->
            </div>
        </div>

        <!-- Form nhập thông tin cá nhân và phương thức thanh toán -->
        <div class="col-md-6">
            <h1 class="mb-3">{LANG.guest_info}</h1>
            <form class="confirm-reload" method="post" action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" id="booking-form">
                <input type="hidden" name="checkin" value="{CHECKIN}">
                <input type="hidden" name="checkout" value="{CHECKOUT}">
                <input type="hidden" name="adult" value="{ADULT}">
                <input type="hidden" name="children" value="{CHILDREN}">
                <input type="hidden" name="selected_rooms" value="{SELECTED_ROOMS}">
                <input type="hidden" name="payment_method" value="{POST.payment_method}">
                
                <div class="mb-3">
                    <label for="fullname" class="form-label">{LANG.fullname}</label>
                    <input type="text" class="form-control fs-4" id="fullname" name="fullname" value="{POST.fullname}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{LANG.email}</label>
                    <input type="email" class="form-control fs-4" id="email" name="email" value="{POST.email}" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">{LANG.phone_number}</label>
                    <input type="tel" class="form-control fs-4" id="phone" name="phone" value="{POST.phone}" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">{LANG.address}</label>
                    <input type="text" class="form-control fs-4" id="address" name="address" value="{POST.address}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">{LANG.payment_method}</label>
                    <select class="form-control fs-4" name="payment_method" required>
                        <option class="form-label fw-light fs-4" selected disabled>{LANG.choose_payment_method}</option>
                        <option class="form-label fs-4" value="0">{LANG.payment_method_1}</option>
                        <option class="form-label fs-4" value="1">{LANG.payment_method_2}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary form-control my-4 fs-3" name="submit" value="1">{LANG.btn_send_book}</button>
            </form>
        </div>
    </div>
</div>
<script>
</script>

<!-- END: main -->
