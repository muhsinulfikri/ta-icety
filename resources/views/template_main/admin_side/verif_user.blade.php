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
                    <label class="card-title" style="font-size: 20px">Verification Account</label>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 1; ?>
                        <?php foreach($user as $item) : ?>
                            <tr>
                                {{-- @dd($item->NAME) --}}
                                <td> {{ $number++ }} </td>
                                <td>{{ $item->NAME  }}</td>
                                <td>{{  $item->EMAIL }}</td>
                                <td>
                                    <button type="button" class="btn btn-subtle-danger waves-effect waves-light update-status-btn"
                                        data-id="{{ $item->ID_USER }}" data-bs-toggle="modal" data-bs-target="#updateStatusModal" onclick="openModal(`<?= htmlentities(json_encode($item)) ?>`)">
                                        <i class="bx bx-send font-size-16 align-middle"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->
<!-- Modal -->
<div class="modal" id="verifModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verification Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="verif-account-admin" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Do you want to Verification this account ?</p>
                    <input type="hidden" name="id_user" value="" readonly>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#dtTable').DataTable();

    function openModal(viewData) {
        viewData = viewData.replace(/[\r\n]+/g, ' ').replace(/\\'/g, "'");
        var data = JSON.parse(viewData)
        $('input[name="id_user"]').val(data.ID_USER)
        $('#verifModal').modal('show')
    }

</script>