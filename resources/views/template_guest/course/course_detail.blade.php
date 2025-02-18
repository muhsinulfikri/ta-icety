<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="page-wrapper">
    <div class="tutori-course-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="mb-3">
                        <div>
                            <h2 class="course-title bg-white">
                                <?= $course->TITLE_ACTIVITY ?>
                            </h2>
                        </div>
                    </div>
                    <div class="mb-3" style="border: 3px solid black"></div>

                    <nav class="course-single-tabs learn-press-nav-tabs">
                        <div class="nav nav-tabs course-nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home-tab" aria-selected="true">Overview</a>
                            <a class="nav-item nav-link" id="nav-instructor-tab" data-bs-toggle="tab"
                                href="#nav-instructor" role="tab" aria-controls="nav-instructor-tab"
                                aria-selected="false">Instructor</a>
                            <a class="nav-item nav-link" id="nav-komentar-tab" data-bs-toggle="tab" href="#nav-komentar"
                                role="tab" aria-controls="nav-komentar-tab" aria-selected="true">Komentar</a>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="single-course-details">
                                <h4 class="course-title">Description</h4>
                                <p>
                                    <?= !empty($course->DESKRIPSI_COURSE) ? $course->DESKRIPSI_COURSE : 'Tidak ada deskripsi' ?>
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-instructor" role="tabpanel"
                            aria-labelledby="nav-instructor-tab">
                            <!-- Course instructor start -->
                            <div class="courses-instructor">
                                <div class="single-instructor-box">
                                    <div class="row align-items-center">

                                        <div class="col-lg-8 col-md-8">
                                            <div class="instructor-content">
                                                <h4><?= $course->NAME ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Conurse  instructor end -->
                        </div>
                        <div class="tab-pane fade" id="nav-komentar" role="tabpanel" aria-labelledby="nav-komentar-tab">
                            <!-- Course Komentar start -->
                            <div class="courses-komentar">
                                <div class="single-komentar-box">
                                    <div class="row align-items-center">

                                        <div class="col-lg-12 col-md-8">
                                            <div class="komentar-content">
                                                @if ($komentar == null)
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="{{ asset('assets_new') }}/images/empty.svg"
                                                        width="350">
                                                    <h4 class="font-sm text-center">Belum Ada Komentar</h4>
                                                </div>
                                                @endif
                                                @if ($komentar != null)
                                                <div class="container my-2 py-2">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-12 col-lg-10">
                                                            <div class="card text-body">
                                                                @foreach ($komentar as $item)
                                                                <div class="card-body p-4">
                                                                    <div class="d-flex flex-start">
                                                                        <img class="rounded-circle shadow-1-strong me-3"
                                                                            src="<?= $item->FOTO_PROFILE == null ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973461_1280.png' : $item->FOTO_PROFILE ?>"
                                                                            alt="avatar" width="60"
                                                                            height="60" />
                                                                        <div>
                                                                            <h6 class="fw-bold mb-1">
                                                                                <?= $item->NAME ?></h6>
                                                                            <div
                                                                                class="d-flex align-items-center mb-3">
                                                                                <p class="mb-0">
                                                                                    <?= date('F d, Y', strtotime($item->LOG_TIME)) ?>
                                                                                </p>
                                                                            </div>
                                                                            <p class="mb-0">
                                                                                <?= $item->komentar ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="my-0" />
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Conurse Komentar end -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-xl-4">
                    <!-- Course Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0 rounded" style="">
                        <div class="course-widget course-details-info rounded-3 p-0" style="margin: 30px;background: #E3E3E3;">
                            <div class="course-thumbnail mb-0">
                                <img src="<?= $course->IMAGE_ACTIVITY ?>" alt="" class="img-fluid w-100" />
                            </div>
                            <ul class="course-sidebar-list py-3 px-4 mt-0">
                                <li class="border-0">
                                    <div class="d-flex gap-3">
                                        <div class="text-black fs-4 mt-1">
                                            <i class="far fa-sliders-h"></i>
                                        </div>
                                        <div>
                                            <div class="text-black fw-bold">Progress</div>
                                            <div class="" style="font-size: 0.9rem;margin-top: -4px">
                                                <h2
                                                    class="course-price <?= $tot_proggress == 100 ? 'text-success' : 'text-danger' ?>">
                                                    <?= ceil($tot_proggress) ?>%
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex gap-3">
                                        <div class="text-black fs-4 mt-1">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                        <div>
                                            <div class="text-black fw-bold">Kategori</div>
                                            <div class="text-black" style="font-size: 0.9rem;margin-top: -4px">
                                                <?= $course->KATEGORI ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <nav class="course-single-tabs learn-press-nav-tabs">
                        <div class="nav nav-tabs course-nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-course-tab" data-bs-toggle="tab"
                                href="#nav-course" role="tab" aria-controls="nav-course-tab"
                                aria-selected="true">Course</a>
                            <a class="nav-item nav-link" id="nav-announcement-tab" data-bs-toggle="tab"
                                href="#nav-announcement" role="tab" aria-controls="nav-announcement-tab"
                                aria-selected="false">Announcement</a>
                            <?php if ($tot_proggress == 100) { ?>
                                <a class="nav-item nav-link" id="nav-sertif-tab" data-bs-toggle="tab" href="#nav-sertif"
                                    role="tab" aria-controls="nav-sertif-tab" aria-selected="false">Certificate</a>
                                <a class="nav-item nav-link" id="nav-komen-tab" data-bs-toggle="tab" href="#nav-komen"
                                    role="tab" aria-controls="nav-komen-tab" aria-selected="false">Komentar</a>
                            <?php } ?>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-course" role="tabpanel"
                            aria-labelledby="nav-course-tab" tabindex="0">
                            <div class="row flex-row gap-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button id="refreshPageBtn" type="button" class="btn btn-primary"
                                        style="padding: 5px !important;">Refresh</button>
                                </div>
                                <div class="col-3 mb-4 d-none d-lg-block">
                                    <?php
                                    $quiz = 0;
                                    $materi = 0;

                                    foreach ($item_course as $item) {
                                        if ($item->TYPE <> 2) { ?>

                                            <button
                                                class="button <?= $item->STATUS == 1 ? 'btn-main-outline' : 'btn-grey' ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100"
                                                id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>"
                                                data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>"
                                                onclick="ShowDetailItem(this)" <?= $item->STATUS == 0 ? 'disabled' : '' ?>>
                                                <?= $item->TITLE ?>
                                            </button>
                                        <?php } else { ?>
                                            <button
                                                class="button <?= $item->STATUS == 1 ? 'btn-main-outline' : 'btn-grey' ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100"
                                                id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>"
                                                data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>"
                                                onclick="ShowDetailItem(this)" <?= $item->STATUS == 0 ? 'disabled' : '' ?>>
                                                Quiz <?= ++$quiz ?>
                                            </button>
                                    <?php }
                                    } ?>
                                    <?php
                                    $grade = !empty($nilai->NILAI) ? $nilai->NILAI : 0;
                                    if ($tot_proggress == 100) { ?>
                                        <button
                                            class="button btn-main-outline px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100 btn-code"
                                            onclick="ShowCertificateCode(this)" data-type="5">
                                            Show Certificate Code
                                        </button>
                                        @if ($course->FINAL_EXAM != null)
                                        <button
                                            class="button btn-main-outline px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100 btn-code"
                                            onclick="ShowFinalExam(this)" data-type="6">
                                            Final Exam
                                        </button>
                                        @endif
                                    <?php } ?>
                                </div>
                                <div class="col bg-white shadow rounded" id="detail-item">
                                    <div class="py-5">
                                        <div class="d-flex justify-content-center">
                                            <img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif"
                                                alt="Loader.gif" />
                                        </div>
                                        <div class="d-flex justify-content-center pt-4">
                                            Choose Materi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-announcement" role="tabpanel"
                            aria-labelledby="nav-announcement-tab" tabindex="0">
                            <div class="mx-3 mx-lg-7 my-4 text-muted">
                                <?= !empty($course->PENGUMUMAN) ? $course->PENGUMUMAN : 'Tidak ada pengumuman' ?>
                            </div>
                        </div>
                        <?php
                        if ($tot_proggress == 100) { ?>
                            <div class="tab-pane fade" id="nav-sertif" role="tabpanel" aria-labelledby="nav-sertif-tab"
                                tabindex="0">
                                <div class="d-flex justify-content-center">
                                    <div class="blurred-image" style="pointer-events: none">
                                        <embed class="overlay" style="width:600px; height:500px; pointer-events: none;"
                                            src="<?= $sertif->FILE_SERTIFIKAT ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&messages=0&scrollbar=0"
                                            type="text/plain"></emb>
                                    </div>
                                    <div class="shadow mx-5 mt-3 rounded-4 box-input d-flex align-items-center">
                                        <div class="mx-4 py-3 bg-white">
                                            <label>Sertificate Code</label>
                                            <form action="javascript:void(0)">
                                                <input type="text" class="form-control mb-4" name=""
                                                    id="input-code">
                                                <button type="button" class="btn btn-primary col-md-12 my-3"
                                                    onclick="DownloadPdf(this)">Download PDF</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-komen" role="tabpanel" aria-labelledby="nav-komen-tab"
                                tabindex="0">
                                <div style="display: flex; justify-content: center; width: 100%;">
                                    <form action="addkomen" method="POST" style="width: 100%; max-width: 800px;">
                                        @csrf
                                        <input type="hidden" name="id_activity" value="<?= $id_activity ?>">
                                        <input type="hidden" name="id_user"
                                            value="<?= session('user')[0]['ID_USER'] ?>">
                                        <div
                                            style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); margin: 1rem auto; border-radius: 0.5rem; padding: 1rem; display: flex; flex-direction: column; align-items: center;">
                                            <div style="width: 100%; padding: 1rem;">
                                                <label for="komentar">Komentar</label>
                                                <textarea class="form-control mb-4" rows="4" name="komentar" id="komentar" required style="width: 100%;"></textarea>
                                                <div style="display: flex; justify-content: flex-end;">
                                                    <button type="submit" class="btn btn-primary"
                                                        style="width: 20%;">Kirim</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="container my-2 py-2">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12 col-lg-10">
                                            <div class="card text-body">
                                                @foreach ($komentar as $item)
                                                <div class="card-body p-4">
                                                    <div class="d-flex flex-start">
                                                        <img class="rounded-circle shadow-1-strong me-3"
                                                            src="<?= $item->FOTO_PROFILE == null ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973461_1280.png' : $item->FOTO_PROFILE ?>"
                                                            alt="avatar" width="60" height="60" />
                                                        <div>
                                                            <h6 class="fw-bold mb-1"><?= $item->NAME ?></h6>
                                                            <div class="d-flex align-items-center mb-3">
                                                                <p class="mb-0">
                                                                    <?= date('F d, Y', strtotime($item->LOG_TIME)) ?>
                                                                </p>
                                                            </div>
                                                            <p class="mb-0">
                                                                <?= $item->komentar ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="my-0" />
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Final Exam -->
<div class="modal fade" id="redeemModal" tabindex="-1" aria-labelledby="redeemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="redeemModalLabel">Enter The Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-redeem" action="" method="post">
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="trial_code" id="trial_code" required>
                    <div class="alert-code"></div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="useFinalCode()">Apply Code</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Buy Code -->
