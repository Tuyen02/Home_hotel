<!-- BEGIN: main -->

<div class="carousel-container">
    <div class="swiper swiper-container">
        <div class="swiper-wrapper">
            <!-- BEGIN: carousel -->
            <div class="swiper-slide">
                <img src="/uploads/room/carousel/{ROW.image}" class="w-100 d-block" />
            </div>
            <!-- END: carousel -->
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    .carousel-container {
        width: 100%;
        height: 70vh; /* Tăng chiều cao lên một chút */
        overflow: hidden;
        position: relative;
    }
    .swiper-container {
        width: 100%;
        height: 100%;
    }
    .swiper-slide {
        width: 100%;
        height: 100%;
    }
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<script>
var swiper = new Swiper(".swiper-container", {
    spaceBetween: 0,
    effect: "fade",
    loop: true,
    autoplay: {
        delay: 3500,
        disableOnInteraction: false,
    }
});
</script>
<!-- END: main -->
