<?php if (!empty($course)) { ?>
    <div class="row mt-md-4">
        <?php foreach ($course as $item) : ?>
            <?php if (session('user') != null && $item->DATA_CHECKING == 1) { ?>
                <!-- VIEW SUDAH BAYAR -->
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="px-0 px-sm-3">
                        <div class="course-grid course-style-4 bg-white" style="padding: 30px 30px 10px 30px;">
                            <div class="course-header">
                                    <a href="<?= url('course/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) ?>">
                                        <img src="<?= $item->IMAGE_ACTIVITY ?>" alt="" style="width: 100%; height: 300px; object-fit: cover;">
                                    </a>
                            </div>

                            <div class="course-content">
                                <?php if ($item->PROGRESS == 100) { ?>
                                    <span class="course-price bg-success">Done</span>
                                <?php } else { ?>
                                    <span class="course-price bg-success">Progress <?= ceil($item->PROGRESS) ?>%</span>
                                <?php } ?>
                                <h3 class="course-title"> <a href="<?= url('course/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) ?>"><?= $item->TITLE_ACTIVITY ?> </a> </h3>
                            </div>
                            <div class="course-meta">
                                <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                    display: -webkit-box !important;
                                    -webkit-line-clamp: 2 !important;
                                    -webkit-box-orient: vertical !important;">
                                    <?= $item->DESKRIPSI_COURSE ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <!-- VIEW BELUM BAYAR -->
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="px-0 px-sm-3">
                        <div class="course-grid course-style-4 bg-white" style="padding: 30px 30px 10px 30px;">
                            <div class="course-header">
                                <div class="" style="width: 100%; height: 300px; overflow: hidden;">
                                    <a href="<?= url('course/info/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) ?>">
                                        <img src="<?= $item->IMAGE_ACTIVITY ?>" alt="" style="width: 100%; height: 300px; object-fit: cover;">
                                    </a>
                                </div>
                            </div>

                            <div class="course-content">
                                <span class="course-price <?= ($item->PRICE_ACTIVITY == 0) ? "bg-success" : "bg-primary" ?>"><?= ($item->PRICE_ACTIVITY == 0) ? "Free" : "Rp " . number_format($item->PRICE_ACTIVITY, 2, ',', '.') ?></span>
                                <h3 class="course-title"> <a href="<?= url('course/info/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) ?>"><?= $item->TITLE_ACTIVITY ?> </a> </h3>
                            </div>
                            <div class="course-meta">
                                <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                    display: -webkit-box !important;
                                    -webkit-line-clamp: 2 !important;
                                    -webkit-box-orient: vertical !important;">
                                    <?= $item->DESKRIPSI_COURSE ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php endforeach; ?>
    </div>

<?php } else { ?>
    <div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
        <div class=" rounded-5 px-3 pb-4 h-auto d-flex flex-column" style="margin-top: -60px;">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('assets_new') }}/images/empty.svg" width="350">
            </div>
            <h3 class="font-sm text-center">No course available</h2>

        </div>
    </div>
<?php } ?>
