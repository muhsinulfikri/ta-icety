<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="py-5 py-md-7" style="background-color: #B90C0B;">
    <div class="container">
        <h1 class="font text-center" style="color: white !important">COURSES</h1>
        <div class="justify-content-center mt-3 d-flex">
            <a href="/" class="font" style="color: white !important;text-decoration: underline;text-decoration-color: white;">Home</a>
            <div class="ms-2 me-1" style="border-left: 2px solid white;height: 27px">&nbsp;</div>
            <div class="font" style="color: white !important;">Courses</div>
        </div>
    </div>
</section>
<section class="section-padding page">
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
