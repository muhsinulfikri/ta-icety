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
                        <?php if (!empty(session('err_msg'))) { ?>
                            <div class="alert alert-danger">
                                <div class="d-flex align-items-center justify-content-start">
                                    <span class="alert-icon">
                                        <i class="anticon anticon-check-o"></i>
                                    </span>
                                    <span><?= session('err_msg') ?></span>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty(session('succ_msg'))) { ?>
                            <div class="alert alert-success">
                                <div class="d-flex align-items-center justify-content-start">
                                    <span class="alert-icon">
                                        <i class="anticon anticon-check-o"></i>
                                    </span>
                                    <span><?= session('succ_msg') ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="single-course-details">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Kedaluwarsa!</h4>
                            <p>Course ini sudah tidak dapat diakses karena masa aktifnya telah habis. Jika Anda ingin melanjutkan course atau mengunduh kembali sertifikat, Anda diharuskan untuk membeli course ini terlebih dahulu.</p>
                            <hr>
                            <p class="mb-0">Silakan lakukan pembelian ulang untuk mendapatkan kembali akses.</p>
                            <p class="mb-0">Tapi tenang, progres Anda akan tetap tersimpan meskipun course ini sudah kedaluwarsa.</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end w-100 mt-3">
                        <button type="button" class="btn btn-primary" onclick="buyBack()">Beli Ulang</button>
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
        width: 450px;
        pointer-events: none;
    }

    .box-input {
        max-height: 250px;
    }
</style>

<script>
    function buyBack() {
        location.href = "<?= url('buyback') . '?id_activity=' . $id_activity ?>"
    }
</script>