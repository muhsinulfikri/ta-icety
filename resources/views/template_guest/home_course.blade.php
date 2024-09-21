<?php if (!empty($course)) { ?>
    <?php foreach ($course as $item) : ?>
        <!-- VIEW BELUM BAYAR -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="course-grid tooltip-style bg-white hover-shadow">
                <div class="course-header">
                    <div class="course-thumb">
                        <img src="<?= $item->IMAGE_ACTIVITY ?>" alt="" class="img-fluid">
                        <div class="course-price"><?= ($item->PRICE_ACTIVITY == 0) ? "Free" : "Rp " . number_format($item->PRICE_ACTIVITY, 2, ',', '.') ?></div>
                    </div>
                </div>

                <div class="course-content">
                    <h3 class="course-title "> <a href="<?= url('course/info/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) ?>"><?= $item->TITLE_ACTIVITY ?></a> </h3>
                    <div class="course-footer mb-20 d-flex align-items-center justify-content-between ">
                        <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important;
                            text-overflow: ellipsis !important;
                            display: -webkit-box !important;
                            -webkit-line-clamp: 4 !important;
                            -webkit-box-orient: vertical !important;">
                            <?= $item->DESKRIPSI_COURSE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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