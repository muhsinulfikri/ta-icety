

    <!-- Sub Header -->

    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <section class="section main-banner" id="top" data-section="section1">
        <video autoplay muted loop playsinline id="bg-video">
            <source src="{{ asset('assets_landing') }}/assets/images/highlight_icety.mp4" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="caption">
                            <h6>{{ __('home.txt_subtit_1') }}</h6>
                            <h2>{{ __('home.txt_subtit_2') }}</h2>
                            <p>{{ __('home.txt_subtit_3') }}</p>
                            <div class="main-button-red">
                                <div class="scroll-to-section"><a href="#contact">Join Us Now!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->

    <section class="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-service-item owl-carousel">

                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('assets_landing') }}/assets/images/icon-solusi.svg"" alt="">
                            </div>
                            <div class="down-content">
                                <h4>{{ __('home.txt_card_1') }}</h4>
                                <p>{{ __('home.txt_card_2') }}</p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('assets_landing') }}/assets/images/icon-kursus.svg"" alt="">
                            </div>
                            <div class="down-content">
                                <h4>{{ __('home.txt_card_3') }}</h4>
                                <p>{{ __('home.txt_card_4') }}</p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('assets_landing') }}/assets/images/icon-citra.svg"" alt="">
                            </div>
                            <div class="down-content">
                                <h4>{{ __('home.txt_card_5') }}</h4>
                                <p>{{ __('home.txt_card_6') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-us py-5" id="about-us">
    <div class="container">
        <div class="row align-items-center">

            <!-- KIRI: GAMBAR -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-image">
                    <img src="<?= asset('assets_landing') ?>/assets/images/img_about.jpeg"
                        alt="About ICETY"
                        class="img-fluid rounded-4 shadow-sm" style="border-radius: 5px">
                </div>
            </div>

            <!-- KANAN: TEXT -->
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">{{ __('about.txt_heading') }}</h2>

                <p class="text-muted" style="text-align: justify;">
                    {{ __('about.txt_about_landing_1') }}
                </p>

                <p class="text-muted" style="text-align: justify;">
                    {{ __('about.txt_about_landing_2') }}
                </p>
            </div>

        </div>
    </div>
</section>


    <script>
        new Splide('.splide-carousel', {
            type: 'loop',
            focus: 0,
            autoplay: true,
            interval: 5000,
        }).mount();
    </script>

    <section class="py-7 d-flex justify-content-center align-items-center text-center" style="padding: 20px;background-image: url('<?= asset('assets_landing')?>/assets/images/apply-bg.jpg'); min-height: 100vh;">
        <div class="container">
            <div class="text-center fs-2 fw-semibold text-white mb-5">{{ __('home.txt_testimoni') }}</div>

            <div id="testimoniCarousel" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide align-self-center h-100">
                            @include(
                            'template_guest.card_testimoni',
                            [
                            'banner' => 'avatar.svg',
                            'name' => 'Indah Rahayu',
                            'position' => __('home.txt_post_1'),
                            'testimoni' => __('home.txt_test_1'),
                            ]
                            )
                        </li>
                        <li class="splide__slide align-self-center h-100">
                            @include(
                            'template_guest.card_testimoni',
                            [
                            'banner' => 'avatar-2.svg',
                            'name' => 'Rudi Hartono',
                            'position' => __('home.txt_post_2'),
                            'testimoni' => __('home.txt_test_2'),
                            ]
                            )
                        </li>
                        <li class="splide__slide align-self-center h-100">
                            @include(
                            'template_guest.card_testimoni',
                            [
                            'banner' => 'avatar-3.svg',
                            'name' => 'Dian Permata',
                            'position' => __('home.txt_post_3'),
                            'testimoni' => __('home.txt_test_3'),
                            ]
                            )
                        </li>
                        <li class="splide__slide align-self-center h-100">
                            @include(
                            'template_guest.card_testimoni',
                            [
                            'banner' => 'avatar-4.svg',
                            'name' => 'Ari Prakoso',
                            'position' => __('home.txt_post_4'),
                            'testimoni' => __('home.txt_test_4'),
                            ]
                            )
                        </li>
                        <li class="splide__slide align-self-center h-100">
                            @include(
                            'template_guest.card_testimoni',
                            [
                            'banner' => 'avatar-5.svg',
                            'name' => 'Nyoman Sarya',
                            'position' => __('home.txt_post_5'),
                            'testimoni' => __('home.txt_test_5'),
                            ]
                            )
                        </li>
                        <li class="splide__slide align-self-center h-100">
                            @include(
                            'template_guest.card_testimoni',
                            [
                            'banner' => 'avatar-6.svg',
                            'name' => 'Siti Kurniasari',
                            'position' => __('home.txt_post_6'),
                            'testimoni' => __('home.txt_test_6'),
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

    <section class="our-courses" id="courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading text-center" >
                        <h2>{{ __('home.txt_support_1') }} {{ __('home.txt_support_2') }}</h2>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="owl-courses-item owl-carousel">
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/2.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/1.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/3.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/4.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/5.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/6.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/7.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                        <div class="item" style="padding: 5px;">
                            <img src="{{ asset('icety_assets') }}/sponsor/8.svg" class="img-fluid" style="max-width: 120px; height: auto;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-facts">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>{{ __('home.txt_facts') }}</h2>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="count-area-content percentage">
                                        {{-- <div class="count-digit">{{ $graduate[0]->GRADUATE }}</div> --}}
                                        <div class="count-digit">95%</div>
                                        <div class="count-title">{{ __('home.txt_graduate') }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="count-area-content">
                                        <div class="count-digit">{{ $modules[0]->MODULES }}</div>
                                        <div class="count-title">{{ __('home.txt_modules') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="count-area-content new-students">
                                        <div class="count-digit">{{ $students[0]->STUDENTS }}</div>
                                        <div class="count-title">{{ __('home.txt_student') }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="count-area-content">
                                        <div class="count-digit">{{ $certificates[0]->CERTIFICATES }}</div>
                                        <div class="count-title">{{ __('home.txt_certif') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="video">
                        <a href="https://www.youtube.com/watch?v=HndV87XpkWg" target="_blank"><img
                                src="assets/images/play-icon.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .accordion {
            --bs-accordion-btn-bg: none;
        }
        .accordion-item {
            border: 1px solid black;
            border-radius: calc(0.375rem - 1px) !important;
            margin-bottom: 1rem;
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

    <section class="py-7 d-flex align-items-center" style="min-height: 100vh">
        <div class="container">
            <div class="text-center fs-2 fw-semibold text-black mb-5">{{ __('home.txt_faq') }}</div>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="one">
                            <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colOne" aria-expanded="false" aria-controls="colOne">
                                {{ __('home.txt_faq_1') }}
                            </button>
                        </h2>
                        <div id="colOne" class="accordion-collapse collapse" aria-labelledby="one" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ __('home.txt_answer_1') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="two">
                            <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colTwo" aria-expanded="false" aria-controls="colTwo">
                                {{ __('home.txt_faq_2') }}
                            </button>
                        </h2>
                        <div id="colTwo" class="accordion-collapse collapse" aria-labelledby="two" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ __('home.txt_answer_2') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="three">
                            <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colThree" aria-expanded="false" aria-controls="colThree">
                                {{ __('home.txt_faq_3') }}
                            </button>
                        </h2>
                        <div id="colThree" class="accordion-collapse collapse" aria-labelledby="three" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ __('home.txt_answer_3') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="four">
                            <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colFour" aria-expanded="false" aria-controls="colFour">
                                {{ __('home.txt_faq_4') }}
                            </button>
                        </h2>
                        <div id="colFour" class="accordion-collapse collapse" aria-labelledby="four" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ __('home.txt_answer_4') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="five">
                            <button class="accordion-button collapsed fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#colFive" aria-expanded="false" aria-controls="colFive">
                                {{ __('home.txt_faq_5') }}
                            </button>
                        </h2>
                        <div id="colFive" class="accordion-collapse collapse" aria-labelledby="five" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ __('home.txt_answer_5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
