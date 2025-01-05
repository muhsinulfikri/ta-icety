<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    body {
        font-family: "Noto Sans", serif !important;
    }

    .font {
        font-family: "Noto Sans", serif !important;
        color: black !important;
        line-height: 22px !important;
    }


    .ul li {
        list-style-type: disc !important;
    }

    .ol li {
        list-style-type: decimal !important;
    }

    .course-grid-template {
        grid-template-columns: repeat(4, minmax(0, 1fr));
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

<section class="py-6 bg-aqua">
    <div class="container">

        <!-- Course -->
        <div class="row">
            <div class="col-12 col-md-8 pe-0 pe-md-4 d-flex flex-column gap-3">
                <h2>Food Safety Management Course</h2>
                <div class="font ">Pemahaman mengenai industri pangan dari personal hygiene, sanitasi, foodborne illness, hingga cleaning dan pest control.</div>
                <div class="" style="border: 3px solid black"></div>
                <div class="font " style="font-size: 0.9rem;">
                    Di dalam module course ini terbagi menjadi 18 sesi yang tediri dari reading material, quiz, video clip, & post test. Setelah mengikuti keseluruhan sesi, anda akan mendapatkan Acknowledgement. Apabila Anda berhasil menyelesaikan post test dengan minimum threshold 80 point, maka Anda akan mendapatkan Certificate Food Safety Management Course (FSMC) yang diterima setelah proses knowledge validation (Anda akan menerima notifikasi email untuk proses knowledge validation. Dengan mengikuti course ini dan mendapatkan sertifikat, maka anda telah siap menjadi professional di industri culinary.
                </div>
                <div class="rounded px-3 py-3 d-flex gap-3 col-12 col-md-11" style="background: #E3E3E3;">
                    <div>
                        <img src="{{ asset('icety_assets') }}/logo-completion.svg" class="img-fluid" style="width: 47px" />
                    </div>
                    <div>
                        <div class="font fw-bold fs-5">Certificate of Completion</div>
                        <div class="font mt-1">Completing this course leads to obtaining a Certificate of Completion.</div>
                    </div>
                </div>
                <h2 class="font mt-2">What You Will Learn</h2>
                <div class="font ">Dalam course ini Anda akan memahami berbagai hal yang harus diketahui tentang keamanan pangan, antara lain:</div>
                <h3 class="font ">course outcomes</h3>
                <div class="my-2" style="border: 2px solid black;"></div>
                <ul class="ps-4 ul">
                    <li class="font">Understand Food Safety Management</li>
                </ul>
                <div class="my-2" style="border: 2px solid black;"></div>
                <ol class="ps-4 ol">
                    <li class="font ps-1">Personal Hygiene Program</li>
                    <li class="font ps-1">Time & Temperature Control in Culinary Process</li>
                    <li class="font ps-1">The Flow Of Food: Purchasing-Receiving-Storing-Cooking-Serving</li>
                    <li class="font ps-1">Cleaning & Sanitation</li>
                    <li class="font ps-1">Integrated Pest Management</li>
                </ol>
                <div>
                    <button class=" btn btn-secondary mt-3" style="padding-left: 2rem !important; padding-right: 2rem !important">Join Now</button>
                </div>
                <div class="font fst-italic" style="font-size: 0.6rem;">
                    * Private access classes available
                </div>
            </div>
            <div class="col-12 col-md-3 ms-0 ms-md-4 mt-4 mt-md-0 rounded-3 overflow-hidden h-100" style="background-color: #E3E3E3;">
                <div>
                    <img src="{{ asset('icety_assets') }}/card1.svg" class="img-fluid w-100" />
                </div>
                <div class="d-flex flex-column gap-3 py-3 px-4">
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-course.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Course type</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px">Short course</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-sertificate.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Credential type</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px">Certificate of completion</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-calendar.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Start date</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px">Start any time</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-time.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Duration</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px">Flexible</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-cost.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Cost</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px">Rp500,000 (IDR) to learn</div>
                        </div>
                    </div>
                    <div>
                        <button class=" btn btn-secondary mt-3" style="padding-left: 2rem !important; padding-right: 2rem !important; font-size: 0.8rem">Join Now</button>
                        <div class="font fst-italic mt-1" style="font-size: 0.6rem;">
                            * Private access classes available
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<!-- Another Course -->
<section class="pb-7">
    <div class="container ">
        <div class="fs-3 fw-semibold text-black">Ikuti juga Lainnya</div>

        <div class="d-flex gap-4 mt-5 mb-4">
            <button class="btn btn-tertiary btn-course active">Course</button>
            <button class="btn btn-tertiary btn-ebook">E-Book</button>
        </div>

        <div class="d-grid gap-4 course-grid-template course-container">

        </div>
        <div class="d-grid gap-4 course-grid-template ebook-container" style="display: none !important;">

        </div>

    </div>
</section>


<script>
    function createCard(data) {
        return `
            <div class="card card-course overflow-hidden" id="card-${data.id}" style="width: 276px; max-width: 276px; justify-self: center;">
                <div>
                    <img src="{{ asset('icety_assets') }}/${data.banner}" class="img-fluid" style="aspect-ratio: 23/13;" />
                </div>
                <div class="t-section h-100 w-100">
                    <div class="p-3 h-100">
                        <div class="bg-black shadow text-white px-2 py-0 mb-3 card-badge">${data.badge}</div>
                        <div class="fw-semibold text-black fs-5 mb-3" style="line-height: 22px;">${data.title}</div>
                        <div class="card-info" style="display: none;">
                            <div class="text-black fs-6 mb-2" style="line-height: 20px;">${data.description}</div>
                            <div class="d-flex justify-content-between mb-1">
                                <div>
                                    <img src="{{ asset('icety_assets') }}/icon-team.svg" class="img-fluid" style="height: 12px;" />
                                    <span class="text-black" style="font-size: 0.9rem">${data.students} Students</span>
                                </div>
                                <div>
                                    ${generateStars(data.stars)}
                                </div>
                            </div>
                            <a href="${data.link}" class="card-link">Find out more</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function generateStars(stars) {
        let starHTML = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= stars) {
                starHTML += `<img src="{{ asset('icety_assets') }}/star-black.svg" class="img-fluid" style="height: 12px;" />`;
            } else {
                starHTML += `<img src="{{ asset('icety_assets') }}/star-gray.svg" class="img-fluid" style="height: 12px;" />`;
            }
        }
        return starHTML;
    }

    const coursesData = [{
            id: '1',
            banner: 'card1.svg',
            title: 'Food Safety Management Course',
            badge: 'ICETy Class',
            description: 'Pemahaman mengenai industri pangan dari personal hygiene, sanitasi, foodborne illness, hingga cleaning',
            students: '88',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        },
        {
            id: '2',
            banner: 'card2.svg',
            title: 'The Chemistry of Cleaning',
            badge: 'ICETy Class',
            description: 'Pemahaman dasar mengenai cleaning dan sanitasi, serta aspek pendukung kebersihan lainnya.',
            students: '73',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        },
        {
            id: '3',
            banner: 'card3.svg',
            title: 'Handling Chemical Safety Course',
            badge: 'ICETy Class',
            description: 'Penanganan dan penyimpanan bahan Kimia berbahaya serta pertolongan pertama saat terkena bahan Kimia',
            students: '106',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        },
        {
            id: '4',
            banner: 'card4.svg',
            title: 'Cleanliness Management',
            badge: 'ICETy Class',
            description: 'Pemahaman mengenai industri pangan dari personal hygiene, sanitasi, foodborne illness, hingga cleaning dan',
            students: '88',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        }
    ];

    coursesData.forEach(data => {
        $('.course-container').append(createCard(data));

        $(`#card-${data.id} .t-section`).hover(
            function() {
                $(`#card-${data.id}  .card-info`).css({
                    display: "block",
                });
            },
            function() {
                $(`#card-${data.id}  .card-info`).css({
                    display: "none",
                });
            },
        );
    });

    const ebooksData = [{
            id: '5',
            banner: 'card1.svg',
            title: 'Food Safety Management Course',
            badge: 'ICETy E-Book',
            description: 'Pemahaman mengenai industri pangan dari personal hygiene, sanitasi, foodborne illness, hingga cleaning',
            students: '88',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        },
        {
            id: '6',
            banner: 'card2.svg',
            title: 'The Chemistry of Cleaning',
            badge: 'ICETy E-Book',
            description: 'Pemahaman dasar mengenai cleaning dan sanitasi, serta aspek pendukung kebersihan lainnya.',
            students: '73',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        },
        {
            id: '7',
            banner: 'card3.svg',
            title: 'Handling Chemical Safety Course',
            badge: 'ICETy E-Book',
            description: 'Penanganan dan penyimpanan bahan Kimia berbahaya serta pertolongan pertama saat terkena bahan Kimia',
            students: '106',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        },
        {
            id: '8',
            banner: 'card4.svg',
            title: 'Cleanliness Management',
            badge: 'ICETy E-Book',
            description: 'Pemahaman mengenai industri pangan dari personal hygiene, sanitasi, foodborne illness, hingga cleaning dan',
            students: '88',
            stars: 4,
            link: '/course/info/66?id_activity=ACT_a2e'
        }
    ];

    ebooksData.forEach(data => {
        $('.ebook-container').append(createCard(data));

        $(`#card-${data.id} .t-section`).hover(
            function() {
                $(`#card-${data.id}  .card-info`).css({
                    display: "block",
                });
            },
            function() {
                $(`#card-${data.id}  .card-info`).css({
                    display: "none",
                });
            },
        );
    });

    $('.btn-course').on('click', function() {
        $('.btn-ebook').removeClass('active')

        $(this).addClass('active')
        $('.ebook-container')[0].style.setProperty('display', 'none', 'important')
        $('.course-container').show()
    });

    $('.btn-ebook').on('click', function() {
        $('.btn-course').removeClass('active')

        console.log("haah")
        $(this).addClass('active')
        $('.ebook-container').show()
        $('.course-container')[0].style.setProperty('display', 'none', 'important')
    });
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


<section class="py-7" style="background: #E3E3E3;">
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
                            Apa bahasa yang digunakan dalam kursus-kursus di dalam ICETy?
                        </button>
                    </h2>
                    <div id="colThree" class="accordion-collapse collapse" aria-labelledby="three">
                        <div class="accordion-body">
                            Untuk saat ini, ICETy menggunakan bahasa Indonesia sebagai bahasa utama dalam pembelajaran.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>