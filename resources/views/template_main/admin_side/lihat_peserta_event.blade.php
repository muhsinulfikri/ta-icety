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
            <h3 class="fw-bold" style="color:#45b104">List Peserta Webinar</h3>
        </div>
        <div class="mb-3 mt-3 row headerz" style="">
            <div class="col-md-6 col-sm-12">
                <div class="d-flex">
                    <div class="d-flex flex-column flex-grow-1"><span
                            class="font-weight-bolder font-size-lg text-primary mb-1">{{ $event->TITLE_ACTIVITY }}</span>
                        <span class="text-dark-50 font-weight-normal font-size-sm"></span>
                        <img src="{{ $event->IMAGE_ACTIVITY }}"
                            style="display: block; max-width: 300px; align-content: left;"
                            alt="">
                    </div>
                </div>
            </div>
            <?php
            $date_start_format = new DateTime($event->DATE_START);
            $date_end_format = new DateTime($event->DATE_END);
            
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
                                <td valign="top" class="font-weight-bolder" style="width: 120px;">Tanggal</td>
                                <td valign="top"> : </td>
                                <td valign="top" class="font-weight-boldest">{{ $date_start }} -
                                    {{ $date_end }}
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="font-weight-bolder">Waktu</td>
                                <td valign="top"> : </td>
                                <td valign="top" class="font-weight-boldest">{{ $date_start_time }} WIB -
                                    {{ $date_end_time }} WIB</td>
                            </tr>
                            <tr>
                                <td valign="top" class="font-weight-bolder">Kuota Peserta</td>
                                <td valign="top"> : </td>
                                <td valign="top" class="font-weight-boldest">
                                    <?= empty($event->KUOTA_PESERTA) ? 'Tidak Ada Batasan' : $event->KUOTA_PESERTA . ' Orang' ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="font-weight-bolder">Meeting URL</td>
                                <td valign="top"> : </td>
                                <td valign="top" class="font-weight-boldest"><a href="{{ $event->LINK_ZOOM }}"
                                        target="_blank">{{ $event->LINK_ZOOM }}</a>
                                </td>
                            </tr> <!---->
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <a href="/events" class="btn btn-sm btn-danger">
                    <i class="fas fa-chevron-left"></i> KEMBALI</a>
                <?php if(!empty($list_peserta)) { ?>
                <button id="exportButton"
                    onclick="location.href='/courses/laporan_course?ID_ACTIVITY=<?= $kursus->ID_ACTIVITY ?>'"
                    class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Report</button>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- Content Wrapper END -->

{{-- Start Modal Add --}}
<div class="modal" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Event</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="image_activity" accept=".jpg, .png" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Judul <span class="text-danger">*</span></label>
                        <input placeholder="Title" type="text" name="title_activity" class="form-control"
                            required>
                    </div>
                    <!-- <div class="form-group mb-3">
                        <label>Harga <span class="text-danger">*</span></label>
                        <input type="number" class="form-control CurrencyInput" name="price_activity">
                        <div class="col-md-5">
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Gratis
                            </span>
                        </div>
                    </div> -->
                    <div class="form-group mb-3">
                        <label>Tanggal Mulai<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="date_start" required
                            placeholder="Date Start">
                    </div>
                    <div class="form-group mb-3">
                        <label>Tanggal Selesai<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="date_end" required
                            placeholder="Date End">
                    </div>
                    <div class="form-group mb-3">
                        <label>Kode Sertifikat <span class="text-danger">*</span></label>
                        <input placeholder="Kosongi apabila tidak ada sertifikat" type="text" name="sertif_code"
                            class="form-control">
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
                        <label>Kontak Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="+62 83342457452" type="text" name="contact" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="Penyelenggara" type="text" name="penyelenggara" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kuota Peserta <span class="text-danger"></span></label>
                        <input placeholder="Kosongi apabila tidak ada batasan" type="number" name="kuota_peserta"
                            class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Lokasi <span class="text-danger">*</span></label>
                        <input placeholder="Location" type="text" name="location" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Link Zoom </label>
                        <input placeholder="zoom.com/" type="text" name="link_zoom" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="is_aktif">Status Aktif</label>
                        <span class="d-flex align-items-center mt-2">
                            Tidak Aktif
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" checked id="is_aktif" name="status">
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
                    <button type="submit" class="btn btn-primary rounded waves-effect waves-light"
                        id="confirmButton">
                        <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                            Loading</span>
                        <span class="main-btn">Konfirmasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update --}}
