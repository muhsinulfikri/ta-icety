<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="ICETy - Upskill Your Current Career">
    <meta name="keywords"
        content="education,lms,online,tutor,e learning,icety">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- <meta name="author" content="TemplateMo"> --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>ICETy</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets_landing') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/style.css">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/fontawesome.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/fix.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/owl.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/lightbox.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!--

TemplateMo 569 Edu Meeting

https://templatemo.com/tm-569-edu-meeting

-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>


</head>
<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap');
    </style>

    <style>
        body {
            font-family: "Noto Sans", serif !important;
        }

        .header-navbar .site-logo {
            width: 15% !important;
        }

        .header-navbar .site-logo a {
            max-width: none;
        }

        .menu-trigger {
            display: none;
        }

        .absolute-auth {
            position: absolute;
        }

        @media (max-width: 991.98px) {
            .absolute-auth {
                position: initial;
            }
        }

        .btn-primary {
            color: white !important;
            border-radius: 8px !important;
            background-color: #AD0B0B !important;
            padding: 8px 20px !important;
        }

        .btn-primary:hover {
            background-color: #0B0B0B !important;
            border-color: #0B0B0B !important;
        }

        .btn-secondary {
            color: white !important;
            border-radius: 8px !important;
            background-color: #0B0B0B !important;
            padding: 8px 20px !important;
        }

        .btn-secondary:hover {
            background-color: #AD0B0B !important;
            border-color: #AD0B0B !important;
        }

        .btn-tertiary {
            color: black !important;
            border-color: #CACACA !important;
            border-radius: 8px !important;
            background-color: #CACACA !important;
            padding: 8px 20px !important;
        }

        .btn-tertiary.active {
            color: white !important;
            border-color: black !important;
            border-radius: 8px !important;
            background-color: black !important;
            padding: 8px 20px !important;
        }

        .btn-tertiary:hover {
            color: black !important;
            background-color: #979797 !important;
            border-color: #979797 !important;
        }

        .btn-tertiary.active:hover {
            color: white !important;
            border-color: black !important;
            border-radius: 8px !important;
            background-color: black !important;
            padding: 8px 20px !important;
        }

        .bg-icety {
            background-color: #AD0B0B;
        }

        .a-header {
            font-family: "Noto Sans", serif !important;
            color: white !important;
            transition: text-shadow 0.3s ease !important;
        }

        .a-header:hover {
            text-shadow: 3px 3px 5px rgb(0 0 0 / 50%);
        }

        .header-style-1 .header-navbar {
            padding: 10px 0px;
        }

        .menu_fixed {
            box-shadow: none !important;
        }
    </style>

    <style>
        .card-badge {
            width: fit-content;
            font-size: 0.75rem !important;
            line-height: 22px;
            border-radius: 30px;
            box-shadow: 1px 1px 8px rgb(0 0 0 / 25%) !important;
        }

        .card-course {
            box-shadow: 2px 2px 2px rgb(0 0 0 / 25%) !important;
            border: none;
            height: 286px;
            max-height: 286px;
        }

        .card-course .t-section:hover {
            position: absolute;
            bottom: 0;
            height: 100%;
            background-color: rgb(255, 255, 255);
            transition: transform 0.3s ease, height 0.3s ease;
        }

        .card-course .t-section .card-info {
            display: none !important;
        }

        .card-course .t-section:hover .card-info,
        .card-course .t-section:focus-within .card-info {
            display: block !important;
        }

        .card-link {
            text-decoration: underline !important;
            color: #0B0B0B !important;
            font-weight: 600;
        }

        .card-link:hover {
            color: #AD0B0B !important;
        }

        .card-course .title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .description p {
            display: -webkit-box;
            font-family: "Noto Sans", serif !important;
            color: black !important;
            line-height: 20px;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .description {
            display: -webkit-box;
            font-family: "Noto Sans", serif !important;
            color: black !important;
            line-height: 20px;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sub-header {
            position: fixed;
            top: 0;
            width: 100%;
            height: 40px;
            z-index: 1100;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .sub-header.hide {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        .header-area {
            position: fixed;
            top: 40px;
            width: 100%;
            height: 80px;
            z-index: 1000;
            transition: top 0.3s ease;
        }

        .header-area.top {
            top: 0;
        }
        .header-area.header-sticky {
            height: 80px;
            box-shadow: none !important;
        }

        /* wrapper konten */
        #page-content {
            padding-top: 120px; /* 40 + 80 */
            transition: padding-top 0.3s ease;
        }

        /* saat scroll ke bawah */
        body.scrolled .header-area {
            top: 0;
        }

        body.scrolled #page-content {
            padding-top: 80px;
        }

        /* Logo */
        .header-area .logo img {
            max-height: 48px;
        }

        /* === MENU === */
        .main-nav ul.nav > li {
            position: relative;
        }

        /* Submenu positioning */
        .main-nav ul.nav li .sub-menu {
            position: absolute !important;
            top: 100%;
            right: 0;
            left: auto;

            background: #ffffff !important;
            min-width: 220px;
            padding: 10px 0;
            border-radius: 8px;

            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            z-index: 9999;

            display: none;
        }

        /* Show on hover */
        .main-nav ul.nav li:hover > .sub-menu {
            display: block;
        }

        /* Dropdown link */
        .main-nav ul.nav li .sub-menu li a {
            color: #0B0B0B !important;
            padding: 8px 16px;
            display: block;
            white-space: nowrap;
        }

        .main-nav ul.nav li .sub-menu li a:hover {
            color: #AD0B0B !important;
            background: rgba(173, 11, 11, 0.05);
        }
        .main-nav ul.nav li.cart-dropdown .sub-menu {
            width: 320px;
            max-height: 400px;
            overflow-y: auto;
        }

        /* === MOBILE MENU === */
        .menu-trigger span {
            color: white;
        }
        .cart-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            color: #fff;
        }

        .cart-icon i {
            font-size: 1.2rem;
            display: block;
            line-height: 1;
            transform: translateY(-1px);
        }

    /* ===== User Dropdown ===== */
    header .has-sub {
        position: relative;
    }

    header .has-sub .sub-menu {
        background: #ffffff;
        border: none;
        box-shadow: 0 12px 30px rgba(0,0,0,.12);
        border-radius: 16px;
        padding: 10px 0;
        min-width: 260px;
    }

    /* Hilangkan garis antar item */
    header .has-sub .sub-menu li {
        border: none !important;
    }

    /* Style link */
    header .has-sub .sub-menu li a {
        background: transparent !important;
        color: #111;
        padding: 14px 24px;
        font-weight: 500;
        letter-spacing: 1px;
    }

    /* Hover clean */
    header .has-sub .sub-menu li a:hover {
        background: #f6f7f9 !important;
        color: #000;
    }

    /* HR divider */
    header .has-sub .sub-menu hr {
        border: none;
        border-top: 1px solid #eee;
        margin: 10px 0;
    }

    /* Logout merah tapi tetap clean */
    header .has-sub .sub-menu li a.text-danger {
        color: #dc3545 !important;
    }

    header .has-sub .sub-menu li a.text-danger:hover {
        background: #fff5f5 !important;
    }

/* Badge */
    .cart-icon .badge {
        position: absolute;
        top: -2px;
        right: -4px;

        font-size: 0.65rem;
        min-width: 18px;
        height: 18px;

        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    @media (max-width: 991px) {
        .main-nav .nav {
            background-color: #AD0B0B;
        }
    }
    /* ===== FIX GARIS DROPDOWN USER (FORCE) ===== */
header .has-sub .sub-menu,
header .has-sub .sub-menu * {
    border: none !important;
}

/* matikan pseudo element */
header .has-sub .sub-menu::before,
header .has-sub .sub-menu::after,
header .has-sub .sub-menu li::before,
header .has-sub .sub-menu li::after,
header .has-sub .sub-menu a::before,
header .has-sub .sub-menu a::after {
    display: none !important;
    content: none !important;
}

/* link clean */
header .has-sub .sub-menu li a {
    background: #fff !important;
    box-shadow: none !important;
}

/* HR benar-benar hilang */
header .has-sub .sub-menu hr {
    display: none !important;
}
.header-area .main-nav .nav li.has-sub::after {
    display: none !important;
    content: none !important;
}

    </style>
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-8">
                    <div class="left-content">
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <div class="right-icons">
                        <ul>
                            <li><a href="{{ route('lang.switch', 'id') }}">
                                    <img src="{{ asset('icety_assets') }}/id.svg"
                                        style="height: 30px; padding: 4px 0;" />
                                </a>
                            </li>
                            <li><a href="{{ route('lang.switch', 'en') }}">
                                    <img src="{{ asset('icety_assets') }}/uk.svg"
                                        style="height: 30px; padding: 4px 0;" />
                                </a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="/" class="logo">
                            <img class="" src="<?= asset('icety_assets/logo.svg') ?>" alt="">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="/" class="active">{{ __('header.txt_home') }}</a></li>
                            <li><a href="/about-icety">{{ __('header.txt_about') }}</a></li>
                            <li><a href="/store">{{ __('header.txt_store') }}</a></li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">{{ __('header.txt_partnership') }}</a>
                                <ul class="sub-menu">
                                    <li><a href="https://pjgs.icety.org" target="_blank">PJ Global</a></li>
                                    {{-- <li><a href="">Archipelago</a></li> --}}
                                </ul>
                            </li>
                            <li class="scroll-to-section"><a href="/blog">Blog</a></li>
                            <div class="d-none">
                                <form id="form_checkout" action="<?= url('checkout') ?>" method="post">
                                    @csrf
                                    <input type="hidden" value="">
                                </form>
                            </div>
                            @if (!empty(session('user')[0]))
                                {{-- <li class="scroll-to-section">
                                    <a href="#" onclick="$('#form_checkout').submit()">{{ __('header.txt_cart') }}</a>
                                </li>
                                <li class="scroll-to-section">
                                    <a href="{{ url('profile') }}">{{ __('header.txt_profile') }}</a>
                                </li> --}}
                                <li>
                                    <a href="{{ url('vouchers') }}" class=" a-header fw-normal">Voucher</a>
                                </li>
                                <li class="has-sub cart-dropdown">
                                    <a id="_carts" href="#"
                                        class="cart-icon nav-link position-relative text-white"
                                        onclick="$('#form_checkout').submit()">
                                        <i class="bi bi-cart text-white"></i>
                                        <?php $totCheckout = (!empty($checkout) ? count($checkout) : 0);
                                        if ($totCheckout > 0) { ?>
                                            <span class="badge bg-danger"
                                                style="top: 0px; right: -5px;">
                                                <?= count($checkout) ?>
                                            </span>
                                        <?php } ?>
                                    </a>
                                    <?php if ($title != 'Checkout') { ?>
                                        <ul class="sub-menu rounded mt-2" style="left: initial;right:0;width: max-content;">
                                            <h6 class="title mx-3 fs-5 my-3">Cart</h6>
                                            <hr class="dropdown-divider">
                                            <ul id="_itemCart" class="p-0 m-2 overflow-auto" style="max-height:300px">
                                                <?php if (!empty($checkout)) { ?>
                                                    <?php foreach ($checkout as $item): ?>
                                                        <li class="dropdown-item d-flex align-items-center py-2">
                                                            <div class="flex-shrink-0">
                                                                <img src="<?= !empty($item->IMAGE_ACTIVITY) ? $item->IMAGE_ACTIVITY : $item->IMAGE_EBOOK ?>"
                                                                    alt="Image" class="img-fluid rounded"
                                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                            </div>
                                                            <div class="ms-3 flex-grow-1 me-3">
                                                                <span class="d-block text-truncate fw-medium" style="max-width: 220px; margin-bottom: 5px;">
                                                                    <?= !empty($item->TITLE_ACTIVITY) ? $item->TITLE_ACTIVITY : $item->JUDUL ?>
                                                                </span>
                                                                <small class="d-block fw-bold">
                                                                    <?= $item->PRICE_ORDER != 0 ? 'Rp ' . number_format($item->PRICE_ORDER, 0, ',', '.') : 'Free' ?>
                                                                </small>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="d-flex justify-content-center">
                                                                <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1253.jpg"
                                                                    height="210">
                                                            </div>
                                                            <p class="text-center">{{ __('header.txt_product') }}</p>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </ul>
                                            <hr class="dropdown-divider">
                                            <p class="text-center m-0 p-0 mt-2"><a href="#"
                                                    onclick="$('#form_checkout').submit()" class="small">{{ __('header.txt_view') }}</a>
                                            </p>

                                        </ul>
                                    <?php } ?>
                                </li>
                                <li class="has-sub">
                                    <a href="#" class="a-header fw-normal">
                                        <?php if (empty(session('user')[0]['PROFILE_PICTURE'])) { ?>
                                            <i class="bi bi-person-circle text-white"></i>
                                        <?php    } else { ?>
                                            <img class="nav-link rounded-circle "
                                                style="height:40px;width:40px;background-size:cover;background-image: url('<?= session('user')[0]['PROFILE_PICTURE'] ?>')">
                                            </img>
                                        <?php    } ?>
                                        <span class="text-truncate mx-2">
                                            <?= session('user')[0]['NAME'] ?>
                                        </span>
                                    </a>
                                    <ul class="sub-menu" style="left: initial;right:0">
                                        <?php if (session('user')[0]['ID_ROLE'] == 1) { ?>
                                            <li><a class="" href="<?= url('dashboard') ?>">{{ __('header.txt_dashboard') }}</a></li>
                                        <?php    } else { ?>
                                            <li><a class="" href="<?= url('profile') ?>">{{ __('header.txt_profile') }}</a></li>
                                            <li><a class=" " href="<?= url('profile/mycourses') ?>">{{ __('header.txt_course') }}</a></li>
                                            <!-- <li><a class="" href="<?= url('profile/myevents') ?>">My Events</a></li> -->
                                            <li><a class="" href="<?= url('profile/myebook') ?>">My Ebook</a></li>
                                            <li><a class="" href="<?= url('profile/mysertificate') ?>">{{ __('header.txt_certificate') }}</a></li>
                                        <?php    } ?>
                                        <hr>
                                        <li><a class="text-danger" href="<?= url('logout') ?>">{{ __('header.txt_logout') }}</a></li>
                                    </ul>
                                </li>
                            @else
                                <li class="scroll-to-section"><a href="/login">{{ __('header.txt_login') }}</a></li>
                            @endif
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
