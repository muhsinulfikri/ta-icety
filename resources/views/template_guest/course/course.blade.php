{{-- <style>
    #page-content {
        padding-top: 40px;
        background: #f8f9fa; /* Background abu-abu muda seperti di gambar */
        min-height: 100vh;
    }

    /* Search Bar Wrapper */
    .search-container {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .topbar-search {
        position: relative;
        width: 300px;
    }

    .topbar-search input {
        border-radius: 25px;
        padding-right: 40px;
        border: 1px solid #ddd;
    }

    .topbar-search i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
    }

    /* Filter Nav Styling */
    .filter-wrap {
        margin-bottom: 30px;
    }

    .course-filter {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
    }

    .course-filter li a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        font-size: 16px;
        padding-bottom: 5px;
        transition: 0.3s;
    }

    .course-filter li.active a {
        color: #AD0A0B;
        border-bottom: 3px solid #AD0A0B; /* Garis bawah merah */
    }

    /* Banner Store Merah */
    .store-banner {
        background-color: #AD0A0B;
        color: white;
        padding: 15px 30px;
        border-radius: 5px;
        margin-bottom: 30px;
    }

    .store-banner h1 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    /* Card Content */
    .content-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        padding: 60px 20px;
        text-align: center;
    }
</style> --}}
{{-- <style>
.course-grid {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,.08);
}
.course-header img {
    width: 100%;
    height: 300px;
    object-fit: cover;
}
.course-price {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 6px 12px;
    color: #fff;
    border-radius: 20px;
    font-size: 13px;
}
</style> --}}

<main id="page-content">
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="py-5 py-md-7" style="background-color: #AD0A0B;">
    <div class="container">
        <h1 class="font text-center" style="color: white !important">STORE</h1>
        <!-- <div class="justify-content-center mt-3 d-flex">
            <a href="/" class="font" style="color: white !important;text-decoration: underline;text-decoration-color: white;">Home</a>
            <div class="ms-2 me-1" style="border-left: 2px solid white;height: 27px">&nbsp;</div>
            <div class="font" style="color: white !important;">Courses</div>
        </div> -->
    </div>
</section>
<section class="section-padding course-page">
    <div class="course-top-wrap mb-50">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                </div>
                <div class="col-lg-4">
                    <div class="topbar-search ">
                        <input type="text" placeholder="Search our courses" class="form-control search" id="search-form">
                        <label><i class="fa fa-search"></i></label>
                    </div>
                    <div class="dropdown mt-2">
                        <div id="search-result" class="col-12 dropdown-menu rounded-2 custom-scrollbar-js dropdown-primary" style="min-height: 512px; overflow-y:scroll;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="filter-wrap text-center">
            <ul class="course-filter ">
                <li><a href="#" data-value="0" id="nav-all" onclick="ChangeNav(this, event)">All</a></li>
                <?php foreach ($kategori as $item_kategori) : ?>
                    <li><a href="#" data-value="<?= $item_kategori->ID_KATEGORI ?>" id="nav-<?= $item_kategori->ID_KATEGORI ?>" onclick="ChangeNav(this, event)"><?= $item_kategori->KATEGORI ?></a></li>
                <?php endforeach;
                if ($is_invited != null && !empty(session('user'))) { ?>
                    <li><a href="#" data-value="999" id="nav-invited" onclick="ChangeNav(this, event)">Invited</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="container-fluid container-padding">
            <div class="row course-gallery justify-content-center">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active show" id="nav-content" role="tabpanel" aria-labelledby="nav-content-tab" tabindex="0">
                        <div class="row justify-content-center" id="nav-content-item">
                            <h3 class="font-sm text-center">No course available</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--course-->
</section>
</main>
<script src="{{ asset('assets_landing')}}/vendor/jquery/jquery.min.js"></script>
<script src="{{ asset('assets_landing')}}/vendor/bootstrap/js/bootstrap.min.js"></script>
<script>
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
            url: "course/search",
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

                if ($('#search-result').html() != "") {
                    $('#search-result').show();
                }
            }
        });
    }

    $("#nav-all").trigger('click')

    function ChangeNav(element, event) {
        event.preventDefault()
        $("#nav-all").parent().removeClass("active")
        <?php foreach ($kategori as $item_kategori) : ?>
            $("#nav-<?= $item_kategori->ID_KATEGORI ?>").parent().removeClass("active")
        <?php endforeach; ?>
        $(element).parent().addClass("active")
        GetCourse($(element).data('value'))
    }

    function GetCourse(category) {
        $('#nav-content-item').html(`<div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
            <div class=" rounded-5 p-3 pb-4 h-auto d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" />
                </div>
            </div>
        </div>`);

        // Retrieve CSRF token from meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Set up AJAX request with CSRF token included in headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            url: "course/category",
            method: 'POST',
            data: {
                category: category
            },
            success: function(result) {
                $('#nav-content-item').html();
                $('#nav-content-item').html(result);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
