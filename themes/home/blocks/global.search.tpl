<!-- BEGIN: main -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;600&display=swap" rel="stylesheet">
    <title>Khách Sạn Home</title>
    <style>
        #header{
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
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4 title-text ">Tìm kiếm phòng phù hợp</h5>
                <form action="{SEARCH_URL}" method="POST">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label label-text ">Ngày nhận phòng</label>
                            <input type="date" class="form-control shadow-none fs-4" id="check-in" onfocusout="formatDate(this)" style="height: 35px;">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label label-text ">Ngày trả phòng</label>
                            <input type="date" class="form-control shadow-none fs-4" id="check-out" onfocusout="formatDate(this)" style="height: 35px;">
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label label-text ">Người lớn</label>
                            <input type="number" class="form-control shadow-none fs-4" id="adults" style="height: 35px;" placeholder="2">
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label label-text ">Trẻ em</label>
                            <input type="number" class="form-control shadow-none fs-4" id="childrens" style="height: 35px;" placeholder="1">
                        </div>
                        <div class="col-lg-2 mb-lg-3 mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn text-white shadow-none custom-bg submit-btn fs-4">Tìm phòng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- END: main -->
