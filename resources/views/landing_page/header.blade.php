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


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/fontawesome.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/fix.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/owl.css">
    <link rel="stylesheet" href="{{ asset('assets_landing') }}/assets/css/lightbox.css">
    <!--

TemplateMo 569 Edu Meeting

https://templatemo.com/tm-569-edu-meeting

-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>


</head>
<body>
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
                            <li class="scroll-to-section"><a href="/" class="active">Home</a></li>
                            <li><a href="/about-icety">About</a></li>
                            <li><a href="/store">Courses</a></li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">Partnership</a>
                                <ul class="sub-menu">
                                    <li><a href="https://pjgs.icety.org" target="_blank">PJ Global</a></li>
                                    {{-- <li><a href="">Archipelago</a></li> --}}
                                </ul>
                            </li>
                            <li class="scroll-to-section"><a href="/blog">Blog</a></li>
                            @if (!empty(session('user')[0]))
                                <li class="scroll-to-section"><a href="{{ url('profile') }}">{{ __('header.txt_profile') }}</a></li>
                            @else
                                <li class="scroll-to-section"><a href="/login">Login</a></li>
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
