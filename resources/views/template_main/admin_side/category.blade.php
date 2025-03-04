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
    <!-- Content Wrapper END -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <label class="card-title" style="font-size: 20px">Category</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" onclick="openaddModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Add Category</button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 60%;">Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($category as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->KATEGORI ?></td>
                                <td>
                                    <button type="button"
                                        onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-primary waves-effect waves-light">
                                        <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button"
                                        onclick="opendeleteModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-danger waves-effect waves-light">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->

{{-- Start Modal Add blom --}}
<div class="modal" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="category/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Kategori<span class="text-danger">*</span></label>
                        <input placeholder="Kategori" type="text" name="kategori" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update blom --}}
<div class="modal" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="category/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="up_id_kategori" value="" readonly>
                    <label>Kategori<span class="text-danger">*</span></label>
                    <input placeholder="Kategori" type="text" name="up_kategori" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete blom --}}
<div class="modal" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="category/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Do you want to delete this category ?</p>
                    <input type="hidden" name="del_id_kategori" value="" readonly>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}

<script>
    $('#dtTable').DataTable()

    function openaddModal() {
        $('#addModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="up_kategori"]').val(data.KATEGORI)
        $('input[name="up_id_kategori"]').val(data.ID_KATEGORI)
        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="del_id_kategori"]').val(data.ID_KATEGORI)
        $('#deleteModal').modal('show')
    }
</script>
