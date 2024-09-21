<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="page-wrapper">
    <div class="tutori-course-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <!-- event Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0">
                        <div class="">
                            <div class="course-thumbnail d-flex justify-content-center">
                                <div class="pe-0 pe-sm-5 rounded-1">
                                    <img src="<?= $detail->IMAGE_EBOOK ?>" style="max-height: 400px"
                                        class="d-block img-fluid h-auto ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 ps-3">
                    <div class="course-header-wrapper">
                        <div>
                            <h2 class="course-title bg-white">
                                <?= $detail->JUDUL ?>
                            </h2>
                        </div>
                    </div>
                    <nav class="course-single-tabs learn-press-nav-tabs">
                        <div class="nav nav-tabs course-nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home-tab" aria-selected="true">Overview</a>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="single-course-details">
                                <h4 class="event-title mb-0">Description</h4>
                                <p>
                                    <?= $detail->DESC ? $detail->DESC : '-' ?>
                                </p>

                                <h4 class="event-title mb-0">Genre</h4>
                                <p>
                                    <?= $detail->GENRE ? $detail->GENRE : '-' ?>
                                </p>

                                <h4 class="course-title mb-0">Author</h4>
                                <p>
                                    <?= $detail->AUTHOR ?>
                                </p>

                                <h4 class="course-title mb-0">Year</h4>
                                <p>
                                    <?= $detail->TAHUN ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="book_iframe" style="align-content: center">
                <iframe src="https://tbh-v2.is3.cloudhost.id/EBOOK/Ebook-1725337103-1725337103.pdf#toolbar=0&navpanes=0"
                    style="width: 100%; height: 1000px;" frameborder="0"></iframe>
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

<script></script>
