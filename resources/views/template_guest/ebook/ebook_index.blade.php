<!-- <style>
    .page-header-custom {
        background: url('<?= asset('assets_new') ?>/images/bg/illustration-bg.png') 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        z-index: initial;
    }
</style> -->

<section class="py-5 py-md-7" style="background-color: #B90C0B;">
    <div class="container">
        <h1 class="font text-center" style="color: white !important">EBOOK</h1>
        <!-- <div class="justify-content-center mt-3 d-flex">
            <a href="/" class="font" style="color: white !important;text-decoration: underline;text-decoration-color: white;">Home</a>
            <div class="ms-2 me-1" style="border-left: 2px solid white;height: 27px">&nbsp;</div>
            <div class="font" style="color: white !important;">Courses</div>
        </div> -->
    </div>
</section>

<section class="section-padding page">
    <div class="container-fluid container-padding">
        <div class="row course-gallery justify-content-center">
            <div class="tab-content" id="nav-tabContent">
                <div class="row justify-content-center">
                    <?php if (!empty($ebook)) { ?>
                    <div class="row mt-md-4" style="margin-left: 0px !important; margin-right: 0px !important;">
                        <?php foreach ($ebook as $item) : ?>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="px-0 px-sm-3">
                                <div class="course-grid course-style-4 bg-white px-2 px-md-5 mt-4 pb-2">
                                    <div class="course-header">
                                        <div class="course-thumb">
                                            <a
                                                href="<?= url('ebooks/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->JUDUL))) . '?id_book=' . $item->ID_BUKU ?>">
                                                <img src="<?= $item->IMAGE_EBOOK ?>" alt="image"
                                                    style="width: 100%; height: 300px; object-fit: cover;">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="course-content">
                                        <h3 class="course-title mb-0"> <a
                                                href="<?= url('ebooks/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->JUDUL))) . '?id_book=' . $item->ID_BUKU ?>"><?= $item->JUDUL ?>
                                            </a> </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php } else { ?>
                    <h3 class="font-sm text-center">No Ebook available</h3>
                    <?php } ?>
                    </div>
                </div>
                <hr>
                <div
                    class="px-3 d-grid d-md-flex text-center justify-content-md-between justify-content-center align-items-center">
                    <div class="order-2 order-md-1 pt-3 pt-md-0">
                        <span class="fs-8 pagination-text">Showing {{ $ebook->currentPage() }} of
                            {{ $ebook->lastPage() }} Page</span>
                    </div>
                    <div class="order-1 order-md-2">
                        {{ $ebook->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
        $.ajax({
            url: 'add/order',
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
    }
</script>
