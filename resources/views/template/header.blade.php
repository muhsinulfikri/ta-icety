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
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/bootstrap/bootstrap.css">
    <!-- Iconfont Css -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/flaticon/flaticon.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/fonts/gilroy/font-gilroy.css">
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

    <!-- Main jQuery -->
    <script src="{{ asset('assets_new') }}/vendors/jquery/jquery.js"></script>

    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

    <!-- sweetalert2 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js"></script>

</head>

<body id="top-header">
    <style>
        .header-navbar .site-logo {
            width: 15% !important;
        }

        .header-navbar .site-logo a {
            max-width: none;
        }

        .menu-trigger {
            display: none;
        }
    </style>
    <header class="header-style-1">
        <div class="header-topbar topbar-style-1">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-8 col-lg-8 col-sm-6">
                        <div class="header-contact text-center text-sm-start text-lg-start">
                            <a href="#">1010 Moon ave, New York, NY US</a>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="header-socials text-center text-lg-end">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-navbar navbar-sticky">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="site-logo">
                        <a href="{{ url('') }}" class="d-flex">
                            <img class="" style="width: 35px; height: 35px;"
                                src="<?= asset('assets_admin\images\logo\Logo TUT WURI HANDAYANI.png') ?>" alt="">
                            <img class="ms-3" style="width: auto; height: 35px;"
                                src="<?= asset('assets_admin\images\logo\Logo MBKM.png') ?>" alt="">
                            <img class="ms-3" style="width: auto; height: 35px;"
                                src="<?= asset('assets_admin\images\logo\logo-STIKI-PNG.png') ?>" alt="">
                        </a>
                    </div>

                    <div class="offcanvas-icon d-block d-lg-none">
                        <a href="#" class="nav-toggler"><i class="fal fa-bars"></i></a>
                    </div>


                    <nav class="site-navbar ms-auto">
                        <ul class="primary-menu">
                            <li class="current">
                                <a href="{{ url('course') }}">Course</a>
                            </li>
                            <li class="">
                                <a href="{{ url('event') }}">Event</a>
                            </li>
                            <li class="me-0">
                                <a href="{{ url('ebooks') }}">Ebook
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
                            <li class="me-4">
                                <a href="#"
                                    class="nav-link w-100 h-100 d-flex align-items-center position-relative rounded-circle"
                                    style="padding-left:12px;padding-right:12px;right:0;margin-right:1px"
                                    onclick="$('#form_checkout').submit()">
                                    <i class="far fa-shopping-cart" style="-webkit-text-stroke: 0.2px;"></i>
                                    <?php    $totCheckout = (!empty($checkout) ? count($checkout) : 0);
    if ($totCheckout > 0) { ?>
                                    <span class="badge bg-danger rounded-circle position-absolute"
                                        style="top: 0px; right: -5px;">
                                        <?= count($checkout) ?>
                                    </span>
                                    <?php    } ?>
                                </a>
                                <?php    if ($title != 'Checkout') { ?>
                                <ul class="submenu" style="left: initial;right:0;width: max-content;">
                                    <h6 class="title mx-3 fs-5 my-3">Cart</h6>
                                    <hr class="dropdown-divider">
                                    <ul class="p-0 m-2 overflow-auto" style="max-height:300px">
                                        <?php        if (!empty($checkout)) { ?>
                                        <?php            foreach ($checkout as $item): ?>
                                        <li class="dropdown-item" style="pointer-events: none;">
                                            <div class="d-flex dropdown-item align-items-center">
                                                <div class="img col-2">
                                                    <img src="<?= (!empty($item->IMAGE_ACTIVITY)) ? $item->IMAGE_ACTIVITY : $item->IMAGE_EBOOK; ?>"
                                                        alt="Image" class="img-fluid" style="width:50px;height:50px" />
                                                </div>
                                                <div class="col-7 ms-2" style="white-space:normal">
                                                    <?= (!empty($item->TITLE_ACTIVITY)) ? $item->TITLE_ACTIVITY : $item->JUDUL; ?>
                                                </div>
                                                <div class="col-3 ms-2" style="white-space:normal">
                                                    <?= ($item->PRICE_ORDER <> 0) ? "Rp " . number_format($item->PRICE_ORDER, 2, ',', '.') : 'Free' ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php            endforeach; ?>
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
                                    <?php    if (empty(session('user')[0]['PROFILE_PICTURE'])) { ?>
                                    <i class="far fa-user"></i>
                                    <?php    } else { ?>
                                    <img class="nav-link rounded-circle "
                                        style="height:40px;width:40px;background-size:cover;background-image: url('<?= session('user')[0]['PROFILE_PICTURE'] ?>')">
                                    </img>
                                    <?php    } ?>
                                    <span class="text-truncate mx-2">
                                        <?= (session('user')[0]['NAME']) ?>
                                    </span>
                                </a>
                                <ul class="submenu" style="left: initial;right:0">
                                    <?php    if (session('user')[0]['ID_ROLE'] == 1) { ?>
                                    <li><a class="" href="<?= url('dashboard') ?>">Dashboard</a></li>
                                    <?php    } else { ?>
                                    <li><a class="" href="<?= url('profile') ?>">Profile</a></li>
                                    <li><a class=" " href="<?= url('profile/mycourses') ?>">My Courses</a></li>
                                    <li><a class="" href="<?= url('profile/myevents') ?>">My Events</a></li>
                                    <li><a class="" href="<?= url('profile/myebook') ?>">My Ebook</a></li>
                                    <li><a class="" href="<?= url('profile/mysertificate') ?>">My Sertificate</a></li>
                                    <?php    } ?>
                                    <hr>
                                    <li><a class="text-danger" href="<?= url('logout') ?>">Keluar</a></li>
                                </ul>
                            </li>
                        </ul>

                    </nav>
                    <?php  } else { ?>
                    <div class="header-btn d-none d-xl-block">
                        <a href="{{ url('login') }}" class="login">Login</a>
                        <a href="{{ url('register') }}" class="btn btn-main-2 btn-sm-2 rounded">Sign up</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>