<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="page-wrapper">
    <div class="tutori-course-content">
        <div class="container">
            <div class="row pt-3">
                <div class="col-lg-5">
                    <!-- event Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0">
                        <div class="">
                            <div class="course-thumbnail d-flex justify-content-center">
                                <div class="pe-0 pe-sm-5 rounded-1">
                                    <img src="<?= $detail->IMAGE_EBOOK ?>" class="d-block img-fluid h-auto ">
                                </div>
                            </div>

                            <div class="container">
                                @if ($checking_data->DATA_CHECKING != 1)
                                    <div class="price-header mb-3">
                                        <h2 class="course-price">
                                            <?= $detail->PRICE == 0 ? 'Free' : 'Rp ' . number_format($detail->PRICE, 2, ',', '.') ?>
                                        </h2>
                                    </div>

                                    <form class="" id="FormBuyNow-info" method="POST"
                                        action="<?= url('purchase') ?>">
                                        @csrf
                                        <div id="data-input-info"></div>
                                        <div class="w-100 button button-enroll-course btn btn-main-2 rounded"
                                            onclick="BuyNow()"><?= $detail->PRICE == 0 ? 'Add Item' : 'Buy Now' ?>
                                        </div>
                                    </form>
                                    <button data-id-ebook="<?= $detail->ID_BUKU ?>" onclick="AddToCart(this)"
                                        class="mt-2 w-100 button button-enroll-course btn btn-secondary btn-sm rounded">
                                        Add to Cart
                                    </button>
                                @else
                                    <a
                                        href="{{ url('ebooks/view/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $detail->JUDUL))) . '?id_book=' . $detail->ID_BUKU }}"><button
                                            class="mt-2 w-100 button button-enroll-course btn btn-secondary btn-sm rounded">See
                                            Item
                                        </button></a>
                                @endif
                                <!-- <php endif ?> -->
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
        </div>

        <div class="container pt-4">
            <hr class="mt-4" />

            <div class="course-latest">
                <h4 class="mb-4">Buku Lainnya</h4>
                <div class="row course-gallery ">
                    <?php foreach ($other_ebook as $item) : ?>
                    <div class="course-item cat1 cat5 col-lg-6 col-md-6">
                        <div class="px-0 px-sm-3">
                            <div class="single-course style-2 bg-shade border-0">
                                <div class="row g-0 align-items-center">
                                    <div class="col-xl-5">
                                        <div class="course-thumb"
                                            style="min-height: 150px !important;background:url(<?= str_replace(' ', '%20', $item->IMAGE_EBOOK) ?>)">
                                        </div>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="course-content">
                                            <h3 class="course-title"> <a
                                                    href="{{ url('ebooks/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->JUDUL))) . '?id_book=' . $item->ID_BUKU }}"><?= $item->JUDUL ?>
                                                </a> </h3>
                                            <div class="course-price">
                                                <?= $item->PRICE == 0 ? 'FREE' : 'Rp ' . number_format($item->PRICE, 0, ',', '.') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                id_activity: $(e).data("id-ebook"),
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
                id_activity: '<?= $detail->ID_BUKU ?>',
                type: 3
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);

                let timerInterval
                $('#data-input-info').append('<input type="hidden" name="id_order_purchase[0]" value="' +
                    data.IdOrder + '" />')
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
    // <php if (!empty(session('user')) && $event->DATA_CHECKING <> 0) { ?>


    // function filename(path) {
    //     path = path.substring(path.lastIndexOf("/") + 1);
    //     return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
    // }
    // <php } ?>
</script>
