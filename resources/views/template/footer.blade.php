<section class="footer <?= $title == 'TBHAcademy' ? 'pt-200' : '' ?>">
    <div class="footer-mid">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 me-auto col-sm-8">
                    <div class="footer-logo mb-3">
                        <img src="<?= url('assets/images/white-logo.svg') ?>" class="w-75 img-fluid">
                    </div>
                    <div class="widget footer-widget mb-5 mb-lg-0">
                        <p>Everyone can share and learn</p>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-6">
                    <div class="footer-widget mb-5 mb-xl-0" style="width: fit-content;float: inline-end;padding-right: 50px;">
                        <h5 class="widget-title">Explore</h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="<?= url('') ?>">Home</a></li>
                            <li><a href="<?= url('course') ?>">Course</a></li>
                            <li><a href="<?= url('event') ?>">Event</a></li>
                            <li><a href="<?= url('') ?>">About</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-5 col-sm-6">
                    <div class="footer-widget mb-5 mb-xl-0">
                        <h5 class="widget-title">Address</h5>
                        <div class="d-flex gap-5">
                            <ul class="list-unstyled footer-links" style="flex:1;">
                                <li>
                                    <h6 class="text-white">Phone</h6><a href="#">+62 899-2876-420</a>
                                </li>
                                <li>
                                    <h6 class="text-white">Email</h6><a href="#">inbis@stiki.ac.id</a>
                                </li>
                            </ul>
                            <ul class="list-unstyled footer-links" style="flex:2">
                                <li>
                                    <h6 class="text-white">Location</h6><a href="#">
                                        Jl. Raya Tidar No.100, Karangbesuki,<br> Kec. Sukun,
                                        Kota Malang, East Java 65146, 13910</a>
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
                    <p class="mb-0 copyright text-sm-center text-lg-start">© 2024 TBH Academy. All rights reserved.</p>
                </div>
                <div class="col-xl-6 col-sm-12 col-lg-6">
                    <div class="footer-btm-links text-start text-sm-center text-lg-end">
                        <a href="#">Legal</a>
                        <a href="#">Supports</a>
                        <a href="#">Terms</a>
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