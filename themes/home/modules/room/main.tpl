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
<style>
    .slimmenu a.nav-link {
        font-size: 20px;
        font-weight: 500;
    }

    .slimmenu a.nav-link:hover,
    .slimmenu a.nav-link.active {
        background-color: #f8f9fa;
        color: black;
    }

    .h-font {
        font-family: 'Merienda', cursive;
    }

    .custom-btn-outline-dark {
        color: #000;
        background-color: #fff;
        border-color: #000;
    }

    * {
        font-size: 20px;
        box-sizing: border-box;
    }

    #header {
        height: 80px;
        position: sticky;
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
    a.btn {
    color: #000000;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- BEGIN: no_rooms -->
<div class="alert alert-warning">{NO_ROOMS_MESSAGE}</div>
<!-- END: no_rooms -->

<div class="wraper">
    <div class="mt-5 px-4 mb-4 py-5">
        <h1 class="fw-bold h-font text-center title-text h-font">Phòng của chúng tôi</h1>
        <div class="h-line bg-dark"></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h2 class="mt-2">Bộ lọc</h2>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <!-- Check availablity -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Kiểm tra phòng tồn tại</span>
                                </h5>
                                <label class="form-label">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-3 fs-4" value="" id="checkin"
                                    aria-label="Check-in Date" onchange="chk_avail_filter()">
                                <label class="form-label">Check-out</label>
                                <input type="date" class="form-control shadow-none fs-4" value="" id="checkout"
                                    aria-label="Check-out Date" onchange="chk_avail_filter()">
                            </div>

                            <!-- Facilities -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Tiện ích</span>
                                </h5>
                                <!-- BEGIN: facility_filter -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none mt-3" type="checkbox"
                                            name="facilities[]" value="{FACILITY_FILTER.id}"
                                            onchange="filterRooms()" />
                                        <label class="form-check-label fw-light mt-1">{FACILITY_FILTER.name}</label>
                                    </div>
                                </div>
                                <!-- END: facility_filter -->
                            </div>

                            <!-- Guests -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Khách hàng</span>
                                    <button id="guests_btn" onclick="guests_clear()"
                                        class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label">Adults</label>
                                        <input type="number" min="1" id="adults" value="" oninput="guests_filter()"
                                            class="form-control shadow-none fs-4">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="number" min="1" id="children" value="" oninput="guests_filter()"
                                            class="form-control shadow-none fs-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <h3 class="mb-1">Features</h3>
                                <!-- Hiển thị các đặc điểm phòng từ PHP -->
                                <!-- BEGIN: feature -->
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                                    {FEATURE}
                                </span>
                                <!-- END: feature -->
                            </div>
                            <div class="facilities mb-3">
                                <h3 class="mb-1">Facilities</h3>
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
                                    {ROOM.adult} Adults
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    {ROOM.children} Children
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                            <h4 class="mb-4 fs-5"><span class="text-danger">{ROOM.price}</span></h4>
                            <button class="btn btn-info text-white fw-bold w-100 shadow-none mb-2 fs-4">Book
                                Now</button>
                            <a href="{ROOM.view_url}"
                                class="btn w-100 btn-outline-dark fw-bold shadow-none fs-4">More details</a>
                        </div>
                    </div>
                </div>
                <!-- END: room -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tải danh sách phòng mặc định khi trang được tải lên
        filterRooms();
    });

    function chk_avail_filter() {
        const checkin = document.getElementById('checkin').value;
        const checkout = document.getElementById('checkout').value;

        if (checkin && checkout && new Date(checkout) <= new Date(checkin)) {
            alert("Ngày trả phòng phải sau ngày nhận phòng!");
            return;
        }

        filterRooms();
    }

    function guests_filter() {
        const adults = document.getElementById('adults').value;
        const children = document.getElementById('children').value;

        if (adults || children) {
            document.getElementById('guests_btn').classList.remove('d-none');
        } else {
            document.getElementById('guests_btn').classList.add('d-none');
        }

        filterRooms();
    }

    function filterRooms() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;
    const adults = document.getElementById('adults').value;
    const children = document.getElementById('children').value;
    const facilities = [...document.querySelectorAll('input[name="facilities[]"]:checked')].map(el => el.value);

    // Gửi request đến main.php hoặc gọi xử lý PHP để lấy danh sách phòng
    fetch('main.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest', // Thêm dòng này để đánh dấu là AJAX request
        },
        body: JSON.stringify({
            checkin: checkin,
            checkout: checkout,
            adults: adults,
            children: children,
            facilities: facilities,
        }),
    })
        .then(response => response.json())
        .then(data => {
            const roomContainer = document.getElementById('room-results');
            roomContainer.innerHTML = ''; // Xóa kết quả cũ

            if (data.rooms && data.rooms.length > 0) {
                data.rooms.forEach(room => {
                    const roomHTML = `
                        <div class="card mb-4 border-0 shadow" data-facilities="${room.facilities}">
                            <div class="row g-0 p-3 align-items-center">
                                <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                    <img src="${room.image}" class="img-fluid rounded">
                                </div>
                                <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                    <h2 class="mb-3 title">${room.name}</h2>
                                    <div class="features mb-3">
                                        <h3 class="mb-1">Features</h3>
                                        ${room.features.map(feature => `
                                            <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                                                ${feature}
                                            </span>`).join('')}
                                    </div>
                                    <div class="facilities mb-3">
                                        <h3 class="mb-1">Facilities</h3>
                                        ${room.facilities.map(facility => `
                                            <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">
                                                ${facility}
                                            </span>`).join('')}
                                    </div>
                                    <div class="guests">
                                        <h3 class="mb-1">Guests</h3>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            ${room.adult} Adults
                                        </span>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            ${room.children} Children
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                    <h4 class="mb-4 fs-5"><span class="text-danger">${room.price}</span>đ/đêm</h4>
                                    <button class="btn btn-info text-white fw-bold w-100 shadow-none mb-2 fs-4">Book Now</button>
                                    <a href="${room.view_url}" class="btn w-100 btn-outline-dark fw-bold shadow-none fs-4">More details</a>
                                </div>
                            </div>
                        </div>`;
                    roomContainer.innerHTML += roomHTML;
                });
            } else {
                roomContainer.innerHTML = '<div class="alert alert-warning">Không có phòng nào phù hợp.</div>';
            }
        })
        .catch(error => console.error('Lỗi:', error));
}


    function guests_clear() {
        document.getElementById('adults').value = '';
        document.getElementById('children').value = '';
        guests_filter();
    }
</script>

