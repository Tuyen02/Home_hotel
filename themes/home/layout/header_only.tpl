<!DOCTYPE html>
    <html lang="{LANG.Content_Language}" xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns#">
    <head>
        <title>{THEME_PAGE_TITLE}</title>
        <!-- BEGIN: metatags --><meta {THEME_META_TAGS.name}="{THEME_META_TAGS.value}" content="{THEME_META_TAGS.content}">
        <!-- END: metatags -->
        <link rel="shortcut icon" href="{SITE_FAVICON}">
        <!-- BEGIN: links -->
        <link<!-- BEGIN: attr --> {LINKS.key}<!-- BEGIN: val -->="{LINKS.value}"<!-- END: val --><!-- END: attr -->>
        <!-- END: links -->
        <!-- BEGIN: js -->
        <script<!-- BEGIN: ext --> src="{JS_SRC}"<!-- END: ext -->><!-- BEGIN: int -->{JS_CONTENT}<!-- END: int --></script>
        <!-- END: js -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "url": "{NV_MY_DOMAIN}",
            "logo": "{NV_MY_DOMAIN}{LOGO_SRC}"
        }
        </script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <style>
            .slimmenu a.nav-link {
                font-size: 20px; /* Cỡ chữ đồng bộ */
                font-weight: 500;
            }
        
            .slimmenu > li > ul {
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
            color: #000; /* Màu chữ ban đầu là đen */
            background-color: #fff; /* Nền trắng */
            border-color: #000; /* Đường viền đen */
            }
        
            .custom-btn-outline-dark:hover {
                color: #fff; /* Màu chữ chuyển thành trắng khi hover */
                background-color: #000; /* Nền đen khi hover */
            }
            *{
                font-size: 20px;
            }
            #header{
                height: 80px;
                position: sticky;
            }

            #header .dangnhap{
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
                width: fit-content; /* Điều chỉnh để phù hợp với nội dung */
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
            .personalArea{
                margin-left: 100px;
            }
        </style>
    </head>
    <body class="bg-light">
