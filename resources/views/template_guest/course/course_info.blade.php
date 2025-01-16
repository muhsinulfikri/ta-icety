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
                <h2><?= $course->TITLE_ACTIVITY ?></h2>
                <div class="" style="border: 3px solid black"></div>
                <div class="font " style="font-size: 0.9rem;">
                    <?= $course->DESKRIPSI_COURSE ?>
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
                <div class="font "><?= $course->DESKRIPSI_COURSE_ITEM ?></div>
                <h3 class="font ">course outcomes</h3>
                <div class="my-2" style="border: 2px solid black;"></div>
                <?php

                use Illuminate\Support\Facades\Request;

                if (!empty($item_course)) { ?>
                    <?php foreach ($item_course as $item) :  ?>
                        <ul class="ps-4 ul">
                            <li class="font"><?= $item->TITLE ?></li>
                        </ul>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('assets_new') }}/images/empty.svg"
                            width="350">
                        <h4 class="font-sm text-center">Tidak ada bab</h4>
                    </div>
                <?php } ?>

                <div class="my-2" style="border: 2px solid black;"></div>

                <div>
                    <?php if (!empty($course->REQUIREMENT) && $course->REQ == 1) { ?>
                        <button data-id-activity="<?= $course->ID_ACTIVITY ?>" onclick="AddToCart(this)"
                            class="mt-2 button button-enroll-course btn btn-secondary btn-sm rounded">
                            Join Now
                        </button>
                    <?php } else if (empty($course->REQUIREMENT)) { ?>
                        <button data-id-activity="<?= $course->ID_ACTIVITY ?>" onclick="AddToCart(this)"
                            class="mt-2 button button-enroll-course btn btn-secondary btn-sm rounded">
                            Join Now
                        </button>
                    <?php } else { ?>
                        <label class="text-black" style="align-items: center">Please finish <span class="fw-bold text-danger"><?= $course->REQ_NAME ?></span> course first
                            before take this course</label>
                    <?php } ?>

                </div>
                <div class="font fst-italic" style="font-size: 0.6rem;">
                    * Private access classes available
                </div>
            </div>
            <div class="col-12 col-md-3 ms-0 ms-md-4 mt-4 mt-md-0 rounded-3 overflow-hidden h-100" style="background-color: #E3E3E3;">
                <div>
                    <img src="<?= $course->IMAGE_ACTIVITY ?>" class="img-fluid w-100" />
                </div>
                <div class="d-flex flex-column gap-3 py-3 px-4">
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-course.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Course categories</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px"><?= $course->KATEGORI ?></div>
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
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px"><?= date('F d, Y', strtotime($course->DATE_START)) ?></div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-time.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Duration</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px">Until <?= date('F d, Y', strtotime($course->DATE_END)) ?></div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <img src="{{ asset('icety_assets') }}/icon-cost.svg" class="img-fluid mt-1" />
                        </div>
                        <div>
                            <div class="font fw-bold">Cost</div>
                            <div class="font" style="font-size: 0.9rem;margin-top: -4px"><?= $course->PRICE_ACTIVITY == 0 ? 'Free' : 'Rp ' . number_format($course->PRICE_ACTIVITY, 2, ',', '.') ?> to learn</div>
                        </div>
                    </div>
                    <div>
                        <?php if (!empty($course->REQUIREMENT) && $course->REQ == 1) { ?>
                            <button data-id-activity="<?= $course->ID_ACTIVITY ?>" onclick="AddToCart(this)"
                                class="mt-2 button button-enroll-course btn btn-secondary btn-sm rounded">
                                Join Now
                            </button>
                        <?php } else if (empty($course->REQUIREMENT)) { ?>
                            <button data-id-activity="<?= $course->ID_ACTIVITY ?>" onclick="AddToCart(this)"
                                class="mt-2 button button-enroll-course btn btn-secondary btn-sm rounded">
                                Join Now
                            </button>
                        <?php } else { ?>
                            <label class="text-black" style="align-items: center">Please finish <span class="fw-bold text-danger"><?= $course->REQ_NAME ?></span> course first
                                before take this course</label>
                        <?php } ?>
                        <div class="font fst-italic mt-1" style="font-size: 0.6rem;">
                            * Private access classes available
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<script>
    function AddToCart(e) {
        const Toast = Swal.mixin({
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
        <?php if (!empty(session('user'))) { ?>
            $.ajax({
                url: '<?= Request::segment(0) ?>/add/order',
                type: "GET",
                data: {
                    id_activity: $(e).data("id-activity"),
                    type: 1
                },
                dataType: 'json',
                success: function(data) {
                    Toast.fire({
                        icon: (data.Status) ? 'success' : 'error',
                        title: data.Message
                    })
                }
            });
        <?php } else { ?>
            Toast.fire({
                icon: 'error',
                title: 'Please login first!'
            })
        <?php } ?>
    }
</script>

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

    const coursesData = @json($courses);
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

    const ebooksData = @json($ebooks);


    ebooksData.forEach(data => {
        $('.ebook-container').append(createCardBook(data));
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
