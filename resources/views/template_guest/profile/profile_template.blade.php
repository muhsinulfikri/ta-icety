<style>
    .sidebar-profile li a {
        font-size: 16px;
        font-weight: 600;
        color: #222;
        line-height: 1.4;
        text-transform: capitalize;
        font-family: var(--theme-heading-font);
    }

    .sidebar-profile li a:hover {
        color: var(--theme-primary-color);
    }
</style>

<!-- Header -->
<section class="py-5 py-md-7" style="background-color: #B90C0B;">
    <div class="container">
        <h1 class="font text-center" style="color: white !important">PROFILE</h1>
        <div class="justify-content-center mt-3 d-flex">
            <a href="/" class="font" style="color: white !important;text-decoration: underline;text-decoration-color: white;">Home</a>
            <div class="ms-2 me-1" style="border-left: 2px solid white;height: 27px">&nbsp;</div>
            <div class="font" style="color: white !important;">Profile</div>
        </div>
    </div>
</section>



<div class="container px-4 px-md-0 py-4 pb-6 pt-3">

    <div class="container-fluid">
        <div class="row main-content">
            <div class="col-md-3 sidebar order-2 order-md-1 pt-4 pt-md-0">
                <div class="sidebar__inner">
                    <div class="px-0" style="z-index: 0;">
                        <div class="bg-white shadow rounded-2 overflow-hidden" style="height:max-content">
                            <div class="d-flex flex-column align-items-center align-items-sm-start text-white">
                                <ul class="sidebar-profile nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                                    <li class="nav-item w-100 pt-2">
                                        <a href="/profile" class=" {{ request()->is('profile') ? 'active' : '' }}  .  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-user"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">Personal
                                                Data</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>

                                    <!-- INSTRUCTOR SIDEBAR START -->
                                    <!-- if(instructor) -->
                                    <?php if (session('user')[0]['ID_ROLE'] == 2) { ?>
                                        <li class="nav-item w-100">
                                            <a href="/profile/overview" class="{{ request()->is('profile/overview') ? 'active' : '' }}  overview  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-bookmark"></i> <span class="ms-1 ps-2 fs-6 align-self-center">Sale
                                                    Overview</span>
                                            </a>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-book-medical"></i> <span class="ms-1 ps-2 fs-6 align-self-center">Create
                                                    Activity</span>
                                            </a>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                    <?php } ?>
                                    <!-- endif -->
                                    <!-- INSTRUCTOR SIDEBAR END -->

                                    <li class="nav-item w-100">
                                        <a data-bs-toggle="collapse" data-bs-target="#submenu" aria-expanded="true" aria-controls="submenu" class="{{ request()->is('profile/mycourses') ? 'active' : '' }}  nav-link d-flex align-middle px-4 py-3 rounded-0" style="cursor: pointer;">
                                            <i class="fs-6 d-flex align-items-center far fa-book-open"></i>
                                            <span class="ms-1 ps-2 fs-6 align-self-center">My Activities</span>
                                            <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                </path>
                                            </svg>
                                        </a>
                                        <ul class="nav nav-list collapse" id="submenu">
                                            <li class="nav-item w-100">
                                                <a href="/profile/mycourses" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center">My Courses</span>
                                                </a>
                                            </li>
                                            <!-- <li class="w-100">
                                                <hr class="my-0 border border-1 mx-3">
                                            </li>
                                            <li class="nav-item w-100">
                                                <a href="/profile/myevents" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center">My Events</span>
                                                </a>
                                            </li> -->
                                        </ul>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="/profile/myebook" class="{{ request()->is('profile/myebook') ? 'active' : '' }}  nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-book"></i> <span class="ms-1 ps-2 fs-6 align-self-center">My
                                                Ebook</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="/profile/mysertificate" class="{{ request()->is('profile/mysertificate') ? 'active' : '' }}  nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-file-alt"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">ٍMy Sertificate</span>
                                        </a>
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="/profile/myvoucher" class="{{ request()->is('profile/myvoucher') ? 'active' : '' }}  nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-file"></i> <span class="ms-1 ps-2 fs-6 align-self-center">My
                                                Voucher</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="/profile/academic" class="{{ request()->is('profile/academic') ? 'active' : '' }}  nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-file-alt"></i> <span class="ms-1 ps-2 fs-6 align-self-center">Academic
                                                Data</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="/profile/document" class=" {{ request()->is('profile/document') ? 'active' : '' }}  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-building"></i> <span class="ms-1 ps-2 fs-6 align-self-center">Supporting
                                                Documents</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <form class="w-100" action="/forgotPassword" id="forgot" method="POST">
                                        @csrf
                                        <li class="nav-item w-100">
                                            <a href="#" class="nav-link  d-flex align-middle px-4 py-3 rounded-0" onclick="forgot()">
                                                <i class="fs-6 d-flex align-items-center far fa-lock"></i> <span class="ms-1 ps-2 fs-6 align-self-center">Reset
                                                    Password</span>
                                            </a>
                                        </li>
                                    </form>

                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100 pb-3">
                                        <a href="<?= url('logout') ?>" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-arrow-alt-to-left"></i> <span class="ms-1 ps-2 fs-6 align-self-center">Log
                                                out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="bg-white shadow rounded-2 overflow-hidden p-3 mt-3" style="height:max-content">
                            <div class="d-flex flex-column align-items-center align-items-sm-start">
                                <?php
                                $array = (array) $document;
                                $status = true;
                                if (!empty($document)) {
                                    $status = $document->STATUS === 0 ? false : (!empty($document->STATUS) ? false : true);
                                }
                                ?>
                                <?php $totDoc = (!empty($document)) ? count(array_filter($array)) : 0; ?>
                                <?php if (session('user')[0]['ID_ROLE'] == 3 && $status) { ?>
                                    <?php if ($totDoc === 11) { ?>
                                        <div class="col-md-12">
                                            <button type="button" onclick="apply_instructor()" class="btn btn-primary rounded-4 fw-semibold w-100 btn-instructor">Apply as an Instructor</button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <button type="button" class="btn btn-muted rounded-4 fw-semibold w-100 mb-3" disabled>Apply as an Instructor</button>
                                            <span class="text-danger" style="text-align: justify;">* Complete academic data and supporting documents to apply as an instructor at "The Brain & Heart Academy".</span>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if ($document->STATUS == 1) { ?>
                                        <div class="row">
                                            <button type="button" class="btn btn-muted rounded-4 fw-semibold w-100 mb-3" disabled>Apply as an Instructor</button>
                                            <span class="text-success" style="text-align: justify;">You are now part of our instructor team. Thank you for your participation. Make sure you login again to access the instructor menu.</span>
                                        </div>
                                    <?php } else if ($document->STATUS == 2) { ?>
                                        <div class="row">
                                            <button type="button" onclick="apply_instructor()" class="btn btn-primary rounded-4 fw-semibold w-100 mb-3 btn-instructor">Apply as an Instructor</button>
                                            <span class="text-danger" style="text-align: justify;">We are sorry to reject your application because there is a discrepancy between the standard
                                                documents you submitted and our standard documents. Please correct your data again and click the button above to submit again..</span>
                                        </div>
                                    <?php } else if ($document->STATUS == 0) { ?>
                                        <div class="row">
                                            <button type="button" class="btn btn-muted rounded-4 fw-semibold w-100 mb-3" disabled>Apply as an Instructor</button>
                                            <span style="color: #edab00; text-align: justify;">Please be patient as we are still evaluating your personal data and documents.</span>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 content order-1 order-md-2">
                <!-- Page -->
                @yield('content')
            </div>
        </div>
    </div>
</div>
<style>
    .rotate180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>

<script type="text/javascript">
    function forgot() {
        $("#forgot").submit()
    }

    $('button[data-bs-dismiss="modal"]').click(function() {
        $('#tokenInput').val('');
    });

    $(document).ready(function() {
        $('#submenu').on('show.bs.collapse', function() {
            $('.fa-chevron-down').addClass('rotate180');
        });

        $('#submenu').on('hide.bs.collapse', function() {
            $('.fa-chevron-down').removeClass('rotate180');
        });
    });

    var sidebar = new StickySidebar('.sidebar', {
        topSpacing: 20,
        bottomSpacing: 20,
        containerSelector: '.main-content',
        innerWrapperSelector: '.sidebar__inner'
    });

    function apply_instructor() {
        Swal.fire({
            title: '<strong class="h4">Are you sure you want to apply as an intructor ?</strong>',
            showDenyButton: true,
            showCancelButton: false,
            allowOutsideClick: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= url('apply_instructor') ?>';
            }
        })
    }
</script>