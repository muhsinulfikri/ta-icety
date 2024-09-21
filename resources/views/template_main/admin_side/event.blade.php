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
                    <label class="card-title" style="font-size: 20px">Event</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" onclick="openModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Add Event</button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 500px;">Nama Event</th>
                            <th>Status</th>
                            <th>Event Price</th>
                            <th>Date Start</th>
                            <th>Date End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($event as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->TITLE_ACTIVITY ?></td>
                                <td><?= $item->STATUS == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Not Active</span>' ?>
                                </td>
                                <td><?= $item->PRICE_ACTIVITY == 0 ? '<span class="badge badge-success">Free</span>' : $item->PRICE_ACTIVITY ?>
                                </td>
                                <td><?= date_format(date_create($item->DATE_START), 'j F Y H:i:s') ?></td>
                                <td><?= date_format(date_create($item->DATE_END), 'j F Y H:i:s') ?></td>
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        <button type="button"
                                            onclick="location.href='events/lihat_peserta?ID_ACTIVITY={{ $item->ID_ACTIVITY }}'"
                                            class="btn btn-primary px-4 py-2 rounded">
                                            <i class="bx bxs-user-detail font-size-16 align-middle"></i>
                                        </button>
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
                                    </div>
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

{{-- Start Modal Add --}}
<div class="modal" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="image_activity" accept=".jpg, .png" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input placeholder="Title" type="text" name="title_activity" class="form-control" required>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Price <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control CurrencyInput" name="price_activity" placeholder="0"
                            required>
                        <div class="col-md-5">
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Free
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Date Start<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="date_start" required
                            placeholder="Date Start">
                    </div>
                    <div class="form-group mb-3">
                        <label>Date End<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="date_end" required
                            placeholder="Date End">
                    </div>
                    <div class="form-group">
                        <label>Cover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                        <input type="file" name="sertif_image" class="custom-file-input dropify"
                                    accept=".jpg" data-allowed-file-extensions="jpg" required>
                            <small class="text-danger">* Input JPG only file</small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Certificate Code <span class="text-danger">*</span></label>
                        <input placeholder="Certificate Code" type="text" name="sertif_code" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select class="form-control select-category" name="category" id="cars"
                            onchange="zoomLinkCheck(this)" required>
                            <option value="0">Hybrid</option>
                            <option value="1">Online</option>
                            <option value="2">Offline</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Contact Person <span class="text-danger">*</span></label>
                        <input placeholder="+62 83342457452" type="text" name="contact" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="Penyelenggara" type="text" name="penyelenggara" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Location <span class="text-danger">*</span></label>
                        <input placeholder="Location" type="text" name="location" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Link Zoom </label>
                        <input placeholder="zoom.com/" type="text" name="link_zoom" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="is_aktif">Status Aktif</label>
                        <span class="d-flex align-items-center mt-2">
                            Tidak Aktif
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" id="is_aktif" name="status">
                                <label for="is_aktif"></label>
                            </div>
                            Aktif
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi Event</label>
                        <textarea name="desc_event" id="desc_event"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="confirmButton">
                        <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                            Loading</span>
                        <span class="main-btn">Confirm</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update --}}
<div class="modal" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="up_id_activity" class="form-control"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>Cover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="up_image_activity" accept=".jpg, .png"
                                data-max-file-size="1M" data-allowed-file-extensions="jpg png"
                                class="custom-file-input dropify">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input placeholder="Title" type="text" name="up_title_activity" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control up_CurrencyInput" name="up_price_activity">
                        <div class="col-md-5">
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="up_setFree">
                                    <label for="up_setFree"></label>
                                </div>
                                Free
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Date Start<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="up_date_start"
                            placeholder="Date Start">
                    </div>
                    <div class="form-group mb-3">
                        <label>Date End<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="up_date_end"
                            placeholder="Date Start">
                    </div>
                    <div class="form-group">
                        <label>Cover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                        <input type="file" name="up_sertif_image" class="custom-file-input dropify"
                                    accept=".jpg" data-allowed-file-extensions="jpg">
                        <small class="text-danger">* Input JPG only file</small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Certificate Code <span class="text-danger">*</span></label>
                        <input placeholder="Certificate Code" type="text" name="up_sertif_code"
                            class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select class="form-control select-category" name="up_category" id="up_category"
                            onchange="zoomLinkCheck(this)" required>
                            <option value="0">Hybrid</option>
                            <option value="1">Online</option>
                            <option value="2">Offline</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Contact Person <span class="text-danger">*</span></label>
                        <input placeholder="+62 83342457452" type="text" name="up_contact" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="Penyelenggara" type="text" name="up_penyelenggara"
                            class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Location <span class="text-danger">*</span></label>
                        <input placeholder="Location" type="text" name="up_location" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Link Zoom </label>
                        <input placeholder="zoom.com/" type="text" name="up_link_zoom" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="up_status">Status Active</label>
                        <span class="d-flex align-items-center mt-2">
                            Not Active
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" name="up_status" id="up_status">
                                <label for="up_status"></label>
                            </div>
                            Active
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description Event</label>
                        <textarea name="up_desc_event" id="up_desc_event"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="confirmButton">
                        <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                            Loading</span>
                        <span class="main-btn">Confirm</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete --}}
