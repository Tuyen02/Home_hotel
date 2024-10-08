<!-- BEGIN: main -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/custom.css" />
<div class="container py-5 my-5">
    <div class="row my-4 py-4">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold fs-1">{ROOM.name}</h2>
        </div>
        <div class="col-lg-7 col-md-12 px-4 align-items-center">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- BEGIN: carousel -->
                    <div class="carousel-item {ACTIVE}">
                        <img src="{IMAGE}" class="d-block w-100 rounded">
                    </div>
                    <!-- END: carousel -->
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Trước</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Tiếp theo</span>
                </button>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <h3>Giá: <span class="text-danger">{ROOM.price}</span></h3>
                    <div class="mb-3">
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">Đặc điểm</h3>
                        <!-- BEGIN: feature -->
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">{FEATURE}</span>
                        <!-- END: feature -->
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">Tiện nghi</h3>
                        <!-- BEGIN: facility -->
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">{FACILITY}</span>
                        <!-- END: facility -->
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">Khách</h3>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">{ROOM.adult} Người lớn</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">{ROOM.children} Trẻ em</span>
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">Diện tích</h3>
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">{ROOM.area}
                            m<sup>2</sup></span>
                    </div>
                    <a href="{ROOM.booking_url}" class="btn w-100 btn-info text-white fw-bold shadow-none mb-1 fs-4">Đặt
                        ngay</a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4 px-4">
            <div class="mb-5">
                <h2 class="title">Mô tả</h3>
                    <p>{ROOM.description}</p>
            </div>
        </div>
    </div>
</div>
<!-- END: main -->