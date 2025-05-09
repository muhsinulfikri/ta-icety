<style>
    .banner-image {
        background-image: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(0, 0, 0, 0)), url('icety_assets/bg_banner.svg') !important;
        background-repeat: no-repeat !important;
        background-position: bottom !important;
        background-size: cover !important;
    }

    .course-grid-template {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .font-title {
        font-size: 4rem;
        line-height: 4.5rem;
    }


    @media (max-width: 1200px) {
        .course-grid-template {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .course-grid-template {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .font-title {
            font-size: 3rem;
            line-height: 3.5rem;
        }
    }

    @media (max-width: 576px) {
        .course-grid-template {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
<section class=" banner-image banner-padding p-0">
    <div class="container">
        <div class="row flex-column-reverse flex-lg-row align-items-center justify-content-center">
            <div class="col-md-12 col-xl-6 col-lg-6 ps-0 ps-lg-5 mb-7 mb-lg-0">
                <div class="banner-content ">
                    <div class="fw-bold text-black font-title">Belajar Lebih Mudah</div>
                    <div class="fw-bold text-black pt-2 font-title">di ICETy.org!</div>
                    <div class="text-black mt-4 fs-5">Tingkatkan kompetensi Anda dalam berbagai bidang untuk masa depan yang lebih baik</div>

                    <a href="store" class="btn btn-secondary rounded mt-40">Find your courses here</a>
                </div>
            </div>

            <div class="col-md-12 col-xl-6 col-lg-6">
                <div class="banner-img-round mt-0 pb-5 ps-0 ps-lg-5 pt-4" style="justify-self: center;">
                    <img src="{{ asset('icety_assets') }}/banner.svg" alt="" class="img-fluid">
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>

<!-- Sponsor -->

<section class="container sponsor py-3 my-2">
    <div class="row">
        <div class="col-12 col-lg-2 mb-3 mb-lg-0">
            <div class="fs-5 text-black fw-semibold text-center text-lg-start">Thanks For</div>
            <div class="fs-5 text-black fw-semibold  text-center text-lg-start" style="margin-top: -8px;">Our Supporter</div>
        </div>
        <div class="col-12 col-lg-10">
            <div>
                <div id="sponsorCarousel" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/1.svg" class="img-fluid">
                                </div>
                            </li>
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/2.svg" class="img-fluid">
                                </div>
                            </li>
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/3.svg" class="img-fluid">
                                </div>
                            </li>
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/4.svg" class="img-fluid">
                                </div>
                            </li>
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/5.svg" class="img-fluid">
                                </div>
                            </li>
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/6.svg" class="img-fluid">
                                </div>
                            </li>
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/7.svg" class="img-fluid">
                                </div>
                            </li>
                            <li class="splide__slide d-flex justify-content-center">
                                <div class="text-center align-content-center">
                                    <img src="{{ asset('icety_assets') }}/sponsor/8.svg" class="img-fluid">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

<script>
    // Initialize Splide
    new Splide('#sponsorCarousel', {
        type: 'loop',
        perPage: 6,
        perMove: 1,
        breakpoints: {
            768: {
                perPage: 3,
            },
        },
        pagination: false,
        arrows: false,
        setInterval: 1000,
        autoplay: true,
        pauseOnHover: true,
    }).mount();
</script>



<!-- Why Us -->
<style>
    .card-why {
        transition: text-shadow 0.5s ease;
        border: none;
    }

    .card-why:hover {
        box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
    }
</style>

<section class="container py-6">
    <div class="text-center fs-3 fw-semibold text-black">Mengapa Memilih ICETy.org</div>
    <div class="d-flex flex-column flex-md-row gap-5 justify-content-between pt-6">
        <div class="card card-why flex-fill p-4 hover-shadow">
            <div class="align-self-center mb-4">
                <img src="{{ asset('icety_assets') }}/icon-solusi.svg" class="img-fluid" style="width: 55px; height:55px" />
            </div>
            <div class="text-center text-black fw-semibold fs-5">✅ Solusi Praktis</div>
            <div class="text-center text-black mt-2" style="line-height:22px">Menyediakan beragam kursus berbasis kebutuhan nyata di lapangan — mulai dari keterampilan teknis hingga pengembangan diri, untuk individu dan organisasi.</div>
        </div>
        <div class="card card-why flex-fill p-4 hover-shadow">
            <div class="align-self-center mb-4">
                <img src="{{ asset('icety_assets') }}/icon-kursus.svg" class="img-fluid" style="width: 55px; height:55px" />
            </div>
            <div class="text-center text-black fw-semibold fs-5">🌐 Pengalaman Kursus Online</div>
            <div class="text-center text-black mt-2" style="line-height:22px">Modul interaktif dengan pendekatan multimedia dan teknologi inovatif  yang mendukung pembelajaran fleksibel dan menyenangkan.</div>
        </div>
        <div class="card card-why flex-fill p-4 hover-shadow">
            <div class="align-self-center mb-4">
                <img src="{{ asset('icety_assets') }}/icon-citra.svg" class="img-fluid" style="width: 55px; height:55px" />
            </div>
            <div class="text-center text-black fw-semibold fs-5">Kontribusi untuk Indonesia</div>
            <div class="text-center text-black mt-2" style="line-height:22px">Mendukung peningkatan kualitas SDM dan citra Indonesia di berbagai sektor — dari pendidikan, layanan publik, hingga pariwisata — melalui pelatihan yang aplikatif dan relevan.</div>
        </div>
    </div>
</section>




<!-- Carousel Start -->
<style>
    .splide__arrow:hover {
        border-color: black !important;
        background: transparent !important
    }

    .splide__pagination__page.is-active {
        background: black;
    }

    .splide__arrow {
        background: transparent;
        opacity: .4;
        width: 2.7rem;
        height: 2.7rem;
    }

    .splide__arrow:hover {
        border-style: solid;
        border-color: #bbb;
        opacity: 1;
    }

    button:focus {
        outline: 0px;
    }

    .splide__arrow svg {
        fill: black !important;
    }

    .splide__arrow--prev svg {
        transform: scale(-1.5)
    }

    .splide__arrow--next svg {
        transform: scale(1.5)
    }

    .splide__pagination {
        bottom: 1.5em;
        margin-bottom: -10px;
    }

    .mt-70-m {
        margin-top: 60px !important;
    }

    .countdown-text {
        font-size: 5rem;
        font-weight: 900
    }

    .header-event {
        display: block !important;
    }

    .header-event-mbl {
        display: none !important;
    }

    @media(max-width: 991.95px) {
        .header-event {
            display: none !important;
        }

        .header-event-mbl {
            margin-top: 50px !important;
            margin-bottom: -10px !important;
            display: block !important;
        }
    }

    @media (min-width: 992px) and (max-width: 1199.95px) {
        .img-header {
            margin-top: 8rem !important;
            margin-right: 2rem;
            margin-left: 2rem
        }

        .empty {
            max-width: 70% !important
        }
    }

    @media (min-width: 768px) and (max-width: 991.95px) {
        .img-header {
            /* margin-top: 3rem !important; */
            margin-right: 2rem;
            margin-left: 2rem
        }

        .splide__arrow {
            background: transparent;
            opacity: .4;
            width: 2.7rem;
            height: 2.7rem;
        }

        .splide__arrow:hover {
            border: 4px;
            border-style: solid;
            border-color: #bbb;
            opacity: 1;
        }

        button:focus {
            outline: 0px;
        }

        .splide__arrow svg {
            fill: #bbb;
        }

        .splide__arrow--prev svg {
            transform: scale(-1.5)
        }

        .splide__arrow--next svg {
            transform: scale(1.5)
        }

        .empty {
            max-width: 70% !important
        }
    }

    @media (max-width: 767px) {
        .img-header {
            margin-right: 1.5rem;
            margin-left: 1.5rem
        }

        .splide__arrow {
            background: transparent;
            opacity: .4;
            width: 1.8rem;
            height: 1.8rem;
        }

        .splide__arrow--prev svg {
            transform: scale(-1)
        }

        .splide__arrow--next svg {
            transform: scale(1)
        }

        .empty {
            max-width: 59% !important
        }

        .container-exhibition {
            grid-template-columns: repeat(5, minmax(200px, 1fr)) !important
        }


        .ebanner {
            width: 170px
        }

        .mt-70-m {
            margin-top: 60px !important;
        }
    }

    @media (min-width: 992px) and (max-width: 1199.95px) {
        .img-header {
            margin-top: 8rem !important;
            margin-right: 2rem;
            margin-left: 2rem
        }

        .empty {
            max-width: 70% !important
        }
    }

    @media (min-width: 768px) and (max-width: 991.95px) {
        .img-header {
            /* margin-top: 3rem !important; */
            margin-right: 2rem;
            margin-left: 2rem
        }
    }


    @media (max-width: 479.95px) {
        .countdown-text {
            font-size: 4rem;
            font-weight: 900
        }
    }

    @media (min-width: 414px) and (max-width: 479.95px) {
        .img-header {
            margin-right: 1.9rem;
            margin-left: 1.2rem
        }
    }

    @media (max-width: 767px) {
        .img-header {
            margin-right: 1.5rem;
            margin-left: 1.5rem
        }

        .splide__arrow {
            background: transparent;
            opacity: .4;
            width: 1.8rem;
            height: 1.8rem;
        }

        .splide__arrow--prev svg {
            transform: scale(-1)
        }

        .splide__arrow--next svg {
            transform: scale(1)
        }

        .empty {
            max-width: 59% !important
        }

        .container-exhibition {
            grid-template-columns: repeat(5, minmax(200px, 1fr)) !important
        }

        .ebanner {
            width: 170px
        }

        .mt-70-m {
            margin-top: 20px !important;
        }

    }

    @media (min-width: 480px) and (max-width: 767.95px) {
        .img-header {
            margin-right: 2rem;
            margin-left: 1.3rem
        }

    }

    @media (min-width: 414px) and (max-width: 479.95px) {
        .img-header {
            margin-right: 1.9rem;
            margin-left: 1.2rem
        }

        .splide__arrow {
            background: transparent;
            opacity: .4;
            width: 1.5rem;
            height: 1.5rem;
        }

        .splide__arrow--prev svg {
            transform: scale(-0.8)
        }

        .splide__arrow--next svg {
            transform: scale(0.8)
        }

        .empty {
            max-width: 50% !important
        }

    }

    @media (min-width: 321px) and (max-width: 413.95px) {
        .img-header {
            margin-right: 1.8rem;
            margin-left: 1.1rem
        }

        .empty {
            max-width: 50% !important
        }

        .items::-webkit-scrollbar {
            display: none;
        }

        .nav::-webkit-scrollbar {
            display: none;
        }
    }

    @media (max-width: 320.95px) {
        .img-header {
            margin-right: 1.7rem;
            margin-left: 1rem
        }
    }

    .nav {
        flex-wrap: nowrap;
    }
</style>

<div style="margin:auto;max-width: 1200px;max-height: 300px;">
    <div class="splide-carousel splide img-header mt-3" style="overflow:hidden;border-radius:1rem;max-width: 1200px;max-height: 300px;">
        <div class="splide__track" style="aspect-ratio:4/1;">
            <ul class="splide__list">
                <li class="splide__slide">
                    <section class="bg-fixed division  py-6  px-7"
                        style="background-size:contain;aspect-ratio:4/1;background-image: url('<?= asset('icety_assets') ?>/slide-1.svg');width:100%; height: 100%;">

                    </section>

                </li>
                <li class="splide__slide">
                    <section class="bg-fixed division  py-6  px-7"
                        style="background-size:contain;aspect-ratio:4/1;background-image: url('<?= asset('icety_assets') ?>/slide-2.svg');width:100%; height: 100%;">

                    </section>
                </li>
                <li class="splide__slide">
                    <section class="bg-fixed division  py-6  px-7"
                        style="background-size:contain;aspect-ratio:4/1;background-image: url('<?= asset('icety_assets') ?>/slide-3.svg');width:100%; height: 100%;">

                    </section>
                </li>
            </ul>
        </div>
    </div>
</div>


<script>
    new Splide('.splide-carousel', {
        type: 'loop',
        focus: 0,
        autoplay: true,
        interval: 5000,
    }).mount();
</script>


<!-- Course -->
<section style="background: #E3E3E3;">
    <div class="container py-6 mt-5 mt-md-7">
        <div class="text-center fs-3 fw-semibold text-black">Kembangkan berbagai keterampilan baru bersama ICETy</div>

        <div class="d-flex gap-4 mt-5 mb-4">
            <button class="btn btn-tertiary btn-course active">Course</button>
            <button class="btn btn-tertiary btn-ebook">E-Book</button>
            {{-- <button class="btn btn-tertiary btn-event">Event</button> --}}
        </div>


        <div class="d-grid gap-4 course-grid-template course-container">

        </div>
        <div class="d-grid gap-4 course-grid-template ebook-container" style="display: none !important;">

        </div>
        <div class="d-grid gap-4 course-grid-template event-container" style="display: none !important;">

        </div>

        <div class="text-center text-sm-start show-all-course">
            <a href="/course" class=" btn btn-secondary my-4" style="font-size: 0.8rem">Tampilkan semua</a>

        </div>
        <div class="text-center text-sm-start show-all-ebook">
            <a href="/ebooks" class=" btn btn-secondary my-4" style="font-size: 0.8rem">Tampilkan semua</a>

        </div>

    </div>
</section>


<script>
    function createCardCourse(data) {
        return `
            <div class="card card-course overflow-hidden" id="card-${data.ID_ACTIVITY}" style="width: 276px; max-width: 276px; justify-self: center;">
                <div>
                    <img src="${data.IMAGE_ACTIVITY}" class="img-fluid" style="aspect-ratio: 23/13;" />
                </div>
                <div class="t-section h-100 w-100">
                    <div class="p-3 h-100">
                        <div class="bg-black shadow text-white px-2 py-0 mb-3 card-badge">${data.KATEGORI}</div>
                        <div class="fw-semibold text-black fs-5 mb-3 title" style="line-height: 22px;">${data.TITLE_ACTIVITY}</div>
                        <div class="card-info" style="display: none;     height: 150px;">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="text-black fs-6 mb-2 description" style="line-height: 20px;height:76px">${data.DESKRIPSI_COURSE ?? "-"}</div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1 ">
                                        <div>
                                            <span class="text-black fw-bold fs-5">
                                                ${(data.PRICE_ACTIVITY === 0) ? "Free" : "Rp " + data.PRICE_ACTIVITY.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace('.', ',')}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="course/info/${data.TITLE_ACTIVITY.replace(/ /g, '-').replace(/[^A-Za-z0-9\-]/g, '')}?id_activity=${data.ID_ACTIVITY}" class="card-link">Find out more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    const coursesData = @json($course);
    coursesData.forEach(data => {
        $('.course-container').append(createCardCourse(data));
    });

    function createCardBook(data) {
        return `
            <div class="card card-course overflow-hidden" id="card-${data.ID_BUKU}" style="width: 276px; max-width: 276px; justify-self: center;">
                <div>
                    <img src="${data.IMAGE_EBOOK}" class="img-fluid" style="aspect-ratio: 23/13;" />
                </div>
                <div class="t-section h-100 w-100">
                    <div class="p-3 h-100">
                        <div class="bg-black shadow text-white px-2 py-0 mb-3 card-badge">${data.AUTHOR}</div>
                        <div class="fw-semibold text-black fs-5 mb-3 title" style="line-height: 22px;">${data.JUDUL}</div>
                        <div class="card-info" style="display: none;    height: 150px;">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="text-black fs-6 mb-2 description" style="line-height: 20px;height:76px">${data.DESC ?? "-"}</div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1 ">
                                        <div>
                                            <span class="text-black fw-bold fs-5">
                                                ${(data.PRICE === 0) ? "Free" : "Rp " + data.PRICE.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace('.', ',')}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="ebooks/detail/${data.JUDUL.replace(/ /g, '-').replace(/[^A-Za-z0-9\-]/g, '')}?id_book=${data.ID_BUKU}" class="card-link">Find out more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    const ebooksData = @json($ebook);


    ebooksData.forEach(data => {
        $('.ebook-container').append(createCardBook(data));
    });
    function createCardEvent(data) {
        return `
            <div class="card card-course overflow-hidden" id="card-${data.ID_ACTIVITY}" style="width: 276px; max-width: 276px; justify-self: center;">
                <div>
                    <img src="${data.IMAGE_ACTIVITY}" class="img-fluid" style="aspect-ratio: 23/13;" />
                </div>
                <div class="t-section h-100 w-100">
                    <div class="p-3 h-100">
                        <div class="bg-black shadow text-white px-2 py-0 mb-3 card-badge">${data.ORGANIZER}</div>
                        <div class="fw-semibold text-black fs-5 mb-3 title" style="line-height: 22px;">${data.TITLE_ACTIVITY}</div>
                        <div class="card-info" style="display: none;    height: 150px;">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="text-black fs-6 mb-2 description" style="line-height: 20px;height:76px">${data.DESKRIPSI_EVENT ?? "-"}</div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1 ">
                                        <div>
                                            <span class="text-black fw-bold fs-5">
                                                ${(data.PRICE_ACTIVITY === 0) ? "Free" : "Rp " + data.PRICE_ACTIVITY.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace('.', ',')}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="event/detail/${data.TITLE_ACTIVITY.replace(/ /g, '-').replace(/[^A-Za-z0-9\-]/g, '')}?id_activity=${data.ID_ACTIVITY}" class="card-link">Find out more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    const eventData = @json($event);


    eventData.forEach(data => {
        $('.event-container').append(createCardEvent(data));
    });

    $(document).ready(function() {
        $('.show-all-course').show();
        $('.show-all-ebook').hide();
    });

    $(document).on('click','.btn-course', function() {
        $('.btn-ebook').removeClass('active')
        $('.btn-event').removeClass('active')
        $('.show-all-course').show();
        $('.show-all-ebook').hide();

        $(this).addClass('active')
        $('.ebook-container')[0].style.setProperty('display', 'none', 'important')
        $('.event-container')[0].style.setProperty('display', 'none', 'important')
        $('.course-container').show()
    });

    $(document).on('click','.btn-ebook', function() {
        $('.btn-course').removeClass('active')
        $('.btn-event').removeClass('active')
        $('.show-all-course').hide();
        $('.show-all-ebook').show();
        $(this).addClass('active')
        $('.ebook-container').show()
        $('.course-container')[0].style.setProperty('display', 'none', 'important')
        $('.event-container')[0].style.setProperty('display', 'none', 'important')
    });

    $(document).on('click', '.btn-event', function() {
        $('.btn-course').removeClass('active')
        $('.btn-ebook').removeClass('active')
        $(this).addClass('active')
        $('.event-container').show()
        $('.course-container')[0].style.setProperty('display', 'none', 'important')
        $('.ebook-container')[0].style.setProperty('display', 'none', 'important')
    });
</script>


<!-- Testimoni -->
<section class="py-7" style="background: #404040;">
    <div class="container">
        <div class="text-center fs-2 fw-semibold text-white mb-5">Testimoni</div>

        <div id="testimoniCarousel" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide align-self-center h-100">
                        @include(
                        'template_guest.card_testimoni',
                        [
                        'banner' => 'avatar.svg',
                        'name' => 'Indah Rahayu',
                        'position' => 'Supervisor Kebersihan, Hotel Nusantara',
                        'testimoni' => 'Pemahaman mengenai industri pangan dari personal hygiene, sanitasi, foodborne illness, hingga cleaning',
                        ]
                        )
                    </li>
                    <li class="splide__slide align-self-center h-100">
                        @include(
                        'template_guest.card_testimoni',
                        [
                        'banner' => 'avatar-2.svg',
                        'name' => 'Rudi Hartono',
                        'position' => 'Manajer Keamanan Pangan, Restoran Lezat',
                        'testimoni' => 'Pelatihan Food Safety Management memberi pemahaman yang lebih baik pada tim kami dalam menjaga keamanan pangan setiap hari.',
                        ]
                        )
                    </li>
                    <li class="splide__slide align-self-center h-100">
                        @include(
                        'template_guest.card_testimoni',
                        [
                        'banner' => 'avatar-3.svg',
                        'name' => 'Dian Permata',
                        'position' => 'Kepala Departemen K3, PT Sukses Bersama',
                        'testimoni' => 'The Chemistry of Cleaning sangat membuka wawasan kami tentang kebersihan. Materi mudah dipahami dan aplikatif.',
                        ]
                        )
                    </li>
                    <li class="splide__slide align-self-center h-100">
                        @include(
                        'template_guest.card_testimoni',
                        [
                        'banner' => 'avatar-4.svg',
                        'name' => 'Ari Prakoso',
                        'position' => 'Supervisor Produksi, PT Tani Jaya',
                        'testimoni' => 'Kursus ICETy.org membantu kami meningkatkan higienitas di lini produksi. Sangat bermanfaat untuk seluruh tim!',
                        ]
                        )
                    </li>
                    <li class="splide__slide align-self-center h-100">
                        @include(
                        'template_guest.card_testimoni',
                        [
                        'banner' => 'avatar-5.svg',
                        'name' => 'Nyoman Sarya',
                        'position' => 'Staf Kebersihan, Rumah Sakit Harmoni',
                        'testimoni' => 'Materi di ICETy mudah dipahami dan langsung bisa diterapkan. Sangat mendukung tugas sehari-hari!',
                        ]
                        )
                    </li>
                    <li class="splide__slide align-self-center h-100">
                        @include(
                        'template_guest.card_testimoni',
                        [
                        'banner' => 'avatar-6.svg',
                        'name' => 'Siti Kurniasari',
                        'position' => 'Kepala Divisi Kebersihan, Mall Indah',
                        'testimoni' => 'Kelas Handling Chemical Safety sangat informatif, kami jadi lebih siap dalam menangani bahan kimia dengan aman.',
                        ]
                        )
                    </li>


                </ul>
            </div>
        </div>
    </div>
</section>

<script>
    // Initialize Splide
    new Splide('#testimoniCarousel', {
        type: 'loop',
        perPage: 3,
        perMove: 1,
        breakpoints: {
            768: {
                perPage: 1,
            },
        },
        pagination: false,
        arrows: false,
        setInterval: 1000,
        autoplay: true,
        pauseOnHover: true,
    }).mount();
</script>


<!-- FAQ -->
<style>
    .accordion {
        --bs-accordion-btn-bg: none;
    }

    .accordion-item {
        border: 1px solid black;
        border-radius: calc(0.375rem - 1px) !important;

    }

    .accordion-button {
        border-radius: calc(0.375rem - 1px) !important;
    }

    .accordion-item:not(:first-of-type) {
        border-top: 1px solid black !important;
        border-radius: calc(0.375rem - 1px) !important;
    }

    .accordion-item.accordion-button {
        border-radius: calc(0.375rem - 1px) !important;
    }

    .accordion-item:first-of-type .accordion-button.collapsed {
        border-radius: calc(0.375rem - 1px) !important;
    }

    .accordion-item .accordion-button.collapsed {
        border-radius: calc(0.375rem - 1px) !important;
    }

    .accordion-item:last-of-type .accordion-button.collapsed {
        border-radius: calc(0.375rem - 1px) !important;
    }

    .accordion-button:hover {
        background-color: white !important;
        box-shadow: 3px 3px 5px rgb(0 0 0 / 50%) !important;
    }

    .accordion-button:focus {
        border: none !important;
        box-shadow: none !important;
    }

    .accordion-button:not(.collapsed) {
        color: black !important;
        background-color: white !important;
        box-shadow: inset 0 calc(-1* var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color) !important;
    }


    .accordion-button:not(.collapsed)::after {
        background-image: url("<?= asset('icety_assets') ?>/arrow-up.svg") !important;
        transform: var(--bs-accordion-btn-icon-transform) !important;
    }

    .accordion-button::after {
        background-image: url("<?= asset('icety_assets') ?>/arrow-up.svg") !important;
        --bs-accordion-btn-icon-width: 2rem !important;
    }
</style>


<section class="py-7">
    <div class="container">
        <div class="text-center fs-2 fw-semibold text-black mb-5">Pertanyaan yang sering diajukan</div>

        <div>
            <div class="accordion d-flex flex-column gap-4" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="one">
                        <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colOne" aria-expanded="false" aria-controls="colOne">
                            Apa saja media komunikasi yang digunakan dalam Course ICETy?
                        </button>
                    </h2>
                    <div id="colOne" class="accordion-collapse collapse" aria-labelledby="one">
                        <div class="accordion-body">
                            ICETy menggunakan media gambar, video, quiz, e-book yang interaktif serta pengalaman 360 derajat, menggunakan VR (virtual reality) & AR (augmented reality).
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="two">
                        <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colTwo" aria-expanded="false" aria-controls="colTwo">
                            Siapa saja yang dilibatkan dalam pembuatan modul OCE yang disusun khusus oleh ICETy?
                        </button>
                    </h2>
                    <div id="colTwo" class="accordion-collapse collapse" aria-labelledby="two">
                        <div class="accordion-body">
                            ICETy melibatkan berbagai pakar, praktisi industri, asosiasi profesi, lembaga sertifikasi, serta pembuat kebijakan.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="three">
                        <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colThree" aria-expanded="false" aria-controls="colThree">
                            Apakah saya akan mendapatkan sertifikat setelah menyelesaikan kursus ICETy.org?
                        </button>
                    </h2>
                    <div id="colThree" class="accordion-collapse collapse" aria-labelledby="three">
                        <div class="accordion-body">
                            Setelah Anda menyelesaikan progress hingga 100% dan telah mendapatkan nilai post test lebih dari 80, Anda akan masuk pada tahap verification. Setelah itu, Anda akan mendapatkan sertifikat melalui email, dan dapat juga diakses melalui web pada tombol ‘Credential’.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="four">
                        <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colFour" aria-expanded="false" aria-controls="colFour">
                            Berapa lama waktu yang diperlukan untuk menyelesaikan kursus ICETy.org?
                        </button>
                    </h2>
                    <div id="colFour" class="accordion-collapse collapse" aria-labelledby="four">
                        <div class="accordion-body">
                            Pada masing-masing kursus, rata-rata waktu penyelesaiannya adalah 1-2 jam. Pada kursus ICETy.org tidak ada batasan waktu dalam penyelesaian kursus.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="five">
                        <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colFive" aria-expanded="false" aria-controls="colFive">
                            Apakah saya tetap dapat mengakses materi kursus sekalipun sudah menyelesaikan kursus?
                        </button>
                    </h2>
                    <div id="colFive" class="accordion-collapse collapse" aria-labelledby="five">
                        <div class="accordion-body">
                            Setelah Anda selesai mengerjakan atau sudah mendapat sertifikat, Anda tetap akan dapat mengakses materi dalam kursus yang telah diambil selama 1 tahun.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>



<!-- <section class="section-padding course-filter-section">
    <div class="container">
        <div class="row align-items-center justify-content-between mb-30">
            <div class="col-xl-12">
                <div class="heading text-center mb-40">
                    <span class="subheading">Available Courses</span>
                    <h2 class="font-lg">Explore available courses</h2>
                </div>

                <div class="filter-wrap text-center">
                    <ul class="course-filter ">
                        <?php foreach ($kategori as $item_kategori) : ?>
                            <li><a href="#" data-value="<?= $item_kategori->ID_KATEGORI ?>"
                                    id="nav-<?= $item_kategori->ID_KATEGORI ?>"
                                    onclick="ChangeNav(this, event)"><?= $item_kategori->KATEGORI ?></a></li>
                        <?php endforeach ?>
                        <li><a href="course">See All </a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid container-padding">
        <div class="row course-gallery justify-content-center">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show pt-4 active show" id="nav-content" role="tabpanel"
                    aria-labelledby="nav-content-tab" tabindex="0">
                    <div class="row justify-content-center" id="nav-content-item">
                        <h3 class="font-sm text-center">No course available</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="features-3 section-padding-btm ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="section-heading mb-50 text-center">
                    <h2 class="font-lg">Transform Your Life </h2>
                    <p>Discover Your Perfect Program In Our Courses.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-xl-4 col-sm-6">
                <div class="feature-item feature-style-top hover-shadow rounded border-0">
                    <div class="feature-icon">
                        <i class="flaticon-teacher"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Free Regisration</h4>
                        <p>Free access for wide range courses and events.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xl-4 col-sm-6">
                <div class="feature-item feature-style-top hover-shadow rounded border-0">
                    <div class="feature-icon">
                        <i class="flaticon-layer"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Open For All</h4>
                        <p>All courses are accessable for everyone.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xl-4 col-sm-6">
                <div class="feature-item feature-style-top hover-shadow rounded border-0">
                    <div class="feature-icon">
                        <i class="flaticon-video-camera"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Combine Self</h4>
                        <p>Face study and mentority.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xl-4 col-sm-6">
                <div class="feature-item feature-style-top hover-shadow rounded border-0">
                    <div class="feature-icon">
                        <i class="flaticon-lifesaver"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Be an Instructor</h4>
                        <p>Anyone can share their knowledge.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xl-4 col-sm-6">
                <div class="feature-item feature-style-top hover-shadow rounded border-0">
                    <div class="feature-icon">
                        <i class="flaticon-lifesaver"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Get Certificates</h4>
                        <p>Complete courses and get your official certification.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding-btm course-filter-section">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 col-lg-5">
                <div class="section-heading mb-50 text-center text-lg-start">
                    <span class="subtitle">Explore availabe events</span>
                    <h2 class="font-lg">Events</h2>
                </div>
            </div>
        </div>


        <div class="row course-gallery ">
            <?php foreach ($event as $item) { ?>

                <div class="course-item cat1 cat5 col-lg-6 col-md-6">
                    <div class="single-course style-2 bg-shade border-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-xl-5">
                                <div class="course-thumb"
                                    style="background:url(<?= str_replace(' ', '%20', $item->IMAGE_ACTIVITY) ?>)">
                                </div>
                            </div>
                            <div class="col-xl-7">
                                <div class="course-content">
                                    <div class="course-price"><?= date_format(date_create($item->LOG_TIME), 'j F Y') ?>
                                    </div>
                                    <h3 class="course-title"> <a
                                            href="<?= 'event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY ?>"><?= $item->TITLE_ACTIVITY ?>
                                        </a> </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <div class="row cta-inner-section g-0" style="background: white;">
            <?php if (empty(session('user')[0]) || session('user')[0]['ID_ROLE'] != '2') { ?>
                <div class="col-xl-6 col-lg-6">
                    <div class="info-box style-1">
                        <span class="subtitle"># Become a Instructor</span>
                        <h2 class="font-lg mb-20 mt-10">Become an Instructor Right Now</h2>
                        <a href="#" class="btn btn-main-2 rounded">Apply Now <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            <?php } ?>
            <?php if (empty(session('user')[0])) { ?>
                <div class="col-xl-6 col-lg-6">
                    <div class="info-box">
                        <span class="subtitle"># Want to join </span>
                        <h2 class="font-lg mb-20 mt-10">Not Sure Where to Begin?</h2>
                        <a href="#" class="btn btn-main rounded">Get Started <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-xl-6 col-lg-6">
                    <div class="info-box">
                        <span class="subtitle"></span>
                        <h2 class="font-lg mb-20 mt-10"></h2>
                        <a href="#" class="btn btn-main rounded"></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<script>
    $("#nav-1").trigger('click')

    function ChangeNav(element, event) {
        event.preventDefault()
        <?php foreach ($kategori as $item_kategori) : ?>
            $("#nav-<?= $item_kategori->ID_KATEGORI ?>").parent().removeClass("active")
        <?php endforeach; ?>
        $(element).parent().addClass("active")
        GetCourse($(element).data('value'))
    }

    function GetCourse(category) {
        $('#nav-content-item').html(`<div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
            <div class=" rounded-5 p-3 pb-4 h-auto d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" />
                </div>
            </div>
        </div>`)
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "guest/category",
            method: 'POST',
            data: {
                category: category
            },
            success: function(result) {
                $('#nav-content-item').html()
                $('#nav-content-item').html(result)
            }
        });
    }
</script> -->
