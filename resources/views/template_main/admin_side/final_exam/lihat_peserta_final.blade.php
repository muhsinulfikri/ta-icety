<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title"><?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('dashboard') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Home</a>
                <span class="breadcrumb-item active"><?= $title ?></span>
            </nav>
        </div>
    </div>
    <?php if (!empty(session('err_msg'))) { ?>
    <div class="alert alert-danger">
        <div class="d-flex align-items-center justify-content-start">
            <span class="alert-icon">
                <i class="anticon anticon-check-o"></i>
            </span>
            <span><?= session('err_msg') ?></span>
        </div>
    </div>
    <?php } ?>
    <?php if (!empty(session('succ_msg'))) { ?>
    <div class="alert alert-success">
        <div class="d-flex align-items-center justify-content-start">
            <span class="alert-icon">
                <i class="anticon anticon-check-o"></i>
            </span>
            <span><?= session('succ_msg') ?></span>
        </div>
    </div>
    <?php } ?>
    <div class="card-body">
        <div class="col-md-6 align-self-center">
            <h3 class="fw-bold" style="color:#45b104">Final Exam Participant List</h3>
        </div>
        <div class="mb-3 mt-3 row headerz" style="">
            <div class="col-md-6 col-sm-12">
                <div class="d-flex">
                    <div class="d-flex flex-column flex-grow-1"><span
                            class="font-weight-bolder font-size-lg text-primary mb-1">{{ $exam->TITLE_ACTIVITY }}</span>
                        <span class="text-dark-50 font-weight-normal font-size-sm"></span>
                        <img src="{{ $exam->IMAGE_ACTIVITY }}"
                            style="display: block; max-width: 300px; align-content: left;" alt="">
                    </div>
                </div>
            </div>
            <?php
            $date_start_format = new DateTime($exam->DATE_START);
            $date_end_format = new DateTime($exam->DATE_END);

            $date_start = $date_start_format->format('d M Y');
            $date_end = $date_end_format->format('d M Y');

            $date_start_time = $date_start_format->format('H.i');
            $date_end_time = $date_end_format->format('H.i');
            ?>
            <div class="col-md-6 col-sm-12">
                <div class="d-flex align-items-center">
                    <div class="d-flex flex-column flex-grow-1">
                        <br>
                        <br>
                        <span class="font-weight-bolder font-size-lg text-primary mb-1">Online</span>
                        <table>
                            <tr>
                                <td valign="top" class="font-weight-bolder" style="width: 120px;">Date</td>
                                <td valign="top"> : </td>
                                <td valign="top" class="font-weight-boldest">{{ $date_start }} -
                                    {{ $date_end }}</td>
                            </tr>
                            <tr>
                                <td valign="top" class="font-weight-bolder">Time</td>
                                <td valign="top"> : </td>
                                <td valign="top" class="font-weight-boldest">{{ $date_start_time }} WIB -
                                    {{ $date_end_time }} WIB</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <a href="/courses" class="btn btn-sm btn-danger">
                    <i class="fas fa-chevron-left"></i> KEMBALI</a>
                <?php if(!empty($list_peserta)) { ?>
                {{-- <button id="exportButton"
                    onclick="location.href='/courses/laporan_course?ID_ACTIVITY=<?= $exam->ID_ACTIVITY ?>'"
                    class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Report</button> --}}
                <?php } ?>
            </div>
        </div>
        <div class="mt-5">
            <table class="table mb-0" id="dtTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 500px;">Nama Peserta</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Status Final Exam</th>
                        <th>Nilai Tertinggi Final Exam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $number = 0; ?>

                    @foreach ($list_peserta as $item)
                        <?php $number++; ?>
                        <tr>
                            <td><?= $number ?></td>
                            <td><?= $item->NAME ?></td>
                            <td><?= $item->EMAIL ?></td>
                            <td><?= $item->TELP ?></td>
                            <td><?= $item->ALAMAT ?></td>
                            <td><?= $item->STATUS_FINAL_EXAM ?></td>
                            <td><?= $item->NILAI_TERTINGGI_FINAL_EXAM ?? 'Belum Mengerjakan' ?></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->

<script>
    $('#dtTable').DataTable();
</script>
