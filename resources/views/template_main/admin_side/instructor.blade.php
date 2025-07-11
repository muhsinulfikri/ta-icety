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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <label class="card-title" style="font-size: 20px">Instructor</label>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>University</th>
                            <th>Study</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($instructor as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->NAME ?></td>
                                <td><?= $item->UNIV ?></td>
                                <td><?= $item->DEGREE . ' - ' . $item->STUDY ?></td>
                                <td><span class="badge badge-success">Instructor</span></td>
                                {{-- <td>
                                    <button type="button"
                                        onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-primary waves-effect waves-light">
                                        <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                    </button>
                                </td> --}}
                                <td>
                                    <button type="button"
                                        onclick="deleteModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-primary waves-effect waves-light">
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

{{-- Start Modal view --}}
<div class="modal" id="addviewModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="max-width: 100px !important;">NAME</th>
                                <td name="name"></td>
                            </tr>
                            <tr>
                                <th scope="row">UNIV</th>
                                <td name="univ"></td>
                            </tr>
                            <tr>
                                <th scope="row">NIM</th>
                                <td name="nim"></td>
                            </tr>
                            <tr>
                                <th scope="row">STUDY</th>
                                <td name="study"></td>
                            </tr>
                            <tr>
                                <th scope="row">DEGREE</th>
                                <td name="degree"></td>
                            </tr>
                            <tr class="col-semester">
                                <th scope="row">SEMESTER</th>
                                <td name="semester"></td>
                            </tr>
                            <tr>
                                <th scope="row">GRADUATED</th>
                                <td name="is_graduated"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col">
                        <label>CV Document :</label>
                        <iframe width="100%" height="512" id="cv_doc" style="border: 5px #3d3d3d solid;"
                            src=""></iframe>
                    </div>
                    <div class="col">
                        <label>Certificate Document :</label>
                        <iframe width="100%" height="512" id="cer_doc" style="border: 5px #3d3d3d solid;"
                            src=""></iframe>
                    </div>
                    <div class="w-100" style="margin: 20px 0px;"></div>
                    <div class="col">
                        <label>Portofolio Document :</label>
                        <iframe width="100%" height="512" id="por_doc" style="border: 5px #3d3d3d solid;"
                            src=""></iframe>
                    </div>
                    <div class="col">
                        <label>Recomendation Letter Document :</label>
                        <iframe width="100%" height="512" id="rec_doc" style="border: 5px #3d3d3d solid;"
                            src=""></iframe>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <form id="form-user" action="instructor/decline" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="dec_id_instructor" id="dec_id_instructor"
                            class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-danger btn-reject">Decline</button>
                </form>
                <form id="form-user" action="instructor/accept" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="acc_id_instructor" id="acc_id_instructor"
                            class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-success btn-accept">Accept</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal View --}}

{{-- Start Delete Modal --}}
<div class="modal" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Instructor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="instructor/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Apakah Anda Ingin Menghapus Instructor ini ?</label>
                    <div class="hidden">
                        <input type="hidden" name="id_user" class="form-control" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Delete Modal --}}


<script>
    $('#dtTable').DataTable()

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)
        var id_user = data.ID_USER;

        $('td[name="name"]').html(': ' + data.NAME)
        $('td[name="univ"]').html(': ' + data.UNIV)
        $('td[name="nim"]').html(': ' + data.NIM)
        $('td[name="study"]').html(': ' + data.STUDY)
        $('td[name="degree"]').html(': ' + data.DEGREE)
        $('td[name="semester"]').html(': ' + data.SEMESTER)
        var statusValue = data.STATUS === 1 ? ': ' + '<span class="badge badge-success">Yes</span>' : ': ' +
            '<span class="badge badge-danger">No</span>'
        $('td[name="is_graduated"]').html(statusValue)

        $('#cv_doc').attr('src', data.CV)
        $('#cer_doc').attr('src', data.PORTOFOLIO)
        $('#por_doc').attr('src', data.SERTIFIKAT)
        $('#rec_doc').attr('src', data.SURAT_RECOM)

        $('#acc_id_instructor').val(id_user)
        $('#dec_id_instructor').val(id_user)
        console.log(id_user);
        $('#addviewModal').modal('show')
    }

    function deleteModal(viewData){
        var data = JSON.parse(viewData)
        var id_user = data.ID_USER;
        $('input[name="id_user"]').val(id_user);
        $('#deleteModal').modal('show');
    }
</script>
