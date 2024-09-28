<!-- BEGIN: main -->
<span class="visible-xs-inline-block">
    <a title="{LANG.joinnow}" class="pointer button" data-toggle="tip" data-target="#socialList" data-click="y">
        <em class="fa fa-share-alt fa-lg"></em>
        <span class="hidden">{LANG.joinnow}</span>
    </a>
</span>
<div id="socialList" class="content">
    <h3 class="mb-3 fw-bold">Mạng xã hội của chúng tôi</h3>
    <h3 class="visible-xs-inline-block">{LANG.joinnow}</h3>
    <ul class="socialList">
        <!-- BEGIN: facebook -->
        <li><a href="{DATA.facebook}" target="_blank"><i class="fa fa-facebook-official"></i></a></li>
        <!-- END: facebook -->
        <!-- BEGIN: youtube -->
        <li><a href="{DATA.youtube}" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
        <!-- END: youtube -->
        <!-- BEGIN: instagram -->
        <li><a href="{DATA.instagram}" target="_blank"><i class="fa fa-instagram"></i></a></li>
        <!-- END: instagram -->
    </ul>
</div>
<style>
    /* Thiết lập menu theo dạng dọc */
ul.socialList {
    list-style: none;
    padding: 0;
    margin: 0;
}

ul.socialList li {
    margin-bottom: 10px;
    margin-left: 10px; /* Khoảng cách giữa các mục */
}

/* Đổi nền từ xanh thành đen trắng */
ul.socialList li a {
    display: inline-block;
    background-color: #fff; /* Nền trắng */
    color: #000; /* Biểu tượng màu đen */
    padding: 10px;
    border-radius: 50%;
    transition: background-color 0.3s ease, color 0.3s ease;
}

ul.socialList li a:hover {
    background-color: #ffffff; /* Nền đen khi hover */
    color: #000000; /* Biểu tượng màu trắng khi hover */
}

/* Kích thước và căn chỉnh biểu tượng */
ul.socialList li a i {
    font-size: 30px; /* Kích thước biểu tượng */
    text-align: center;
    width: 30px;
}
</style>
<!-- END: main -->
