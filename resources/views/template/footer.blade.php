<style>
    .footer {
        font-family: "Noto Sans", serif !important;
    }

    .footer-logo {
        tbh-footer: left;
    }

    @media (max-width: 768px) {
        .tbh-footer {
            text-align: center;
            margin: 0 auto;
        }
    }

    .footer-widget {
        padding-right: 50px;
        width: auto;
    }

    @media (max-width: 768px) {
        .footer-widget {
            text-align: center;
            padding-right: 0;
            width: 100%;
        }

        .footer-links {
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }
    }
</style>
<section class="footer" style="background-color: #680706 !important">
    <div class=" footer-mid pb-4 pb-lg-7">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 me-auto col-sm-8 tbh-footer">
                    <div class="footer-logo mb-3">
                        <img src="<?= url('icety_assets/logo-footer.svg') ?>" class="w-75 img-fluid">
                    </div>
                    <div class="widget footer-widget text-white">
                        <p class="text-white" style="font-size: 0.8rem;line-height: 20px">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet</p>
                    </div>
                    <div class="d-flex gap-3 pt-2 mb-5 mb-lg-0  justify-content-center justify-content-md-start">
                        <a href="#">
                            <img src="{{ asset('icety_assets') }}/logo-ig.svg" class="img-fluid" />
                        </a>
                        <a href="#">
                            <img src="{{ asset('icety_assets') }}/logo-linkedin.svg" class="img-fluid" />
                        </a>
                        <a href="#">
                            <img src="{{ asset('icety_assets') }}/logo-youtube.svg" class="img-fluid" />
                        </a>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-6  d-flex d-lg-block justify-content-center text-center text-lg-start">
                    <div class="footer-widget mb-5 mb-xl-0 pe-0 pe-lg-7" style="width: fit-content;float: inline-end;padding-right: 50px;">
                        <h5 class="widget-title">Explore</h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="<?= url('') ?>">Home</a></li>
                            <li><a href="<?= url('/store#course-section') ?>">Course</a></li>
                            <li><a href="<?= url('/store#course-section') ?>">Event</a></li>
                            <li><a href="<?= url('/about') ?>">About</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-5 col-sm-6">
                    <div class="footer-widget mb-5 mb-xl-0  d-flex flex-column d-lg-block justify-content-center text-center text-lg-start">
                        <h5 class="widget-title">Address</h5>
                        <div class="d-flex flex-column flex-lg-row gap-2 gap-lg-5 mt-3 mt-lg-0">
                            <ul class="list-unstyled footer-links" style="flex:1;">
                                <li>
                                    <h6 class="text-white">Phone</h6><a href="#">0811-8878-333</a>
                                </li>
                                <li>
                                    <h6 class="text-white">Email</h6><a href="#">customercare@iclean.co.id</a>
                                </li>
                            </ul>
                            <ul class="list-unstyled footer-links" style="flex:2">
                                <li>
                                    <h6 class="text-white">Location</h6><a href="#">
                                        Wisma BCA - BSD City Wing A lt.1,
                                        Jl. Kapten Soebijanto Djojohadikusumo No.1, Lengkong,
                                        Serpong Sub-District, South Tangerang City, Banten 15322
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-btm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-sm-12 col-lg-6">
                    <p class="mb-0 copyright text-center text-lg-start text-white" style="font-size: 0.8rem;">Copyright ©2022 All rights reserved | This template is made by ICETy.org</p>
                </div>
                <div class="col-xl-6 col-sm-12 col-lg-6  d-none d-lg-block">
                    <div class="footer-btm-links text-start text-sm-center text-lg-end">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed-btm-top">
        <a href="#top-header" class="js-scroll-trigger scroll-to-top"><i class="fa fa-angle-up"></i></a>
    </div>

</section>

<!-- Bootstrap 5:0 -->
<script src="{{ asset('assets_new') }}/vendors/bootstrap/popper.min.js"></script>
<script src="{{ asset('assets_new') }}/vendors/bootstrap/bootstrap.js"></script>
<!-- Counterup -->
<script src="{{ asset('assets_new') }}/vendors/counterup/waypoint.js"></script>
<script src="{{ asset('assets_new') }}/vendors/counterup/jquery.counterup.min.js"></script>
<!--  Owl Carousel -->
<script src="{{ asset('assets_new') }}/vendors/owl/owl.carousel.min.js"></script>
<!-- Isotope -->
<script src="{{ asset('assets_new') }}/vendors/isotope/jquery.isotope.js"></script>
<script src="{{ asset('assets_new') }}/vendors/isotope/imagelaoded.min.js"></script>
<!-- Animated Headline -->
<script src="{{ asset('assets_new') }}/vendors/animated-headline/animated-headline.js"></script>
<!-- Magnific Popup -->
<script src="{{ asset('assets_new') }}/vendors/magnific-popup/jquery.magnific-popup.min.js"></script>

<script src="{{ asset('assets_new') }}/js/script.js"></script>


</body>

</html>
