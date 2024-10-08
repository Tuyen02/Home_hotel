<!-- BEGIN: main -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<style>
    #header {
        display: sticky;
    }

    .availability-form {
        margin-top: -50px;
        z-index: 2;
        position: relative;
        font-family: 'Noto Sans', sans-serif; /* Đồng bộ font chữ */
        font-size: 20px; /* Cỡ chữ đồng bộ */
    }

    @media screen and (max-width: 575px) {
        .availability-form {
            margin-top: 25px;
            padding: 0 35px;
        }
    }

    .custom-bg {
        background-color: #2ec1ac;
    }

    .custom-bg:hover {
        background-color: #279e8c;
    }

    .title-text {
        font-size: 2.2rem;
        font-weight: 600;
    }

    .label-text {
        font-size: 18px;
        font-weight: 600;
    }

    .submit-btn {
        font-size: 1.2rem;
        font-weight: 500;
        height: 35px;
    }
</style>

<div class="container-fluid flex-lg-column align-items-stretch">
    <h2 class="mt-2">Bộ lọc</h2>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
        <form id="filter-form" action="{FILTER_URL}" method="GET">
            <!-- Check availability -->
            <div class="border bg-light p-3 rounded mb-2">
                <h5 class="d-flex align-items-center justify-content-between mb-2">
                    <span>Tìm phòng tồn tại</span>
                </h5>
                <label class="form-label">Check-in</label>
                <input type="date" name="checkin" class="form-control shadow-none mb-2 fs-4" id="checkin" value="{CHECKIN}" aria-label="Check-in Date">
                <label class="form-label">Check-out</label>
                <input type="date" name="checkout" class="form-control shadow-none fs-4" id="checkout" value="{CHECKOUT}" aria-label="Check-out Date">
            </div>

            <!-- Facilities -->
            <div class="border bg-light p-3 rounded mb-2">
                <h5 class="d-flex align-items-center justify-content-between mb-2">
                    <span>Tiện ích</span>
                </h5>
                <!-- BEGIN: facility_filter -->
                <div>
                    <input class="form-check-input shadow-none mt-2" type="checkbox" name="facilities[]" value="{FACILITY_FILTER.id}" />
                    <label class="form-check-label fw-light">{FACILITY_FILTER.name}</label>
                </div>
                <!-- END: facility_filter -->
            </div>

            <!-- Guests -->
            <div class="border bg-light p-3 rounded mb-2">
                <h5 class="d-flex align-items-center justify-content-between mb-2">
                    <span>Khách hàng</span>
                </h5>
                <div class="d-flex">
                    <div class="me-3">
                        <label class="form-label">Người lớn</label>
                        <input type="number" name="adult" min="1" id="adult" value="{ADULT}" class="form-control shadow-none fs-4">
                    </div>
                    <div>
                        <label class="form-label">Trẻ em</label>
                        <input type="number" name="children" min="0" id="children" value="{CHILDREN}" class="form-control shadow-none fs-4">
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn custom-bg submit-btn text-white w-100 fs-3">Tìm kiếm</button>
        </form>
    </div>
</div>

<!-- END: main -->
