<?php

use Illuminate\Support\Facades\Request;
?>

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

    @media (max-width: 1200px) {
        .footer-links-1 li {
            display: inline-block !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
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
                        <a href="https://www.icety.org/" target="_blank">
                            <img src="<?= url('icety_assets/logo-footer.svg') ?>" class="w-75 img-fluid">
                        </a>
                    </div>
                    <div class="widget footer-widget text-white">
                        <p class="text-white" style="font-size: 0.8rem;line-height: 20px"></p>
                    </div>
                    <div class="d-flex gap-3 pt-2 mb-5 mb-lg-0  justify-content-center justify-content-md-start">
                        <a href="https://www.instagram.com/icetystudio/" target="_blank">
                            <img src="{{ asset('icety_assets') }}/logo-ig.svg" class="img-fluid" />
                        </a>
                        <a href="https://id.linkedin.com/company/icety" target="_blank">
                            <img src="{{ asset('icety_assets') }}/logo-linkedin.svg" class="img-fluid" />
                        </a>
                        <a href="https://www.youtube.com/channel/UCJMrxaHPEKL3PL1ohFhjbjg?sub_confirmation=1" target="_blank">
                            <img src="{{ asset('icety_assets') }}/logo-youtube.svg" class="img-fluid" />
                        </a>
                        <a href="https://wa.me/628119006393" target="_blank">
                            <img src="{{ asset('icety_assets') }}/logo-wa.svg" class="img-fluid" />
                        </a>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-12 pt-lg-5 pt-xl-0 d-flex d-xl-block justify-content-center justify-content-lg-start text-lg-start text-center text-xl-start">
                    <div class="footer-widget mb-5 mb-xl-0 pe-0 pe-xl-7" style="width: fit-content;float: inline-end;padding-right: 50px;">
                        <h5 class="widget-title">Explore</h5>
                        <ul class="list-unstyled footer-links footer-links-1">
                            <li><a href="<?= url('') ?>">Home</a></li>
                            <li><a href="<?= url('/store#course-section') ?>">Course</a></li>
                            <li><a href="<?= url('/store#course-section') ?>">Event</a></li>
                            <li><a href="<?= url('/about') ?>">About</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-12  d-flex d-xl-block justify-content-center justify-content-lg-start text-lg-start text-center text-xl-start">
                    <div class="footer-widget mb-5 mb-xl-0 pe-0" style="width: fit-content;">
                        <h5 class="widget-title">The Platform</h5>
                        <ul class="list-unstyled footer-links footer-links-1">
                            <li><a href="https://www.openlearning.com">Open Learning</a></li>
                            <li><a href="https://solutions.openlearning.com/terms-of-service?__hstc=206963404.a5653ae9846fb4f75a6092018c3a81c8.1738741786120.1738741786120.1738741786120.1&amp;__hssc=206963404.5.1738741786120&amp;__hsfp=3797677121">Terms of Service</a></li>
                            <li><a href="https://solutions.openlearning.com/privacy-policy?__hstc=206963404.a5653ae9846fb4f75a6092018c3a81c8.1738741786120.1738741786120.1738741786120.1&amp;__hssc=206963404.5.1738741786120&amp;__hsfp=3797677121">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-12">
                    <div class="footer-widget pe-0 mb-5 mb-xl-0  d-flex flex-column d-lg-block justify-content-center text-center text-lg-start">
                        <h5 class="widget-title">Address</h5>
                        <div class="d-flex flex-column flex-lg-row gap-2 gap-lg-5 mt-3 mt-lg-0">
                            <ul class="list-unstyled footer-links" style="flex:1;">
                                <li>
                                    <h6 class="text-white">Phone</h6><a href="http://wa.me/6285117301678">+62 851-1730 -1678</a>
                                </li>
                                <li>
                                    <h6 class="text-white">Email</h6><a href="mailto:info@icety.org">info@icety.org</a>
                                </li>
                                <li>
                                    <h6 class="text-white">Location</h6><a href="https://maps.app.goo.gl/M9oDzFPWKDBkbiqd7">
                                        Bizhub Serpong Blok GB No.15 Jl. Raya Puspitek Gunung Sindur Bogor (16340) Yayasan Terang Garam Merica
                                </li>
                            </ul>
                            <!-- <ul class="list-unstyled footer-links" style="flex:2"> -->

                            <!-- </ul> -->
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
                    <p class="mb-0 copyright text-center text-lg-start text-white" style="font-size: 0.8rem;">Copyright ©2025 All rights reserved | This template is made by ICETy.org</p>
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

<script>
    function addCart(bodyParam) {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $.ajax({
            url: '<?= Request::segment(0) ?>/add/order',
            type: "GET",
            data: bodyParam,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'System still processing your item',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(data) {
                Swal.close();
                $('#_itemCart').html('')

                let totOrder = 0
                $.each(data.dataOrder, function(index, data) {
                    let imageProduct = (data.IMAGE_ACTIVITY) ? data.IMAGE_ACTIVITY : data.IMAGE_EBOOK
                    let titleProd = (data.TITLE_ACTIVITY) ? data.TITLE_ACTIVITY : data.JUDUL
                    let priceProd = (data.PRICE_ORDER) ?
                        'Rp ' + parseFloat(data.PRICE_ORDER).toLocaleString('id-ID', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) :
                        'Free';

                    $('#_itemCart').append(`
                        <li class="dropdown-item d-flex align-items-center py-2">
                            <div class="flex-shrink-0">
                                <img src="${imageProduct}"
                                    alt="Image" class="img-fluid rounded"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div class="ms-3 flex-grow-1 me-3">
                                <span class="d-block text-truncate fw-medium" style="max-width: 220px; margin-bottom: 5px;">
                                    ${titleProd}
                                </span>
                                <small class="d-block fw-bold">
                                    ${priceProd}
                                </small>
                            </div>
                        </li>
                    `)
                    totOrder++
                })

                if (totOrder) {
                    $('#_carts').html(`
                        <i class="far fa-shopping-cart text-white" style="-webkit-text-stroke: 0.1px;"></i>
                        <span class="badge bg-danger rounded-circle position-absolute"
                            style="top: -10px; right: -5px;">
                            ${totOrder}
                        </span>
                    `)
                } else {
                    $('#_carts').html(`
                        <i class="far fa-shopping-cart text-white" style="-webkit-text-stroke: 0.1px;"></i>
                    `)
                }
                Toast.fire({
                    icon: (data.Status) ? 'success' : 'error',
                    title: data.Message
                })
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menambahkan produk ke cart.'
                });
            }
        });
    }
</script>

</body>

</html>
