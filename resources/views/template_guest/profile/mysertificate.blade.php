@extends('template_guest.profile.profile_template')
@section('content')
<div class="col ms-0 ms-md-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4">My Certificate</h3>
    <div class="table-responsive">
        <table class="table table-hover" style="color: #8A8A8E">
            <thead>
                <tr class="fw-normal text-black">
                    <td scope="col" class="fw-semibold fs-5" width="60%">Course</td>
                    <td scope="col" class="fw-semibold fs-5" width="20%">Type</td>
                    <td scope="col" class="fw-semibold fs-5" width="20%">Verification</td>
                </tr>
            </thead>
            <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                <?php foreach ($sertif as $item) : ?>
                    <tr  style="cursor:pointer">
                        <td class="py-3" onclick="window.open('<?= url($item->FILE_SERTIFIKAT) ?>', '_blank')">
                            <div class="d-flex align-items-center" style="width: max-content;">
                                <span class="ms-2"><?= $item->TITLE_ACTIVITY ?></span>
                            </div>
                        </td>
                        <td class="py-3" onclick="window.open('<?= url($item->FILE_SERTIFIKAT) ?>', '_blank')">
                            <?= $item->TYPE_ACTIVITY == 2 ? '<span class="badge bg-success">Event</span>' : '<span class="badge bg-danger">Course</span>' ?>
                        </td>
                        <td class="py-3">
                            <a href="/verifikasi/{{ Crypt::encryptString($item->ID_SERTIFIKAT) }}"><button type="button" class="btn btn-primary col-md-12 my-3">Certificate Verification</button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    if (empty($sertif)) {
        echo "<div class='text-center fs-4 fw-semibold h-75 d-flex align-items-center justify-content-center'>There No Downloaded Sertificate</div>";
    }
    ?>
</div>

<script>
</script>
@endsection
