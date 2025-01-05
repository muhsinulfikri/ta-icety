<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Edumel- Education Html Template by dreambuzz">
    <meta name="keywords"
        content="education,edumel,instructor,lms,online,instructor,dreambuzz,bootstrap,kindergarten,tutor,e learning">
    <meta name="author" content="dreambuzz">

    <title>{{ $title }}</title>

    <!-- Mobile Specific Meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/bootstrap.css">
    <!-- Iconfont Css -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/flaticon/flaticon.css">
    <!-- <link rel="stylesheet" href="{{ asset('assets_new') }}/fonts/gilroy/font-gilroy.css">bootstrap.js -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/magnific-popup/magnific-popup.css">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/animate-css/animate.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/animated-headline/animated-headline.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/owl/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/owl/assets/owl.theme.default.min.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/woocomerce.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/responsive.css">

    {{-- captcha --}}
    <link rel="stylesheet" href="{{ asset('css/sliderPuzzle.css') }}">

    <!-- Main jQuery -->
    <script src="{{ asset('assets_new') }}/vendors/jquery/jquery.js"></script>

    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

    <!-- sweetalert2 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js">
    </script>

</head>

<body id="top-header">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap');
    </style>

    <style>

        *{
            font-family: "Noto Sans", serif !important;
        }
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

        .card-link {
            text-decoration: underline !important;
            color: #0B0B0B !important;
            font-weight: 600;
        }

        .card-link:hover {
            color: #AD0B0B !important;
        }
    </style>
    <header class="header-style-1">
        <div class="header-topbar topbar-style-1" style="background-color: white;">
            <div class="container">
                <div class="d-flex justify-content-end">
                    <img src="{{ asset('icety_assets') }}/id.svg" style="height: 30px; padding: 4px 0;" />
                </div>
            </div>
        </div>

        <div class="header-navbar navbar-sticky bg-icety">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="site-logo">
                        <a href="{{ url('') }}" class="d-flex mt-2">
                            <img class=""
                                src="<?= asset('icety_assets/logo.svg') ?>"
                                alt="">
                        </a>
                    </div>

                    <div class="offcanvas-icon d-block d-lg-none">
                        <a href="#" class="nav-toggler"><i class="fal fa-bars"></i></a>
                    </div>


                    <nav class="site-navbar ms-auto">
                        <ul class="primary-menu">
                            <li class="current">
                                <a href="{{ url('') }}" class="fw-normal a-header">Home</a>
                            </li>
                            <li class="current">
                                <a href="{{ url('about') }}" class="fw-normal a-header">About ICETy</a>
                            </li>
                            <li class="">
                                <a href="{{ url('store') }}" class="fw-normal a-header">Store</a>
                            </li>
                            <li class="me-0">
                                <a href="{{ url('blog') }}" class="fw-normal a-header">Blog</a>
                            </li>

                            <?php if (!empty(session('user')[0])) { ?>
                                <li class="d-md-none">
                                    <a href="#" onclick="$('#form_checkout').submit()">Cart</a>
                                </li>
                                <li class="d-md-none">
                                    <a href="{{ url('profile') }}">My Profile</a>
                                </li>
                            <?php } else { ?>
                                <li class="d-md-none">
                                    <a href="{{ url('login') }}">Login</a>
                                </li>
                                <li class="d-md-none">
                                    <a href="{{ url('register') }}">Sign up</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <a href="#" class="nav-close"><i class="fal fa-times"></i></a>
                    </nav>


                    <div class="d-none">
                        <form id="form_checkout" action="<?= url('checkout') ?>" method="post">
                            @csrf
                            <input type="hidden" value="">
                        </form>
                    </div>

                    <?php if (!empty(session('user')[0])) { ?>
                        <nav class="header-btn d-none d-md-block">
                            <ul class="primary-menu">
                                <li>
                                    <a href="{{ url('vouchers') }}">Voucher</a>
                                </li>
                                <li class="me-4">
                                    <a href="#"
                                        class="nav-link w-100 h-100 d-flex align-items-center position-relative rounded-circle"
                                        style="padding-left:12px;padding-right:12px;right:0;margin-right:1px"
                                        onclick="$('#form_checkout').submit()">
                                        <i class="far fa-shopping-cart" style="-webkit-text-stroke: 0.2px;"></i>
                                        <?php $totCheckout = (!empty($checkout) ? count($checkout) : 0);
                                        if ($totCheckout > 0) { ?>
                                            <span class="badge bg-danger rounded-circle position-absolute"
                                                style="top: 0px; right: -5px;">
                                                <?= count($checkout) ?>
                                            </span>
                                        <?php    } ?>
                                    </a>
                                    <?php if ($title != 'Checkout') { ?>
                                        <ul class="submenu" style="left: initial;right:0;width: max-content;">
                                            <h6 class="title mx-3 fs-5 my-3">Cart</h6>
                                            <hr class="dropdown-divider">
                                            <ul class="p-0 m-2 overflow-auto" style="max-height:300px">
                                                <?php if (!empty($checkout)) { ?>
                                                    <?php foreach ($checkout as $item): ?>
                                                        <li class="dropdown-item" style="pointer-events: none;">
                                                            <div class="d-flex dropdown-item align-items-center">
                                                                <div class="img col-2">
                                                                    <img src="<?= !empty($item->IMAGE_ACTIVITY) ? $item->IMAGE_ACTIVITY : $item->IMAGE_EBOOK ?>"
                                                                        alt="Image" class="img-fluid"
                                                                        style="width:50px;height:50px" />
                                                                </div>
                                                                <div class="col-7 ms-2" style="white-space:normal">
                                                                    <?= !empty($item->TITLE_ACTIVITY) ? $item->TITLE_ACTIVITY : $item->JUDUL ?>
                                                                </div>
                                                                <div class="col-3 ms-2" style="white-space:normal">
                                                                    <?= $item->PRICE_ORDER != 0 ? 'Rp ' . number_format($item->PRICE_ORDER, 2, ',', '.') : 'Free' ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php        } else { ?>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="d-flex justify-content-center">
                                                                <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1253.jpg"
                                                                    height="210">
                                                            </div>
                                                            <p class="text-center">No Product</p>
                                                        </td>
                                                    </tr>
                                                <?php        } ?>
                                            </ul>
                                            <hr class="dropdown-divider">
                                            <p class="text-center m-0 p-0 mt-2"><a href="#"
                                                    onclick="$('#form_checkout').submit()" class="small">View All</a>
                                            </p>

                                        </ul>
                                    <?php    } ?>
                                </li>
                                <li>
                                    <a href="#">
                                        <?php if (empty(session('user')[0]['PROFILE_PICTURE'])) { ?>
                                            <i class="far fa-user"></i>
                                        <?php    } else { ?>
                                            <img class="nav-link rounded-circle "
                                                style="height:40px;width:40px;background-size:cover;background-image: url('<?= session('user')[0]['PROFILE_PICTURE'] ?>')">
                                            </img>
                                        <?php    } ?>
                                        <span class="text-truncate mx-2">
                                            <?= session('user')[0]['NAME'] ?>
                                        </span>
                                    </a>
                                    <ul class="submenu" style="left: initial;right:0">
                                        <?php if (session('user')[0]['ID_ROLE'] == 1) { ?>
                                            <li><a class="" href="<?= url('dashboard') ?>">Dashboard</a></li>
                                        <?php    } else { ?>
                                            <li><a class="" href="<?= url('profile') ?>">Profile</a></li>
                                            <li><a class=" " href="<?= url('profile/mycourses') ?>">My Courses</a></li>
                                            <li><a class="" href="<?= url('profile/myevents') ?>">My Events</a></li>
                                            <li><a class="" href="<?= url('profile/myebook') ?>">My Ebook</a></li>
                                            <li><a class="" href="<?= url('profile/mysertificate') ?>">My
                                                    Sertificate</a></li>
                                        <?php    } ?>
                                        <hr>
                                        <li><a class="text-danger" href="<?= url('logout') ?>">Keluar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    <?php  } else { ?>
                        <div class="header-btn d-none d-xl-block">
                            <a href="{{ url('login') }}" class="fw-normal a-header">Login</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>