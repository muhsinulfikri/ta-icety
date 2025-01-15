<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?> - TBH Academy</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= asset('assets/images/logo_colored.svg') ?>">
    <!-- Select2 css -->
    <link href="<?= asset('assets_admin/vendors/select2/select2.css') ?>" rel="stylesheet">
    <!-- DatePicker css -->
    <link href="<?= asset('assets_admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
    <!-- page css -->
    <link href="<?= asset('assets_admin/vendors/datatables/dataTables.bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Dropify css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <!-- Core css -->
    <link href="<?= asset('assets_admin/css/app.min.css') ?>" rel="stylesheet">
    <!-- Icon css -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">


    <!-- Core Vendors JS -->
    <script src="<?= asset('assets_admin/js/vendors.min.js') ?>"></script>
    <!-- Select2 JS -->
    <script src="<?= asset('assets_admin/vendors/select2/select2.min.js') ?>"></script>
    <!-- Dropify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <!-- DatePicker JS -->
    <script src="<?= asset('assets_admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Validate JS -->
    <script src="<?= asset('assets_admin/vendors/jquery-validation/jquery.validate.min.js') ?>"></script>
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- Core JS -->
    <script src="<?= asset('assets_admin/js/app.min.js') ?>"></script>
    <!-- Vendor Chart -->
    <script src="<?= asset('assets_admin/vendors/chartjs/Chart.min.js') ?>"></script>
    <!-- Dashboard JS -->
    <script src="<?= asset('assets_admin/js/pages/dashboard-default.js') ?>"></script>
    <!-- DataTable JS -->
    <script src="<?= asset('assets_admin/vendors/datatables/jquery.dataTables.min.js') ?>"></script>
    <!-- Core Bootstrap JS -->
    <script src="<?= asset('assets_admin/vendors/datatables/dataTables.bootstrap.min.js') ?>"></script>
    <!-- Sweet Alert -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js">
    </script>

</head>

<body>
    {{-- <?= $this->session->flashdata('msg_auth') ?> --}}
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark logo logo-dark">
                    <a href="<?php url('/'); ?>" class="d-flex justify-content-center mt-3">
                        <img src="<?= asset('icety_assets/logo-dark.svg') ?>" alt="Logo">
                        <img class="logo-fold justify-content-center w-50"
                            src="<?= asset('icety_assets/logo.svg') ?>" alt="Logo">
                    </a>
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                        <li class="desktop-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li class="mobile-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    <img src="<?= !empty(session('user')[0]['FOTO_PROFIL']) ? session('user')[0]['FOTO_PROFIL'] : asset('assets_admin/images/avatars/thumb-3.jpg') ?>"
                                        alt="">
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="avatar avatar-lg avatar-image">
                                            <img src="<?= !empty(session('user')[0]['FOTO_PROFIL']) ? session('user')[0]['FOTO_PROFIL'] : asset('assets_admin/images/avatars/thumb-3.jpg') ?>"
                                                alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold">
                                                <?= session('user')[0]['NAME'] ?></p>
                                            <p class="m-b-0 opacity-07">
                                                <?= (session('user')[0]['ID_ROLE'] == 1 ? 'Admin' : 'Instructor' ) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= url('') ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-laptop"></i>
                                            <span class="m-l-10">Home</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                                <a href="<?= url('logout') ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            <span class="m-l-10">Logout</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Header END -->
