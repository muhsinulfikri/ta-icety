<!-- Content Wrapper START -->
<style>
    .disabled-btn {
        background-color: #6c757d !important;
        /* Gray background */
        border-color: #6c757d !important;
        /* Matching border */
        color: #fff !important;
        /* White text color */
        cursor: not-allowed;
        /* Shows that the button is disabled */
        opacity: 1 !important;
        /* Make sure the button isn't faded */
        box-shadow: none !important;
        /* Remove any default box-shadow */
    }

    .disabled-btn:disabled {
        opacity: 1 !important;
        /* Ensure button opacity is set to 1 */
        pointer-events: none;
        /* Prevent any interaction with the button */
    }
</style>

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

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <label class="card-title" style="font-size: 20px">Users</label>
                </div>
            </div>
            <div class="m-t-25">
                <form id="invitation-form" action="invite_batch" method="POST">
                    @csrf
                    <input type="hidden" name="id_act" value="<?= $activity->ID_ACTIVITY ?>">
                    <input type="hidden" name="selected_users" id="selected-users">
                    <div class="table-responsive">
                        <table class="table mb-0" id="dtTable">
                            <button id="send_invitation" onClick="batch_invitation()"
                                style="position:absolute;right: 0;margin-right: 18px;z-index: 99999;"
                                class="btn btn-primary">Kirim Undangan</button>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>No Telpon</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Action</th>
                                    <th><input type="checkbox" id="check-all"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>

                                @foreach ($users as $item)
                                    <?php $number++; ?>
                                    <tr>
                                        <td><?= $number ?></td>
                                        <td><?= $item->NAME ?></td>
                                        <td><?= $item->EMAIL ?></td>
                                        <td><?= $item->TELP ?></td>
                                        <td><?= $item->JK ?></td>
                                        <td>
                                            @if ($item->is_invited)
                                                <button type="button" class="btn btn-secondary disabled-btn" disabled>
                                                    <i class="bx bx-send font-size-16 align-middle"></i> Sudah Diundang
                                                </button>
                                            @else
                                                <button type="button" id="send_cfl_individu<?= $item->ID_USER ?>"
                                                    onclick="opensendModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                                    class="btn btn-primary waves-effect waves-light">
                                                    <i
                                                        class="bx bx-send font-size-16 align-middle send_cfl_individu<?= $item->ID_USER ?>"></i>
                                                    Kirim Undangan
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->is_invited)
                                            @else
                                                <input class="dt-checkbox" type="checkbox" value="<?= $item->ID_USER ?>"
                                                    name="id_user[]" id="check-all">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->

{{-- Start Modal Invite --}}
<div class="modal" id="sendModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Undang User ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add" action="invite_individu" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <p>Undang user ke kursus "{{ $activity->TITLE_ACTIVITY }}"</p>
                        <input type="hidden" name="id_user">
                        <input type="hidden" name="id_activity" value="<?= $activity->ID_ACTIVITY ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-send font-size-16 align-middle"></i> Undang User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Invite --}}

<script>
    $('#dtTable').DataTable();

    function opensendModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="id_user"]').val(data.ID_USER)
        $('#sendModal').modal('show')
    }

    $('#check-all').on('click', function(e) {
        e.stopPropagation()
        $('.dt-checkbox').prop('checked', this.checked);
    });

    function batch_invitation() {
        var selectedUsers = $('.dt-checkbox:checked').map(function() {
            return $(this).val();
        }).get().join(',');

        $('#selected-users').val(selectedUsers);
        $('#invitation-form').submit();
    }
</script>
