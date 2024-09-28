<!-- BEGIN: main -->
<style>
    #header{
        display: sticky;
    }

    .room-block-wrapper {
        display: flex;
        flex-wrap: wrap;
    }

    .room-block {
        flex: 1 1 calc(33.333% - 20px);
        /* Điều chỉnh kích thước của block */
        margin: 10px;
        display: flex;
        flex-direction: column;
    }

    .room-block .card-body {
        flex-grow: 1;
        /* Tạo khoảng trống để chiều cao được giãn đều */
    }
    a.btn {
    color: #000000;
    }

</style>
<div class="room-block-wrapper">
    <!-- BEGIN: room -->
    <div class="room-block col-lg-12 col-md-12 col-sm-12 my-3">
        <div class="card border-0 shadow w-100" style="margin: auto;">
            <!-- Ảnh phòng -->
            <!-- BEGIN: image -->
            <img src="{IMAGE}" class="card-img-top img-fluid" alt="{ROOM.room_name}">
            <!-- END: image -->
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="mb-4 fw-bold ">{ROOM.room_name}</h2>
                    <h4 class="mb-4" style="font-size: 1.5rem; font-weight: bold; color:red;">{ROOM.price}</h4>
                    <div class="guests mb-4">
                        <h4 class="mb-1 fw-bold ">Số lượng khách tối đa</h4>
                        <span class="fs-4 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 fw-normal">
                            {ROOM.adult} Người lớn
                        </span>
                        <span class="fs-4 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 fw-normal">
                            {ROOM.children} Trẻ em
                        </span>
                    </div>
                    <div class="features mb-4">
                        <h4 class="mb-1 fw-bold  ">Đặc điểm</h4>
                        <!-- BEGIN: feature -->
                        <span
                            class="fs-4 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 fw-normal feature-item">
                            {FEATURE}
                        </span>
                        <!-- END: feature -->
                    </div>
                    <div class="facilities mb-4" margin-bottom="30px">
                        <h4 class="mb-1 fw-bold ">Tiện nghi</h4>
                        <!-- BEGIN: facility -->
                        <span
                            class="fs-4 badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 fw-normal facility-item">
                            {FACILITY}
                        </span>
                        <!-- END: facility -->
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-evenly mb-4">
                <a href="{ROOM.booking_url}" class="btn text-white btn-info shadow-none fw-bold  fs-4">Đặt ngay</a>
                <a href="{ROOM.view_url}" class="btn btn-outline-dark shadow-none fw-bold  fs-4"
                    >Chi tiết</a>
            </div>
        </div>
    </div>
    <!-- END: room -->
</div>
<!-- END: main -->