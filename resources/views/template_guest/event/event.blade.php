<section class="py-5 py-md-7" style="background-color: #B90C0B;">
    <div class="container">
        <h1 class="font text-center" style="color: white !important">EVENTS</h1>
        <!-- <div class="justify-content-center mt-3 d-flex">
            <a href="/" class="font" style="color: white !important;text-decoration: underline;text-decoration-color: white;">Home</a>
            <div class="ms-2 me-1" style="border-left: 2px solid white;height: 27px">&nbsp;</div>
            <div class="font" style="color: white !important;">Events</div>
        </div> -->
    </div>
</section>

<section class="section-padding page">
    <div class="course-top-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                </div>
                <div class="col-lg-4">
                    <div class="topbar-search ">
                        <input type="text" placeholder="Search our Events" class="form-control search"
                            id="search-form">
                        <label><i class="fa fa-search"></i></label>
                    </div>
                    <div class="dropdown mt-2">
                        <div id="search-result"
                            class="col-12 dropdown-menu rounded-2 custom-scrollbar-js dropdown-primary"
                            style="min-height: 512px; overflow-y:scroll;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container-fluid container-padding">
            <div class="row course-gallery justify-content-center">
                <div class="tab-content" id="nav-tabContent">
                    <div class="row justify-content-center">
                        <?php if (!empty($events)) { ?>
                        <div class="row mt-md-4" style="margin-left: 0px !important; margin-right: 0px !important;">
                            <?php foreach ($events as $item) : ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="px-0 px-sm-3">
                                    <div class="course-grid course-style-4 bg-white px-1 px-md-4 mt-4 pb-2">
                                        <div class="course-header" style="margin-top: 10px">
                                            <div class style="width: 100%; height: 100%;  overflow:hidden;">
                                                <a
                                                    href="<?= url('event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY ?>">
                                                    <img src="<?= $item->IMAGE_ACTIVITY ?>" alt="image"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="course-content">
                                            <div>
                                                <span
                                                    class="course-price <?= $item->PRICE_ACTIVITY == 0 ? 'bg-success' : 'bg-primary' ?>"
                                                    style="<?= $item->EXPIRED == 1 ? 'right: 135px;' : '' ?>">
                                                    <?= !empty(session('user')) && $item->DATA_CHECKING != 0 ? 'PARTICIPATED' : ($item->PRICE_ACTIVITY == 0 ? 'FREE' : 'PAID') ?>
                                                </span>
                                                <?php if ($item->EXPIRED == 1) : ?>
                                                <span class="course-price" style="right: 10px;">EXPIRED</span>
                                                <?php endif; ?>
                                            </div>
                                            <h3 class="course-title mb-0"> <a
                                                href="<?= url('event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY ?>"><?= $item->TITLE_ACTIVITY ?>
                                            </a> </h3>
                                    </div>

                                    <div class="course-meta mb-3">
                                        <div class="text-muted m-0 pt-2 fs-6"
                                            style="overflow: hidden !important;
                                                        text-overflow: ellipsis !important;
                                                        display: -webkit-box !important;
                                                        -webkit-line-clamp: 2 !important;
                                                        -webkit-box-orient: vertical !important;">
                                            <?= date_format(date_create($item->DATE_START), 'j F Y') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php } else { ?>
                            <h3 class="font-sm text-center">No Event available</h3>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div
                    class="px-3 d-grid d-md-flex text-center justify-content-md-between justify-content-center align-items-center">
                    <div class="order-2 order-md-1 pt-3 pt-md-0">
                        <span class="fs-8 pagination-text">Showing {{ $events->currentPage() }} of
                            {{ $events->lastPage() }} Page</span>
                    </div>
                    <div class="order-1 order-md-2">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    document.onkeydown = (e) => {
        if (e.key == 123) {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'I') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'C') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'J') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.key == 'U') {
            e.preventDefault();
        }
    };

    $(document).on('click', function(event) {
        var clickedElement = $(event.target);
        var element = $('#search-result');
        if (!clickedElement.is(element) && !clickedElement.closest(element).length) {
            $('#search-result').hide()
        }
    });

    $('#search-form').keyup(function(e) {
        if (e.which == 13) {
            $('#search-result').html("");
            getData($(this).val())
        }
    });

    function getData(key) {
        $.ajax({
            url: 'event/search',
            method: 'GET',
            data: {
                keyword: key
            },
            success: function(result) {
                if (result != "") {
                    $('#search-result').append(result)
                } else {
                    $('#search-result').append(" <a class='dropdown-item'>No matching records found</a>")
                }

                // show results if not empty
                if ($('#search-result').html() != "") {
                    $('#search-result').show();
                }
            }
        });
    }
</script>
