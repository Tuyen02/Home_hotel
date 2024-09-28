<!-- BEGIN: main -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Display:ital,wght@0,100..900&display=swap" rel="stylesheet">

<nav class="navbar bg-white navbar-expand-lg" role="navigation">
    <div class="container-fluid">
        <div class="navbar-collapse" id="menu-site-default">
            <ul class="navbar-nav flex-column">
                <h3 class="mb-3 fw-bold">Liên kết</h3>
                <!-- BEGIN: top_menu -->
                <li class="nav-item {TOP_MENU.current}">
                    <a class="nav-link {TOP_MENU.current}" href="{TOP_MENU.link}" title="{TOP_MENU.note}" {TOP_MENU.target}>
                        <!-- BEGIN: icon -->
                        <img src="{TOP_MENU.icon}" alt="{TOP_MENU.note}" />&nbsp;
                        <!-- END: icon -->
                        {TOP_MENU.title_trim}
                    </a>
                </li>
                <!-- END: top_menu -->
            </ul>
        </div>
    </div>
</nav>
<style>
    .navbar-nav .nav-item {
    margin-bottom: 10px;
}

.navbar-nav .nav-link {
    color: #000; /* Màu chữ */
    padding: 0;
    font-size: 18px;
}

.navbar-nav .nav-link:hover {
    background-color: whitesmoke; /* Màu nền khi hover */
}
</style>

<!-- END: main -->
