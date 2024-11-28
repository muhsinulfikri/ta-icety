<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="page-wrapper">
    <div class="tutori-course-content">
        <div class="container">
            <?php if ($event->EXPIRED == 1) { ?>
                <div class="alert alert-danger text-center" role="alert">
                    <h5 class="py-2">This event has been expired</h5>
                </div>
            <?php } ?>
            <div class="row pt-3">
                <div class="col-lg-5">
                    <!-- event Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0">
                        <div class="">
                            <div class="course-thumbnail d-flex justify-content-center">
                                <div class="pe-0 pe-sm-5 rounded-1">
                                    <img src="<?= $event->IMAGE_ACTIVITY ?>" class="d-block img-fluid h-auto ">
                                </div>
                            </div>

                            <div class="container">
                                <div class="my-3 fw-bold d-flex align-self-start justify-content-start pe-0 align-items-center text-black">
                                    Share :<span class="fs-5"> <i class="fab fa-facebook mx-2" style="cursor: pointer"></i><i class="fab fa-twitter me-2" style="cursor: pointer"></i><i class="fab fa-instagram" style="cursor: pointer"></i></span>
                                </div>
                                <?php if ($event->DATA_CHECKING == 0 && $event->EXPIRED != 1) : ?>
                                <div class="price-header mb-3">
                                    <h2 class="course-price">
                                        <?= ($event->PRICE_ACTIVITY == 0) ? "Free" : "Rp " . number_format($event->PRICE_ACTIVITY, 2, ',', '.') ?>
                                    </h2>
                                </div>
                                <div class="">
                                    <form class="" id="FormBuyNow-info" method="POST" action="<?= url('purchase') ?>">
                                    @csrf
                                        <div id="data-input-info"></div>
                                        <div class="w-100 button button-enroll-course btn btn-main-2 rounded" onclick="BuyNow()">Buy Now</div>
                                    </form>
                                    <button data-id-activity="<?= $event->ID_ACTIVITY ?>" onclick="AddToCart(this)" class="mt-2 w-100 button button-enroll-course btn btn-secondary btn-sm rounded">
                                        Add to Cart
                                    </button>
                                </div>
                                <?php endif ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-7 ps-3">
                    <div class="course-header-wrapper">

                        <div>
                            <h2 class="course-title bg-white">
                                <?= $event->TITLE_ACTIVITY ?>
                            </h2>
                        </div>
                    </div>
                    <nav class="course-single-tabs learn-press-nav-tabs">
                        <div class="nav nav-tabs course-nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home-tab" aria-selected="true">Overview</a>
                            <a class="nav-item nav-link" id="nav-instructor-tab" data-bs-toggle="tab" href="#nav-instructor" role="tab" aria-controls="nav-instructor-tab" aria-selected="false">Description</a>
                            <?php if (!empty(session('user')) && $event->DATA_CHECKING <> 0) : ?>
                                <a class="nav-item nav-link" id="nav-link-tab" data-bs-toggle="tab" href="#nav-link" role="tab" aria-controls="nav-link-tab" aria-selected="false">Link Conference</a>
                                <a class="nav-item nav-link" id="nav-certificate-tab" data-bs-toggle="tab" href="#nav-certificate" role="tab" aria-controls="nav-certificate-tab" aria-selected="false">Certificate</a>
                            <?php endif ?>

                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="single-course-details">
                                <h4 class="event-title mb-0">Tempat</h4>
                                <p>
                                    <?= $event->LOCATION ? $event->LOCATION : "-" ?>
                                </p>

                                <h4 class="course-title mb-0">Tanggal</h4>
                                <p><?= date_format(date_create($event->DATE_START), 'j F Y') ?></p>

                                <h4 class="course-title mb-0">Waktu</h4>
                                <p><?= date_format(date_create($event->DATE_START), 'H:i') ?></p>

                                <h4 class="course-title mb-0">Penyelenggara</h4>
                                <p>
                                    <?= $event->ORGANIZER ?>
                                </p>

                                <h4 class="course-title mb-0">Narahubung</h4>
                                <p>
                                    <?= $event->CONTACT_CUSTOMER ?>
                                </p>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-instructor" role="tabpanel" aria-labelledby="nav-instructor-tab">
                            <div class="courses-instructor">
                                <div class="single-instructor-box">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="instructor-content">
                                                <?= ($event->DESKRIPSI_EVENT <> NULL || $event->DESKRIPSI_EVENT <> "") ? $event->DESKRIPSI_EVENT : "Tidak Ada Deskripsi" ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty(session('user')) && $event->DATA_CHECKING <> 0) : ?>
                            <div class="tab-pane fade" id="nav-link" role="tabpanel" aria-labelledby="nav-link-tab">
                                <div class="courses-instructor">
                                    <div class="single-instructor-box">
                                        <div class="row align-items-center">

                                            <div class="col-12">
                                                <div class="instructor-content">
                                                    <a class="pe-4" href="<?= ($event->LINK_ZOOM <> NULL || $event->LINK_ZOOM <> "") ? $event->LINK_ZOOM : "#" ?>" style="color: #000EFF; word-wrap: break-word;">
                                                        <?= ($event->LINK_ZOOM <> NULL || $event->LINK_ZOOM <> "") ? $event->LINK_ZOOM : "Tidak Ada Link" ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-certificate" role="tabpanel" aria-labelledby="nav-certificate-tab">
                                <div class="courses-instructor">
                                    <div class="single-instructor-box">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <div class="instructor-content">
                                                    <?php if (date('Y-m-d h:i:s') < $event->DATE_END) { ?>

                                                        <div class="blurred-image" style="pointer-events: none">
                                                            <embed class="overlay" style="width:200px; height:352px; pointer-events: none;" src="<?= $sertif->FILE_SERTIFIKAT ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&messages=0&scrollbar=0" type="text/plain"></embed>
                                                        </div>
                                                        <div class="mt-3 rounded-4 d-flex align-items-center">
                                                            <div class="mx-4 py-3 bg-white">
                                                                <label>Sertificate Code</label>
                                                                <input type="text" class="form-control mb-4" name="" id="input-code">
                                                                <button type="button" class="btn btn-primary col-md-12 my-3" onclick="DownloadPdf(this)">Download PDF</button>
                                                            </div>
                                                        </div>
                                                    <?php } else if (date('Y-m-d h:i:s') > $event->DATE_START) { ?>
                                                        <h4 class="event-title mb-0">Event belum dimulai</h4>
                                                    <?php } else { ?>
                                                        <h4 class="event-title mb-0">Event sedang berlangsung</h4>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container pt-4">
            <hr class="mt-4" />

            <div class="course-latest">
                <h4 class="mb-4">Event Lainnya</h4>
                <div class="row course-gallery ">
                    <?php foreach ($other_event as $item) : ?>
                        <div class="course-item cat1 cat5 col-lg-6 col-md-6">
                            <a href="{{ url('event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) }}">
                                <div class="px-0 px-sm-3">
                                    <div class="single-course style-2 bg-shade border-0">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-xl-5">
                                                <div class="course-thumb" style="min-height: 150px !important;background:url(<?= str_replace(' ', '%20', $item->IMAGE_ACTIVITY) ?>)">
                                                </div>
                                            </div>
                                            <div class="col-xl-7">
                                                <div class="course-content">
                                                    <div class="course-price"><?= date_format(date_create($item->LOG_TIME), 'j F Y') ?></div>
                                                    <h3 class="course-title"> <?= $item->TITLE_ACTIVITY ?> </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .blurred-image {
        overflow: hidden;
    }

    .overlay {
        -webkit-filter: blur(4px);
        filter: blur(4px);
        pointer-events: none;
    }

    .box-input {
        max-height: 250px;
    }
</style>

<script>
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

    function AddToCart(e) {
        <?php if (!empty(session('user'))) { ?>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                didDestroy: (toast) => {
                    location.reload();
                }
            })
            $.ajax({
                url: '<?= Request::segment(0) ?>/add/order',
                type: "GET",
                data: {
                    id_activity: $(e).data("id-activity"),
                    type: 2
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
                title: 'Please Login First!'
            })
        <?php } ?>
    }

    function DownloadPdf(e) {
        if ($('#input-code').val() == '<?= $event->SERTIF_CODE ?>') {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            var file = '<?= empty($sertif->FILE_SERTIFIKAT) ? null : $sertif->FILE_SERTIFIKAT ?>'

            $.ajax({
                url: '<?= Request::segment(0) ?>/update-sertif',
                type: "POST",
                data: {
                    id_activity: "<?= $event->ID_ACTIVITY; ?>",
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

    function BuyNow() {
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
            <?php if (!empty($checking_trans)) { ?>
                Toast.fire({
                    icon: 'error',
                    title: 'You have unfinished transactions!'
                })
            <?php } else { ?>
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                $.ajax({
                    url: '<?= Request::segment(0) ?>/add/order',
                    type: "GET",
                    data: {
                        id_activity: '<?= $event->ID_ACTIVITY ?>',
                        type: 2
                    },
                    dataType: 'json',
                    success: function(data) {
                        let timerInterval
                        $('#data-input-info').append('<input type="hidden" name="id_order_purchase[0]" value="' + data.IdOrder + '" />')
                        Swal.fire({
                            title: 'Create Order!',
                            html: 'Please Wait ...',
                            timer: 2000,
                            timerProgressBar: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#FormBuyNow-info").submit();
                            }
                        })
                    }
                });
            <?php } ?>
        <?php } else { ?>
            Toast.fire({
                icon: 'error',
                title: 'Please Login First!'
            })
        <?php } ?>
    }
    <?php if (!empty(session('user')) && $event->DATA_CHECKING <> 0) { ?>


        function filename(path) {
            path = path.substring(path.lastIndexOf("/") + 1);
            return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
        }
    <?php } ?>
</script>
