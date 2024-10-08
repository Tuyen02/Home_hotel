<!-- BEGIN: main -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&family=Merienda:wght@300..900&display=swap"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"	href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/custom.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="wraper py-5 my-5">
    <div class="py-5 my-5">
        <h1 class="fw-bold h-font text-center title-text h-font">Phòng của chúng tôi</h1>
        <div class="h-line bg-dark"></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow sticky-top">
                    [FILTER]
                </nav>
            </div>
            <div class="col-lg-9 col-md-12 px-4" id="room-results">
                <!-- Hiển thị thông tin phòng từ PHP -->
                <!-- BEGIN: room -->
                <div class="card mb-4 border-0 shadow" data-facilities="{ROOM.facilities}">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                            <img src="{ROOM.image}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h2 class="mb-3 title">{ROOM.name}</h2>
                            <div class="features mb-3">
                                <h3 class="mb-1">Đặc điểm</h3>
                                <!-- Hiển thị các đặc điểm phòng từ PHP -->
                                <!-- BEGIN: feature -->
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                                    {FEATURE}
                                </span>
                                <!-- END: feature -->
                            </div>
                            <div class="facilities mb-3">
                                <h3 class="mb-1">Tiện ích</h3>
                                <!-- Hiển thị các tiện nghi phòng từ PHP -->
                                <!-- BEGIN: facility -->
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                                    {FACILITY}
                                </span>
                                <!-- END: facility -->
                            </div>
                            <div class="guests">
                                <h3 class="mb-1">Guests</h3>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    {ROOM.adult} Người lớn
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    {ROOM.children} Trẻ em
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                            <h4 class="mb-4 fs-5"><span class="text-danger">{ROOM.price_formatted}</span></h4>
                            <a href="{ROOM.booking_url}"
                                class="btn btn-info text-white fw-bold w-100 shadow-none mb-2 fs-4">Đặt ngay</a>
                            <a href="{ROOM.view_url}" class="btn w-100 btn-outline-dark fw-bold shadow-none fs-4">Chi
                                tiết</a>
                        </div>
                    </div>
                </div>
                <!-- END: room -->
                <!-- BEGIN: no_rooms -->
                <div class="alert alert-warning">Không có phòng nào phù hợp với yêu cầu của bạn.</div>
                <!-- END: no_rooms -->

                <!-- BEGIN: pagination -->
                <nav aria-label="Page navigation">{GENERATE_PAGE}</nav>
                <!-- END: pagination -->
            </div>
        </div>
    </div>
</div>

<script>
    function filterRooms() {
        let checkin = $('#checkin').val();
        let checkout = $('#checkout').val();
        let adult = $('#adult').val();
        let children = $('#children').val();

        const facilityFilters = Array.from(document.querySelectorAll('input[name="facilities[]"]:checked'))
            .map(input => input.value);

        window.location = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&adult=' + adult;
    }
</script>
<!-- END: main -->