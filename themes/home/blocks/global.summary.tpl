<!-- BEGIN: main -->
<div class="card">
    <div class="card-body">
        <h2 class="card-title">Thông tin đặt phòng</h2>
        <!-- BEGIN: has_dates -->
        <div class="mb-3">
            <label class="form-label">
                {CHECKIN} <i class="fa fa-arrows-h" ></i> {CHECKOUT}
                <i class="fa fa-arrow-right"></i><span class="text-muted">{NUMBER_OF_NIGHTS} đêm</span>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">{ADULT} người lớn, {CHILDREN} trẻ em</label>
        </div>
        <!-- END: has_dates -->
        <!-- BEGIN: no_dates -->
        <p>Vui lòng chọn ngày nhận phòng và trả phòng.</p>
        <!-- END: no_dates -->
        <h3 class="mb-3">Danh sách phòng đã chọn</h3>
        <ul id="selected-rooms" class="list-unstyled">
            {ROOM_LIST}
        </ul>
        
        <p class="card-text fw-bold fs-4">Tổng tiền: <span id="total-price">{TOTAL_PRICE}</span></p>
        <form action="{CONFIRM_URL}" method="GET">
            <input type="hidden" name="checkin" value="{CHECKIN_VALUE}">
            <input type="hidden" name="checkout" value="{CHECKOUT_VALUE}">
            <input type="hidden" name="adult" value="{ADULT_VALUE}">
            <input type="hidden" name="children" value="{CHILDREN_VALUE}">
            <input type="hidden" name="selected_rooms" value="{SELECTED_ROOMS}">
            <button type="submit" class="btn btn-success form-control fs-4" id="confirm-booking-btn">
                Tiến hành thanh toán.
            </button>
        </form>
    </div>
</div>      
<!-- END: main -->