<div class="modal" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Apakah Anda Ingin Menghapus Event ini ?</label>
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="id_activity" class="form-control" readonly>
                    </div>
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
    $('#dtTable').DataTable();

    $(document).ready(function() {
        var $editor = $('#desc_event');
        $editor.summernote({
            height: 200,
            callbacks: {
                onPaste: function(e) {
                    console.log('Called event paste', e);
                },
                onImageUpload: function(files) {
                    console.log(files);
                    $summernote.summernote('insertNode', imgNode);
                }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
                ['operation', ['undo', 'redo']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['object', ['link']]
            ]
        });
        $('#insert-btn').click(() => {
            $editor.summernote('insertParagraph');
        });
        $('#bold-btn').click(() => {
            $editor.summernote('bold');
        });
    });
    $(document).ready(function() {
        var $editor = $('#up_desc_event');
        $editor.summernote({
            height: 200,
            callbacks: {
                onPaste: function(e) {
                    console.log('Called event paste', e);
                },
                onImageUpload: function(files) {
                    console.log(files);
                    $summernote.summernote('insertNode', imgNode);
                }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
                ['operation', ['undo', 'redo']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['object', ['link']]
            ]
        });
        $('#insert-btn').click(() => {
            $editor.summernote('insertParagraph');
        });
        $('#bold-btn').click(() => {
            $editor.summernote('bold');
        });
    });

    $('.loader').hide();
    $('.main-btn').show();

    $('.modal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })

    function openModal() {
        $('#addModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)
        var price = data.PRICE_ACTIVITY
        var cat = data.CATEGORY_EVENT

        function initializeDropify(inputName, fileUrl) {
            var dropifyElement = $('input[name="' + inputName + '"]').dropify();
            var instance = dropifyElement.data('dropify');
            instance.resetPreview();
            instance.clearElement();
            instance.settings['defaultFile'] = fileUrl;
            instance.destroy();
            instance.init();
        }
        initializeDropify('up_image_activity', data.IMAGE_ACTIVITY);
        initializeDropify('up_sertif_image', data.SERTIF_IMAGE);

        $('input[name="up_id_activity"]').val(data.ID_ACTIVITY)
        $('input[name="up_title_activity"]').val(data.TITLE_ACTIVITY)
        if (price == 0) {
            $('#up_setFree').prop('checked', true);
            $('.up_CurrencyInput').prop('readonly', true)
            $('input[name="up_price_activity"]').val(price)
        } else {
            $('#up_setFree').prop('checked', false);
            $('.up_CurrencyInput').prop('readonly', false)
            $('input[name="up_price_activity"]').val(price)
        }
        $('input[name="up_date_start"]').val(data.DATE_START)
        $('input[name="up_date_end"]').val(data.DATE_END)
        $('input[name="up_sertif_code"]').val(data.SERTIF_CODE)
        $('select[name="up_category"]').val(cat).change()
        $('input[name="up_contact"]').val(data.CONTACT_CUSTOMER)
        $('input[name="up_penyelenggara"]').val(data.ORGANIZER)
        $('input[name="up_location"]').val(data.LOCATION)
        $('input[name="up_link_zoom"]').val(data.LINK_ZOOM)
        $('#up_status').prop('checked', data.STATUS == 1 ? true : false);
        $.ajax({
            url: 'events/get/' + data.ID_ACTIVITY,
            method: 'GET',
            dataType: 'JSON',

            success: function(response) {
                $('#up_desc_event').summernote('code', response[0].event.DESKRIPSI_EVENT);
            },
            error: function(xhr, status, error) {}
        });
        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="id_activity"]').val(data.ID_ACTIVITY)
        $('#deleteModal').modal('show')
    }

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('')
        }
    })

    $('#up_setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.up_CurrencyInput').prop('readonly', true)
            $('.up_CurrencyInput').val(0)
        } else {
            $('.up_CurrencyInput').prop('readonly', false)
            $('.up_CurrencyInput').val('')
        }
    })

    function zoomLinkCheck(e) {
        if ($(e).val() == 2) {
            $('input[name="link_zoom"]').prop('disabled', true);
            $('input:text[name="link_zoom"]').val('')
            $('input[name="up_link_zoom"]').prop('disabled', true);
            $('input:text[name="up_link_zoom"]').val('')
            $('input[name="location"]').prop('disabled', false).prop('required', true);
            $('input[name="up_location"]').prop('disabled', false).prop('required', true);
        } else if ($(e).val() == 1) {
            $('input[name="location"]').prop('disabled', true);
            $('input:text[name="location"]').val('')
            $('input[name="up_location"]').prop('disabled', true);
            $('input:text[name="up_location"]').val('')
            $('input[name="link_zoom"]').prop('disabled', false).prop('required', true);
            $('input[name="up_link_zoom"]').prop('disabled', false).prop('required', true);
        } else {
            $('input[name="link_zoom"]').prop('disabled', false);
            $('input[name="up_link_zoom"]').prop('disabled', false);
            $('input[name="link_zoom"]').prop('disabled', false).prop('required', true);
            $('input[name="up_link_zoom"]').prop('disabled', false).prop('required', true);
            $('input[name="location"]').prop('disabled', false).prop('required', true);
            $('input[name="up_location"]').prop('disabled', false).prop('required', true);
        }
    }

    $('.dropify').dropify({
        messages: {
            default: 'Drag atau drop untuk memilih file',
            replace: 'Ganti',
            remove: 'Hapus',
            error: 'error'
        }
    });
    $(document).ready(function() {});
</script>