<div class="modal" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Event</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="hidden">
                        <input type="hidden" name="up_id_activity" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Kover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="up_image_activity" accept=".jpg, .png"
                                data-max-file-size="1M" data-allowed-file-extensions="jpg png"
                                class="custom-file-input dropify">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Judul <span class="text-danger">*</span></label>
                        <input placeholder="Title" type="text" name="up_title_activity" class="form-control"
                            required>
                    </div>
                    <!-- <div class="form-group mb-3">
                        <label>Harga <span class="text-danger">*</span></label>
                        <input type="number" class="form-control up_CurrencyInput" name="up_price_activity">
                        <div class="col-md-5">
                            <span class="d-flex align-items-center gap-2 mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="up_setFree">
                                    <label for="up_setFree"></label>
                                </div>
                                Gratis
                            </span>
                        </div>
                    </div> -->
                    <div class="form-group mb-3">
                        <label>Tanggal Mulai<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="up_date_start"
                            placeholder="Date Start">
                    </div>
                    <div class="form-group mb-3">
                        <label>Tanggal Selesai<span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="up_date_end"
                            placeholder="Date Start">
                    </div>
                    <div class="form-group mb-3">
                        <label>Kode Sertifikat <span class="text-danger">*</span></label>
                        <input placeholder="Kosongi bila tidak ada sertifikat" type="text" name="up_sertif_code"
                            class="form-control">
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
                        <label>Kontak Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="+62 83342457452" type="text" name="up_contact" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="Penyelenggara" type="text" name="up_penyelenggara"
                            class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kuota Peserta <span class="text-danger">*</span></label>
                        <input placeholder="Kosongi Apabila Tidak ada batasan peserta" type="number"
                            name="up_kuota_peserta" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Lokasi <span class="text-danger">*</span></label>
                        <input placeholder="Location" type="text" name="up_location" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Link Zoom </label>
                        <input placeholder="zoom.com/" type="text" name="up_link_zoom" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="up_status">Status Aktif</label>
                        <span class="d-flex align-items-center mt-2">
                            Tidak Aktif
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" name="up_status" id="up_status">
                                <label for="up_status"></label>
                            </div>
                            Aktif
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi Event</label>
                        <textarea name="up_desc_event" id="up_desc_event"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded waves-effect waves-light"
                        id="confirmButton">
                        <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                            Loading</span>
                        <span class="main-btn">Konfirmasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete --}}
<div class="modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus Event</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
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
                    <button type="submit" class="btn btn-primary">Hapus</button>
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
        var img_sc = data.IMAGE_ACTIVITY;

        // Load Image
        var cover_book = $('input[name="up_image_activity"]').dropify();
        cover_book = cover_book.data('dropify');
        cover_book.resetPreview();
        cover_book.clearElement();
        cover_book.settings['defaultFile'] = img_sc;
        cover_book.destroy();
        cover_book.init();

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

        $('#up_status').prop('checked', data.STATUS == 1 ? true : false);
        $('input[name="up_date_start"]').val(data.DATE_START)
        $('input[name="up_date_end"]').val(data.DATE_END)
        $('input[name="up_sertif_code"]').val(data.SERTIF_CODE)
        $('select[name="up_category"]').val(cat).change()
        $('input[name="up_contact"]').val(data.CONTACT_CUSTOMER)
        $('input[name="up_penyelenggara"]').val(data.ORGANIZER)
        $('input[name="up_kuota_peserta"]').val(data.KUOTA_PESERTA)
        $('input[name="up_location"]').val(data.LOCATION)
        $('input[name="up_link_zoom"]').val(data.LINK_ZOOM)
        $.ajax({
            url: 'events/get/' + data.ID_ACTIVITY,
            method: 'GET',
            dataType: 'JSON',

            success: function(response) {
                // make with summernote
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

    function laporan(id) {
        $.ajax({
            url: '/events/laporan_event?ID_ACTIVITY=' + id,
            method: 'GET',
            success: function(response) {
                window.location.href = '/events/laporan/' + id;
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
