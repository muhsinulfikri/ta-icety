@extends('template_guest.profile.profile_template')
@section('content')
<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h3 class="fw-bold" style="color:#AD0B0B">My Courses</h3>
        <button type="button" class="btn btn-primary rounded-4 fw-semibold" onclick="openModalRedeem()">
            Use Trial Code
        </button>
    </div>
    <table class="table" style="color: #8A8A8E">
        <thead>
            <tr class="fw-normal text-black">
                <td scope="col" class="fw-semibold fs-5" width="60%">Courses</td>
                <td scope="col" class="fw-semibold fs-5" width="20%">Category</td>
                <td scope="col" class="fw-semibold fs-5" width="20%">Status</td>
            </tr>
        </thead>
        <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
            <?php foreach ($course as $item) : ?>
                <tr onclick="window.location = '<?= url('course/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) ?>'" style="cursor:pointer">
                    <td class="py-3">
                        <div class="d-flex align-items-center">
                            <img src="<?= $item->IMAGE_ACTIVITY ?>" class="d-block img-fluid rounded-2" style="width: 80px; height: 80px; object-fit: cover">
                            <span class="ms-2"><?= $item->TITLE_ACTIVITY ?></span>
                        </div>
                    </td>
                    <td class="py-3"><?= $item->KATEGORI ?></td>
                    <td class="py-3">
                        <?php if ($item->PROGRESS == 100) { ?>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Done</span>
                        <?php } else { ?>
                            <?= ceil($item->PROGRESS) ?>%
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    if (empty($course)) {
        echo "<div class='text-center fs-4 fw-semibold h-75 d-flex align-items-center justify-content-center'>No Course Available</div>";
    }
    ?>
</div>

<div class="modal fade" id="redeemModal" tabindex="-1" aria-labelledby="redeemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="redeemModalLabel">Enter The Trial Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-redeem" action="" method="post">
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="trial_code" id="trial_code" required>
                    <div class="alert-code"></div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="useTrialVoucher()">Apply Code</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModalRedeem() {
        $('#redeemModal').modal('show')
    }

    function useTrialVoucher() {
        var isValid = true;
        var form = $('#form-redeem');
        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            isValid = false;
            return false;
        }

        if (isValid) {
            $.ajax({
                url: `<?= url('voucher/trial-code') ?>`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                data: form.serialize(),
                beforeSend: function() {
                    Swal.fire({
                        title: "Getting Course...",
                        html: "Please wait, the system is get the course...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response, status, xhr) {
                    if (response.status) {
                        showAlertModal('Success', response.msg, 'success')
                    } else {
                        showAlertModal('Error', response.msg, 'error')
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                    showAlertModal('Error', xhr.responseText, 'error')
                }
            });
        }
    }

    function showAlertModal(title, msg, icon) {
        Swal.close();
        if (icon == 'success') {
            Swal.fire({
                title: title,
                text: msg,
                icon: icon,
                confirmButtonText: '<i class="fas fa-sync-alt"></i> Refresh',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                    Swal.fire({
                        title: "Refreshing",
                        html: "Please wait, the page is still refresing...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        } else {
            $('.alert-code').html(`
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="far fa-exclamation-triangle text-danger me-3" style="-webkit-text-stroke: 0.1px;"></i>
                    <span>${msg}</span>
                </div>
            `)
        }
    }
</script>
@endsection