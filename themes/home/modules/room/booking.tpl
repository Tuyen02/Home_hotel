<!-- BEGIN: main-->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/custom.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<div class="container pt-5 mt-5">
    <!-- Date and Guest Selection -->
    <div class="row my-3 rounded border bg-white">
        <h2 class="mb-4 title-text">Chọn thời gian đặt phòng và loại phòng</h2>
        <form id="room-booking-form" action="{NV_BASE_SITEURL}" method="GET">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}">
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}">
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}">
            <div class="row align-items-end">
                <div class="col-lg-3 mb-3">
                    <label class="form-label label-text">Ngày nhận phòng</label>
                    <input type="date" id="check-in" name="checkin" value="{CHECKIN}"
                        class="form-control shadow-none fs-4" required="" >
                </div>
                <div class="col-lg-3 mb-3">
                    <label class="form-label label-text">Ngày trả phòng</label>
                    <input type="date" id="check-out" name="checkout" value="{CHECKOUT}"
                        class="form-control shadow-none fs-4" required="">
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label label-text">Người lớn</label>
                    <input type="number" name="adult" value="{ADULT}" class="form-control shadow-none fs-4" min="1"
                        required="">
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label label-text">Trẻ em</label>
                    <input type="number" name="children" value="{CHILDREN}" class="form-control shadow-none fs-4"
                        min="0" required="">
                </div>
                <input type="hidden" name="selected_room[]" id="selected-room-id" value="{SELECTED_ROOMS}">
                <div class="col-lg-2 mb-lg-3 mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-outline-dark shadow-none custom-bg submit-btn fs-4">Chọn
                        phòng</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Room Details and Booking Summary -->
    <div class="row">
        <div class="col-md-8">
            <!-- BEGIN: room -->
            <div class="card mb-3 room-item" data-room-id="{ROOM.id}">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{ROOM.image}" class="img-fluid rounded-start" alt="Room Image">
                    </div>
                    <div class="col-md-8 ">
                        <div class="card-body">
                            <h2 class="card-title">{ROOM.name}</h2>
                            <span class="fs-4">Diện tích: {ROOM.area}m²</span>
                            <ul class="list-inline">
                                <!-- BEGIN: feature -->
                                <li class="list-inline-item fs-4">• {FEATURE}</li>
                                <!-- END: feature -->
                                <!-- BEGIN: facility -->
                                <li class="list-inline-item fs-4">• {FACILITY}</li>
                                <!-- END: facility -->
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ps-3">
                        <p class="text-success fs-4 ">
                            <i class="fa fa-check-circle"></i> Hủy miễn phí!
                            <br>
                            <i class="fa fa-check-circle"></i> Đặt trước, trả sau
                        </p>

                        <span class="fs-4 me-3 room-price">Giá: {ROOM.price_formatted}</span>
                        <div class="d-flex align-items-center">
                            <!-- BEGIN: selected -->
                            <button type="button" class="btn btn-danger text-white fw-bold mx-1 fs-4 decrease-room" data-room-id="{ROOM.id}">-</button>
                            <span class="fs-4 mx-2">{SELECTED_COUNT}</span>
                            <button type="button" class="btn btn-success text-white fw-bold mx-1 fs-4 increase-room" data-room-id="{ROOM.id}">+</button>
                            <!-- END: selected -->
                            <!-- BEGIN: not_selected -->
                            <button type="button" class="btn btn-info text-white fw-bold mx-3 w-40 fs-4 select-room" data-room-id="{ROOM.id}">
                                Chọn phòng
                            </button>
                            <!-- END: not_selected -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: room -->

            <!-- BEGIN: no_rooms -->
            <p>Không tìm thấy phòng nào phù hợp với yêu cầu của bạn.</p>
            <!-- END: no_rooms -->
        </div>

        <!-- Booking Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    [SUMMARY]
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateRoomSelection(roomId, action) {
            const currentUrl = new URL(window.location.href);
            let selectedRooms = currentUrl.searchParams.getAll('selected_room[]');
            
            if (action === 'increase') {
                selectedRooms.push(roomId);
            } else if (action === 'decrease') {
                const index = selectedRooms.lastIndexOf(roomId);
                if (index !== -1) {
                    selectedRooms.splice(index, 1);
                }
            }
            
            currentUrl.searchParams.delete('selected_room[]');
            selectedRooms.forEach(id => {
                currentUrl.searchParams.append('selected_room[]', id);
            });
            
            window.location.href = currentUrl.toString();
        }

        document.querySelectorAll('.select-room').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const roomId = this.getAttribute('data-room-id');
                updateRoomSelection(roomId, 'increase');
            });
        });

        document.querySelectorAll('.increase-room').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const roomId = this.getAttribute('data-room-id');
                updateRoomSelection(roomId, 'increase');
            });
        });

        document.querySelectorAll('.decrease-room').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const roomId = this.getAttribute('data-room-id');
                updateRoomSelection(roomId, 'decrease');
            });
        });
    });
    var today = new Date().toISOString().split('T')[0];
    
    // Thiết lập thuộc tính `min` cho trường nhập ngày
    document.getElementById("check-in").setAttribute("min", today);
    document.getElementById("check-out").setAttribute("min", today);
</script>
<!-- END: main-->