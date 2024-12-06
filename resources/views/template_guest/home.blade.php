<style>
    .banner-image {
        background-image: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(0, 0, 0, 0)), url('assets/images/home-1.png') !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size: cover !important;
    }

    .banner-style-4 {
        background: white;
    }
</style>

<section class=" banner-image banner-style-4 banner-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-12 col-xl-6 col-lg-6 ps-5">
                <div class="banner-content ">
                    <span class="subheading text-dark">The Brain & Heart Academy</span>
                    <h1 class="text-dark mt-0" style="font-weight: 500;">Everyone can<br>
                        <span style="font-weight: 700;">share and learn</span>
                    </h1>
                    <p class="mb-40 text-dark"> Are you ready to grow with us?</p>

                    <div class="btn-container">
                        <a href="course" class="btn btn-main rounded">Find Courses</a>
                        <a href="login" class="btn btn-white rounded ms-2">Get started </a>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-6 col-lg-6">
                <div class="banner-img-round mt-5 mt-lg-0 ps-5">
                    <!-- <img src="{{ asset('assets_new') }}/images/banner/banner_img.png" alt="" class="img-fluid"> -->
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>

<section class="counter-section4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 counter-inner">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="counter-item mb-5 mb-lg-0">
                            <div class="count">
                                <span class="counter h2">32</span><span>+</span>
                            </div>
                            <p>Courses</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="counter-item mb-5 mb-lg-0">
                            <div class="count">
                                <span class="counter h2">100</span><span>+</span>
                            </div>
                            <p>Active Users</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="counter-item mb-5 mb-lg-0">
                            <div class="count">
                                <span class="counter h2">30 </span>
                            </div>
                            <p>Export</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Carousel Start -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var splide = new Splide('.splide', {
            type: 'loop',
            focus: 0,
            autoplay: true,
            interval: 5000,
        });
        splide.mount();
    });
</script>

<style>
    .splide__arrow:hover {
        border-color: var(--theme-primary-color) !important;
        background: transparent !important
    }

    .splide__pagination__page.is-active {
        background: #FC8B14;
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
        fill: var(--theme-primary-color) !important;
    }

    .splide__arrow--prev svg {
        transform: scale(-1.5)
    }

    .splide__arrow--next svg {
        transform: scale(1.5)
    }

    .splide__pagination {
        bottom: 1.5em;
        margin-bottom: -20px;
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


<section class="section-padding course-filter-section">
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
    <!--course-->
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
    <!--course-->
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
</script>
