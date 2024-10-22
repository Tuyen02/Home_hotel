<!-- BEGIN: main -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/custom.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<div class="container">
    <div class="row mt-3 pt-3">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold fs-1">{ROOM.name}</h2>
        </div>
        <div class="col-lg-7 col-md-12 px-4 align-items-center">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <!-- BEGIN: carousel -->
                    <div class="swiper-slide"><img src="{IMAGE}" class="d-block w-100 rounded"></div>
                    <!-- END: carousel -->
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
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
                        <h3 class="mb-1">{LANG.fea}</h3>
                        <!-- BEGIN: feature -->
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">{FEATURE}</span>
                        <!-- END: feature -->
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">{LANG.fac}</h3>
                        <!-- BEGIN: facility -->
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">{FACILITY}</span>
                        <!-- END: facility -->
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">{LANG.guest}</h3>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">{ROOM.adult} {LANG.adult}</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">{ROOM.children} {LANG.children}</span>
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">{LANG.area}</h3>
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">{ROOM.area}
                            m<sup>2</sup></span>
                    </div>
                    <div class="mb-3">
                        <h3 class="mb-1">{LANG.description}</h3>
                        <p class="fs-3 fw-normal">{ROOM.description}</p>
                    </div>
                    <a href="{ROOM.booking_url}" class="btn w-100 btn-info text-white fw-bold shadow-none mb-1 fs-4">{LANG.btn_book}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>
<!-- END: main -->