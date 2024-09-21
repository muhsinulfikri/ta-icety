<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <div class="d-flex justify-content-between">
        <div class="image-ebook rounded-5 text-black me-lg-4">
            <div>
                <h1 class=" fw-bold">Ebook List</span></h1>
            </div>
        </div>
    </div>
</div>
<div class="container px-4 px-md-0 py-4 pb-6 pt-3 mt-3 d-flex justify-content-between align-items-center">
    <div class="input-group rounded-pill border px-4 py-2" style="width: 492px;">
        <input class="form-control shadow-none border-0 rounded-pill search" type="text" placeholder="Search" id="example-search-input">
        <div class="vr" style="margin-top:8px;margin-bottom:8px;margin-right:2px"></div>
        <span class=" input-group-append">
            <button class="btn btn-outline-black bg-white rounded-pill" style type="button">
                <i class="bi bi-search"></i>
            </button>
        </span>
    </div>
</div>
<!-- <div class="container p-0 mb-4">
    <div class="row gap-2"> -->
<!-- List Perulangan start -->
<!-- <?php foreach ($ebook as $book) { ?>
            <div class="card" style="width: 18rem;">
                <img src="<?= $book->IMAGE_EBOOK ?>" class="card-img-top" style="height: 282px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= $book->JUDUL ?></h5>
                    <p class="card-text"><?= $book->AUTHOR ?></p>
                    <p style="color:black;">Rp <?= ($book->PRICE == 0) ? "FREE" : $book->PRICE ?></p>
                </div>
                <div class="card-footer">
                    <?php if ($book->DATA_CHECKING != 1) { ?>
                        <div class="row align-items-center">
                            <div class="col-9">
                                <form id="FormBuyNow-info" method="POST" action="<?= url('purchase') ?>">
                                    <div id="data-input-info"></div>
                                    <div class="w-100 button button-enroll-course btn btn-main-2 rounded" onclick="BuyNow()">Buy Now</div>
                                </form>
                            </div>
                            <div class="col-3" style="padding: 0px !important; height: 50px">
                                <button type="button" onclick="AddToCart(this)" href="javascript:void(0)" data-id-activity="<?= $book->ID_BUKU ?>">
                                    <i class="fad fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="d-flex mt-3 align-items-center">
                            <button type="button" class="btn btn-primary rounded-2 " data-toggle="modal" data-target="#exampleModalCenter" style="height: 35px; width: 150px;">
                                <p class="m-0 fw-semibold" data-toggle="modal" data-target="#exampleModal">Read</p>
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?> -->
<!-- List Perulangan end -->
<!-- </div> -->

<div class="container-fluid container-padding">
    <div class="row gap-3">
        <div class="col-12 col-lg bg-white row">
            <?php foreach ($ebook as $item) : ?>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="px-0 px-sm-4">
                        <div class="course-grid course-style-4 bg-white" style="padding: 30px 30px 10px 30px;">
                            <div class="course-header">
                                <div class="">
                                    <img src="<?= $item->IMAGE_EBOOK ?>" alt="" class="" style="width: 100%; height: 300px; object-fit: cover;">
                                </div>
                            </div>

                            <div class="course-content">
                                <h3 class="course-title mb-0"> <a href="<?= url('ebooks/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->JUDUL))) . '?id_book=' . $item->ID_BUKU ?>"><?= $item->JUDUL ?> </a> </h3>
                                <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important;
                                        text-overflow: ellipsis !important;
                                        display: -webkit-box !important;
                                        -webkit-line-clamp: 2 !important;
                                        -webkit-box-orient: vertical !important;">
                                    <?= $item->PRICE == 0 ? "FREE" : 'Rp ' . number_format($item->PRICE, 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <hr>
        <div class="px-3 d-grid d-md-flex text-center justify-content-md-between justify-content-center align-items-center">
            <div class="order-1 order-md-2">
                {{ $ebook->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width: 800px !important;">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLongTitle"><?= $ebook[0]->JUDUL ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $ebook[0]->LINK_EBOOK ?>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

</div>

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