<div class="modal fade" id="buyCodeModal" tabindex="-1" aria-labelledby="buyCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="buyCodeModalLabel">Buy Code Exam</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <form id="buy-code-exam" action="" method="post">
                    <div class="mb-3">
                        <label class="fw-bold">Nama :</label>
                        <p class="text-muted mb-0">Final Exam</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Price :</label>
                        <p class="text-muted mb-0">Rp 10,923</p>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-3" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4 py-2 rounded-3">Purchase Now</button>
            </div>
        </div>
    </div>
</div>


<style>
    .blurred-image {
        overflow: hidden;
    }

    .overlay {
        -webkit-filter: blur(4px);
        filter: blur(4px);
        width: 450px;
        pointer-events: none;
    }

    .box-input {
        max-height: 250px;
    }
</style>

<script>
    $('#refreshPageBtn').click(function() {
        // Reload the page
        location.reload();
    });
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    CheckingMapping()
    $('#show-detail-' + <?= $last_item[0]->ID_ITEM ?>).trigger('click')

    <?php if ($tot_proggress == 100) { ?>

        function DownloadPdf(e) {
            if ($('#input-code').val() == '<?= $course->SERTIF_CODE ?>') {
                var file = '<?= empty($sertif->FILE_SERTIFIKAT) ? null : $sertif->FILE_SERTIFIKAT ?>'

                $.ajax({
                    url: '<?= Request::segment(0) ?>/update-sertif',
                    type: "POST",
                    data: {
                        id_activity: "<?= $course->ID_ACTIVITY ?>",
                    },
                    success: function(data) {
                        window.open(file, '_blank');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error: ", textStatus, errorThrown);
                        console.error("Response Text: ", jqXHR.responseText);
                    }
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Wrong Code!'
                })
            }
        }

        function filename(path) {
            path = path.substring(path.lastIndexOf("/") + 1);
            return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
        }
    <?php } ?>

    function ShowCertificateCode(e) {
        <?php foreach ($item_course as $item) :  ?>
            $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('btn-primary')
            $('#show-detail-' + <?= $item->ID_ITEM ?>).addClass('btn-main-outline')
        <?php endforeach; ?>
        $(e).removeClass('btn-main-outline')
        $(e).addClass('btn-primary')
        $("#detail-item").html(
            '<div class="d-flex justify-content-center align-items-center h-100"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>'
        );
        $("#detail-item").html(`<div class="d-flex justify-content-center align-items-center h-100">
                <div class="bg-white px-3 py-2 rounded-3 shadow fw-semibold text-center">
                    <i class="bi bi-file-text me-2" style="font-size: 1.1rem; -webkit-text-stroke: 0.2px;"></i>
                    Your Certificate Code :
                    <h6><?= $course->SERTIF_CODE ?></h6>
                </div>
            </div>`);
    }

    function ShowFinalExam(e) {
        <?php foreach ($item_course as $item) :  ?>
            $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('btn-primary')
            $('#show-detail-' + <?= $item->ID_ITEM ?>).addClass('btn-main-outline')
        <?php endforeach; ?>
        $(e).removeClass('btn-main-outline')
        $(e).addClass('btn-primary')
        $("#detail-item").html(
            '<div class="d-flex justify-content-center align-items-center h-100"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>'
        );
        $("#detail-item").html(`<div class="d-flex justify-content-center align-items-center h-100">
                <div class="bg-white px-3 py-2 rounded-3 shadow fw-semibold text-center">
                    @if ($final_exam != null)
                    <h6 class="mt-2">Code Final Exam : <?= $final_exam != null ? $final_exam->CODE_EXAM : 'Anda tidak memiliki Code Exam yang Aktif'?></h6>
                    @endif
                    @if ($final_exam == null)
                    <h6 class="mt-2">Anda tidak memiliki Code Exam yang Aktif klik dibawah ini untuk membeli code exam</h6>
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#buyCodeModal">
                        Buy Code Exam
                    </button>
                    @endif
                    <br>
                    <i class="bi bi-file-text me-2" style="font-size: 1.1rem; -webkit-text-stroke: 0.2px;"></i>
                    Klick Here For Final Exam
                    <br>
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#redeemModal">
                    Final Exam
                    </button>
                </div>
            </div>`);
    }

    function ShowDetailItem(e) {

        if ($(e).data("type") == 3) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Try Again!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let timerInterval
                    Swal.fire({
                        title: 'Reseting Quiz On Proccess !',
                        html: 'it will be over in a few seconds.',
                        timer: 2000,
                        timerProgressBar: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        GetItemCourse(e)
                        // location.reload()
                    })
                }
            })
        } else {
            if ($(e).data("type") != 4) {
                $('.btn-code').removeClass('btn-primary')
                $('.btn-code').addClass('btn-main-outline')
                <?php foreach ($item_course as $item) :  ?>
                    $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('btn-primary')
                    $('#show-detail-' + <?= $item->ID_ITEM ?>).addClass('btn-main-outline')
                <?php endforeach; ?>
            }
            GetItemCourse(e)
        }
    }

    function CheckingMapping() {
        <?php foreach ($item_course as $item) :  ?>
            if (<?= $item->STATUS ?> != 1) {
                $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('border-primary')
                $('#show-detail-' + <?= $item->ID_ITEM ?>).addClass('text-disable')
                $('#show-detail-' + <?= $item->ID_ITEM ?>).prop("disabled", true)
            }
        <?php endforeach; ?>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $.ajax({
            url: "<?= Request::segment(0) ?>/course/item/mapping",
            type: "POST",
            data: {
                id_activity: "<?= $id_activity ?>"
            },
            dataType: 'json',
            success: function(data) {
                $.each(data, function(key, value) {
                    if (value.STATUS == 1) {
                        $('#show-detail-' + value.ID_ITEM).removeClass('text-disable')
                        $('#show-detail-' + value.ID_ITEM).addClass('border-primary')
                        $('#show-detail-' + value.ID_ITEM).prop("disabled", false)
                    }
                });
            }
        });
    }

    function GetItemCourse(e) {
        $(e).removeClass('btn-main-outline');
        $(e).addClass('btn-primary');
        $("#detail-item").html(
            '<div class="d-flex justify-content-center align-items-center h-100"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>'
        );

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            url: '<?= Request::segment(0) ?>/course/item',
            type: "POST",
            data: {
                id_item: $(e).data("iditem"),
                type: $(e).data("type"),
                id_activity: "<?= $id_activity ?>",
                status: $(e).data("status")
            },
            success: function(data) {
                CheckingMapping();
                $("#detail-item").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
                console.error("Response Text: ", jqXHR.responseText);
                $("#detail-item").html(
                    '<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>'
                );
            }
        });
    }

    const readmoreText = document.querySelector('.readmore-text');
    const readmoreBtn = document.querySelector('.readmore-btn');
    const icon = document.getElementById('icon-btn');
    const textContent = document.querySelector('.text-btn-content');
    let isExpanded = false;
    const realHeight = readmoreText.clientHeight;
    const defaultHeight = '200px';

    const toggleExpandedState = () => {
        isExpanded = !isExpanded;
        const newHeight = isExpanded ? `${realHeight + 30}px` : defaultHeight;
        const newText = isExpanded ? 'Less Info' : 'More Info';
        const upClass = 'bi-chevron-up';
        const downClass = 'bi-chevron-down';

        readmoreText.style.height = newHeight;
        textContent.innerHTML = newText;
        icon.classList.remove(isExpanded ? downClass : upClass);
        icon.classList.add(isExpanded ? upClass : downClass);
    };

    readmoreText.style.height = defaultHeight;
    readmoreBtn.addEventListener('click', toggleExpandedState);

    function useFinalCode() {
        var code = $('#trial_code').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            url: '<?= Request::segment(0) ?>/course/final-exam/validasi-code',
            type: "POST",
            data: {
                code: code,
                id_activity: "<?= $id_activity ?>"
            },
            success: function(data) {
                if (data.status == 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Continue'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ url('course/final-exam/'.$course->FINAL_EXAM.'/'. ($final_exam != null ? $final_exam->CODE_EXAM : '#')) }}";
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Close'
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
                console.error("Response Text: ", jqXHR.responseText);
                showAlertModal('Error', jqXHR.responseText, 'error')
            }
        });
    }
</script>