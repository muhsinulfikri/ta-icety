<style>
    @media (max-width: 576px) {
        .col-lg-3 img[alt=""] {
            max-width: 120px !important;
        }
        .col-lg-3 .d-flex img {
            width: 24px !important;
        }
    }
</style>

<section class="contact-us py-5 text-white" style="background-color: #680706;">
    <div class="container">
        <div class="row gy-4">
            <!-- Column 1: Logo + Social -->
            <div class="col-lg-3 col-md-6 text-center text-lg-start pe-lg-5">
                <img src="{{ asset('icety_assets/logo-footer.svg') }}" alt="" class="img-fluid" style="max-width: 180px;">
                <div class="d-flex justify-content-center justify-content-lg-start gap-3 mt-3 flex-wrap">
                    <a href="https://www.instagram.com/icetystudio/" target="_blank">
                        <img src="{{ asset('icety_assets/logo-ig.svg') }}" width="30" alt="Instagram">
                    </a>
                    <a href="https://id.linkedin.com/company/icety" target="_blank">
                        <img src="{{ asset('icety_assets/logo-linkedin.svg') }}" width="30" alt="LinkedIn">
                    </a>
                    <a href="https://www.youtube.com/channel/UCJMrxaHPEKL3PL1ohFhjbjg?sub_confirmation=1" target="_blank">
                        <img src="{{ asset('icety_assets/logo-youtube.svg') }}" width="30" alt="YouTube">
                    </a>
                    <a href="http://wa.me/6285117301678" target="_blank">
                        <img src="{{ asset('icety_assets/logo-wa.svg') }}" width="30" alt="WhatsApp">
                    </a>
                </div>
            </div>

            <!-- Column 2: Explore -->
            <div class="col-lg-3 col-md-6 text-center text-lg-start" >
                <h6 class="fw-bold mb-3">Explore</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="/" class="text-white text-decoration-none d-block mb-2">Home</a></li>
                    <li><a href="/about_landing" class="text-white text-decoration-none d-block">About</a></li>
                    <li><a href="/" class="text-white text-decoration-none d-block mb-2">Blog</a></li>
                </ul>
            </div>

            <!-- Column 3: The Platform -->
            <div class="col-lg-3 col-md-6 text-center text-lg-start">
                <h6 class="fw-bold mb-3">The Platform</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="#" class="text-white text-decoration-none d-block mb-2">Term of Service</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Column 4: Information -->
            <div class="col-lg-3 col-md-6 text-center text-lg-start">
                <h6 class="fw-bold mb-3">Information</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <strong>Phone</strong><br>
                        <a href="http://wa.me/6285117301678" target="_blank" class="text-white text-decoration-none">+62 851-1730-1678</a>
                    </li>
                    <li class="mb-3">
                        <strong>Email</strong><br>
                        <a href="mailto:info@icety.org" class="text-white text-decoration-none">info@icety.org</a>
                    </li>
                    <li>
                        <strong>Location</strong><br>
                        Bizhub Serpong Blok GB No.15 Jl. Raya Puspitek<br>
                        Gunung Sindur Bogor (16340)<br>
                        Yayasan Terang Garam Merica (TAGAME)
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer bottom -->
    <div class="text-center mt-5 pt-3 border-top border-light">
        <p class="mb-0 small" style="color: #fff">
            Copyright ©2025 All rights reserved |
            Made by <a href="https://www.icety.org/" target="_blank" class="text-white fw-bold">ICETy.org</a>
        </p>
    </div>
</section>


<!-- Scripts -->
<script src="{{ asset('assets_landing')}}/vendor/jquery/jquery.min.js"></script>
<script src="{{ asset('assets_landing')}}/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('assets_landing')}}/assets/js/isotope.min.js"></script>
<script src="{{ asset('assets_landing')}}/assets/js/owl-carousel.js"></script>
<script src="{{ asset('assets_landing')}}/assets/js/lightbox.js"></script>
<script src="{{ asset('assets_landing')}}/assets/js/tabs.js"></script>
<script src="{{ asset('assets_landing')}}/assets/js/video.js"></script>
<script src="{{ asset('assets_landing')}}/assets/js/slick-slider.js"></script>
<script src="{{ asset('assets_landing')}}/assets/js/custom.js"></script>

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
        });

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
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function(data) {
                Swal.close();
                $('#_itemCart').html('');
                let totOrder = 0;
                $.each(data.dataOrder, function(index, data) {
                    let imageProduct = data.IMAGE_ACTIVITY ?? data.IMAGE_EBOOK;
                    let titleProd = data.TITLE_ACTIVITY ?? data.JUDUL;
                    let priceProd = data.PRICE_ORDER
                        ? 'Rp ' + parseFloat(data.PRICE_ORDER).toLocaleString('id-ID', { minimumFractionDigits: 2 })
                        : 'Free';

                    $('#_itemCart').append(`
                        <li class="dropdown-item d-flex align-items-center py-2">
                            <div class="flex-shrink-0">
                                <img src="${imageProduct}" alt="Image" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div class="ms-3 flex-grow-1 me-3">
                                <span class="d-block text-truncate fw-medium" style="max-width: 220px;">${titleProd}</span>
                                <small class="d-block fw-bold">${priceProd}</small>
                            </div>
                        </li>
                    `);
                    totOrder++;
                });

                if (totOrder) {
                    $('#_carts').html(`
                        <i class="far fa-shopping-cart text-white" style="-webkit-text-stroke: 0.1px;"></i>
                        <span class="badge bg-danger rounded-circle position-absolute" style="top: -10px; right: -5px;">${totOrder}</span>
                    `);
                } else {
                    $('#_carts').html(`<i class="far fa-shopping-cart text-white" style="-webkit-text-stroke: 0.1px;"></i>`);
                }

                Toast.fire({ icon: data.Status ? 'success' : 'error', title: data.Message });
            },
            error: function() {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan saat menambahkan produk ke cart.' });
            }
        });
    }
</script>
</body>
</html>
