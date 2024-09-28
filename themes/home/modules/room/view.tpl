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
<style>
    .slimmenu a.nav-link {
        font-size: 20px;
        /* Cỡ chữ đồng bộ */
        font-weight: 500;
    }

    .slimmenu>li>ul {
        font-family: 'Noto Sans', sans-serif;
        font-size: 1.1rem;
    }

    .slimmenu a.nav-link:hover,
    .slimmenu a.nav-link.active {
        background-color: #f8f9fa;
        color: black;
    }

    .h-font {
        font-family: 'Merienda', cursive;
    }

    .slimmenu li.current a {
        background-color: #f8f9fa;
        color: black;
    }

    .custom-btn-outline-dark {
        color: #000;
        /* Màu chữ ban đầu là đen */
        background-color: #fff;
        /* Nền trắng */
        border-color: #000;
        /* Đường viền đen */
    }

    * {
        font-size: 20px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }


    #header {
        height: 80px;
        position: sticky;
    }

    #header .dangnhap {
        margin-left: 150px;
    }

    .dangnhap a.button.user,
    .dangnhap a.button.user:hover {
        margin-left: 80px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background-color: transparent;
        background-size: contain;
    }

    /* TIP POPUP and FTIP POPUP */
    #tip,
    #ftip {
        position: absolute;
        color: #333 !important;
        background-color: #eee;
        max-width: 300px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        display: none;
    }

    #tip {
        top: 100%;
        right: 0;
        width: 500px !important;
        min-height: 50px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    #tip .bg,
    #ftip .bg {
        padding: 15px;
        border-bottom-color: #aaaaaa;
        border-bottom-width: 1px;
        border-bottom-style: solid;
        font-size: 18px;
    }

    #tip .bg {
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        width: fit-content;
        /* Điều chỉnh để phù hợp với nội dung */
    }

    #tip .tip-footer,
    #ftip .tip-footer {
        background-color: #e5e5e5;
        border-width: 1px;
        border-style: solid;
        border-color: #cccccc;
        padding: 10px;
    }

    #tip .tip-footer {
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        margin: 10px -15px -16px;
    }

    #tip h3,
    #ftip h3 {
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    #tip ul {
        margin: 0;
        padding: 0;
    }

    #tip a {
        color: #333;
    }

    #tip .socialList a {
        color: #fff;
    }

    .h-line {
        width: 150px;
        margin: 0 auto;
        height: 1.7px;
    }

    .form-label {
        font-weight: lighter;
        font-size: 18px;
    }

    .badge {
        font-size: 14px;
        font-weight: 500;
    }

    a.btn {
        color: black;
    }

    #admintoolbar {
        display: block;
        width: 50px;
    }

    #admintoolbar:hover {
        width: 320px;
    }

    .personalArea {
        margin-left: 100px;
    }
</style>
<div class="wraper">
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold fs-1">{ROOM.name}</h2>
            </div>
            <div class="col-lg-7 col-md-12 px-4 align-items-center">
                <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- BEGIN: carousel -->
                        <!-- Nếu đây là mục đầu tiên, thêm class 'active' -->
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
                        <button class="btn w-100 btn-success shadow-none mb-1 fs-4">Đặt ngay</button>
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
</div>
<!-- END: main -->