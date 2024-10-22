<!-- BEGIN: main -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;600&display=swap" rel="stylesheet">
<title>Khách Sạn Home</title>
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/home/css/custom.css" />
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
            <h5 class="mb-4 title-text">Tìm kiếm phòng phù hợp</h5>
            
            <!-- Thay thế action bằng URL tìm kiếm (được gán từ PHP) -->
            <form action="{SEARCH_URL}" method="GET">
                <div class="row align-items-end">
                    <div class="col-lg-3 mb-3">
                        <label class="form-label label-text">Ngày nhận phòng</label>
                        <input type="date" name="checkin" class="form-control shadow-none fs-4" id="dateInput" required>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="form-label label-text">Ngày trả phòng</label>
                        <input type="date" name="checkout" class="form-control shadow-none fs-4" id="dateOutput" required>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label class="form-label label-text">Người lớn</label>
                        <input type="number" name="adult" class="form-control shadow-none fs-4" min="1" value="2" required>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label class="form-label label-text">Trẻ em</label>
                        <input type="number" name="children" class="form-control shadow-none fs-4" min="0" value="1" required>
                    </div>
                    <div class="col-lg-2 mb-lg-3 mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn text-white shadow-none custom-bg submit-btn fs-4">Tìm phòng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Lấy ngày hiện tại theo định dạng YYYY-MM-DD
    var today = new Date().toISOString().split('T')[0];
    
    // Thiết lập thuộc tính `min` cho trường nhập ngày
    document.getElementById("dateInput").setAttribute("min", today);
    document.getElementById("dateOutput").setAttribute("min", today);
  </script>
<!-- END: main -->
