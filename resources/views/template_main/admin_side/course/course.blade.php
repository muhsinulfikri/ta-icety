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
                    <label class="card-title" style="font-size: 20px">Course</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <a data-toggle="modal" data-target="#modalAddCourse" style="color: white"><button type="button" class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i>
                            Add Course</button></a>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Course</th>
                            <th>Status</th>
                            <th>Status Private</th>
                            <th>Tipe</th>
                            <th width="15%">Course Price</th>
                            <th>Date Start</th>
                            <th>Date End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($activity as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td width="300"><?= $item->TITLE_ACTIVITY ?></td>
                                <td><?= $item->IS_DELETED !== null ? '<span class="badge badge-danger">Deleted</span>' : ($item->STATUS == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-success">Active</span>')?> </td>
                                <td><?= $item->IS_PUBLIC == 1 ? '<span class="badge badge-success">Public</span>' : '<span class="badge badge-danger">Private</span>' ?></td>
                                <td><?= $item->TYPE_ACTIVITY == 3 ? '<span class="badge badge-danger">Final Exam</span>' : '<span class="badge badge-success">Kursus Biasa</span>' ?></td>
                                <td><?= $item->PRICE_ACTIVITY == 0 ? '<span class="badge badge-success">Free</span>' : 'Rp ' . number_format($item->PRICE_ACTIVITY, 0, '.', '.') ?>
                                </td>
                                <td><?= date_format(date_create($item->DATE_START), 'j F Y H:i:s') ?></td>
                                <td><?= date_format(date_create($item->DATE_END), 'j F Y H:i:s') ?></td>
                                <td>
                                    <button type="button" onclick="location.href='courses/lihat_peserta?ID_ACTIVITY={{$item->ID_ACTIVITY}}'" class="btn btn-warning mb-1 btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 160px !important;">
                                        <i class="bx bxs-user-detail font-size-16 align-middle"></i> See Participant
                                    </button>
                                    <form action="courses/invite" method="GET">
                                        <input type="hidden" name="id_activity" value="<?= $item->ID_ACTIVITY ?>">
                                        <button type="submit" class="btn btn-primary btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important;">
                                            <i class="bx bx-send font-size-16 align-middle"></i> Invite User
                                        </button>
                                    </form>
                                    @php
                                        $link = $item->TYPE_ACTIVITY == 3 ? 'courses/add-final/edit' : 'courses/edit';
                                    @endphp
                                    <form action="{{$link}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_activity" value="<?= $item->ID_ACTIVITY ?>">
                                        <button type="submit" class="btn btn-dark btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important; margin: 5px 0px;">
                                            <i class="bx bx-edit-alt font-size-16 align-middle"></i> Edit Course
                                        </button>
                                    </form>
                                    @if ($item->TYPE_ACTIVITY == 1)
                                        <button type="button" onclick="opencopyModal('<?= $item->ID_ACTIVITY ?>')" class="btn btn-primary btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important; margin: 5px 0px;">
                                            <i class="bx bx-copy font-size-16 align-middle"></i> Copy Course
                                        </button>
                                    @endif
                                    <button type="button" onclick="opendeleteModal('<?= $item->ID_ACTIVITY ?>')" class="btn btn-danger btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important;">
                                        <i class="bx bx-trash font-size-16 align-middle"></i> Delete Course
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

{{-- Start Modal copy --}}
<div class="modal" id="copyModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Copy Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Title<span class="text-danger">*</span></label>
                        <input placeholder="Title" type="text" name="title_copy" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Alias<span class="text-danger">*</span></label>
                        <input placeholder="Alias" type="text" name="alias_copy" class="form-control" pattern="[A-Z\s]+" title="Only uppercase letters are allowed"
                        oninput="this.value = this.value.toUpperCase()" required>
                        <small id="alias-feedback"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal copy --}}

{{-- Start Modal Delete --}}
<div class="modal fade" id="deleteModal" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="courses/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <p>Do you want to delete this Course ?</p>
                        <input type="hidden" name="id_activity" value="" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}

{{-- Start Modal Add Course --}}
<div class="modal fade" style="z-index: 1060;" id="modalAddCourse" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Course Or Final Exam ?</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 text-center d-flex justify-content-around">
                    <a href="{{ url("courses/add")}}"
                        class="btn btn-success col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-book text-white"></i></h1> COURSE
                    </a>
                    <a href="{{ url("courses/add-final")}}" id="add_quiz"
                        class="btn btn-danger col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-trophy text-white"></i></h1> FINAL EXAM
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Add Course --}}

<script>
    $('#dtTable').DataTable()

    function opencopyModal(idActivity) {
        let form = document.getElementById('form-user');
        form.action = `courses/copy/${idActivity}`;
        $('#copyModal').modal('show')
    }

    function opendeleteModal(Data) {
        $('input[name="id_activity"]').val(Data)
        $('#deleteModal').modal('show')
    }
    $(document).ready(function () {
        $('input[name="alias_copy"]').on('input', function () {
            let alias = $(this).val();

            if (alias.length > 0) {
                $.ajax({
                    url: '/check-alias',
                    type: 'GET',
                    data: { alias: alias },
                    success: function (response) {
                        if (response.exists) {
                            $('#alias-feedback').text('Alias sudah digunakan, silahkan pilih yang lain!').css('color', 'red');
                        } else {
                            $('#alias-feedback').text('Alias tersedia').css('color', 'green');
                        }
                    }
                });
            } else {
                $('#alias-feedback').text('');
            }
        });
    });
</script>
