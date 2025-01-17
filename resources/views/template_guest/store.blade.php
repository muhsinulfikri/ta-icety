<style>
    .course-grid-template {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .font-title {
        font-size: 4rem;
        line-height: 4.5rem;
    }

    .font {
        font-family: "Noto Sans", serif !important;
        color: black !important;
        line-height: 22px !important;
    }

    .img-banner {
        width: 20%;
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

    @media (max-width: 770px) {
        .img-banner {
            width: 50%;
            align-self: center;
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
<section class=" banner-image banner-style-4 banner-padding p-0 bg-white">
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row gap-4">
            <img src="{{ asset('icety_assets') }}/banner.svg" class="img-fluid img-banner">
            <div class="d-flex flex-column justify-content-center">
                <h2 class="fw-bold text-black">Pelajari Beragam Skill Kebersihan & Sanitasi,
                    Bangun Reputasi Profesional, dan Raih Sertifikat Resmi.</h2>
                <div class="font mt-2">Akses semua materi dengan sekali bayar. Dapatkan pengalaman belajar yang lebih dari sekadar menonton video rekaman.</div>
                <div class="text-center text-sm-start">
                    <a href="#course-section" class="btn btn-secondary my-4 " style="font-size: 0.75rem">Lihat Program Pilihan</a>
                </div>
            </div>
        </div>
    </div>
</section>

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

<section class="container pt-6">
    <div class="text-center fs-3 fw-semibold text-black">Mengapa Memilih ICETy.org</div>
    <div class="d-flex flex-column flex-md-row gap-5 justify-content-between pt-6">
        <div class="card card-why flex-fill p-4 hover-shadow">
            <div class="align-self-center mb-4">
                <img src="{{ asset('icety_assets') }}/icon-solusi.svg" class="img-fluid" style="width: 55px; height:55px" />
            </div>
            <div class="text-center text-black fw-semibold fs-5">Solusi Praktis</div>
            <div class="text-center text-black mt-2" style="line-height:22px">Menyediakan solusi kebersihan dan sanitasi untuk berbagai kebutuhan masyarakat dan industri.</div>
        </div>
        <div class="card card-why flex-fill p-4 hover-shadow">
            <div class="align-self-center mb-4">
                <img src="{{ asset('icety_assets') }}/icon-kursus.svg" class="img-fluid" style="width: 55px; height:55px" />
            </div>
            <div class="text-center text-black fw-semibold fs-5">Pengalaman Kursus Online</div>
            <div class="text-center text-black mt-2" style="line-height:22px">Modul kursus interaktif dengan teknologi VR dan AR untuk pembelajaran kebersihan yang menyeluruh.</div>
        </div>
        <div class="card card-why flex-fill p-4 hover-shadow">
            <div class="align-self-center mb-4">
                <img src="{{ asset('icety_assets') }}/icon-citra.svg" class="img-fluid" style="width: 55px; height:55px" />
            </div>
            <div class="text-center text-black fw-semibold fs-5">Meningkatkan Citra Pariwisata Indonesia</div>
            <div class="text-center text-black mt-2" style="line-height:22px">Mendukung destinasi wisata Indonesia agar berstandar internasional dalam kebersihan dan sanitasi.</div>
        </div>
    </div>
</section>




<!-- Course -->
<section id="course-section" class="py-7">
    <div class="container">
        <div class="d-flex gap-4 mt-5 mb-4">
            <button class="btn btn-tertiary btn-course active">Course</button>
            <button class="btn btn-tertiary btn-ebook">E-Book</button>
            <button class="btn btn-tertiary btn-event">Event</button>
        </div>


        <div class="d-grid gap-4 course-grid-template course-container">

        </div>
        <div class="d-grid gap-4 course-grid-template ebook-container" style="display: none !important;">

        </div>
        <div class="d-grid gap-4 course-grid-template event-container" style="display: none !important;">

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


    $(document).on('click','.btn-course', function() {
        $('.btn-ebook').removeClass('active')
        $('.btn-event').removeClass('active')

        $(this).addClass('active')
        $('.ebook-container')[0].style.setProperty('display', 'none', 'important')
        $('.event-container')[0].style.setProperty('display', 'none', 'important')
        $('.course-container').show()
    });

    $(document).on('click','.btn-ebook', function() {
        $('.btn-course').removeClass('active')
        $('.btn-event').removeClass('active')
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
