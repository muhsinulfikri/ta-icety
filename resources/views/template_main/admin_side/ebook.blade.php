<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title"><?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('Dashboard') ?>" class="breadcrumb-item"><i
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
                    <label class="card-title" style="font-size: 20px">E-book</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" onclick="addModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Add E-book</button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Price</th>
                            <th>Genre</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($book as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->JUDUL ?></td>
                                <td><?= $item->PRICE == 0 ? '<span class="badge badge-success">Free</span>' : $item->PRICE ?>
                                </td>
                                <td><?= $item->GENRE ?></td>
                                <td><?= $item->AUTHOR ?></td>
                                <td><?= $item->TAHUN ?></td>
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

{{-- Start Modal Add --}}
<div class="modal" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Ebook</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="ebook/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Cover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="image_ebook" accept=".jpg, .png, .jpeg" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input placeholder="Judul" type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea placeholder="Desc" type="text" name="desc" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price <span class="text-danger">*</span></label>
                        <input placeholder="10000" type="text" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Genre <span class="text-danger">*</span></label>
                        <input placeholder="Genre" type="text" name="genre" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Author <span class="text-danger">*</span></label>
                        <input placeholder="Author" type="text" name="author" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>publication Year <span class="text-danger">*</span></label>
                        <input placeholder="20xx" type="number" name="tahun" class="form-control" required>
                    </div>
                    <span class="text-danger">* Select pdf or link for ebook</span>
                    <div class="form-group mb-3">
                        <div class="col-md-5">
                            <div class="form-check">
                                <input type="radio" class="form-check-input ebook-option"
                                    id="optionFile"
                                    value="file"
                                    name="ebook_option">
                                <label class="form-check-label" for="optionFile">Upload File</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input ebook-option"
                                    id="optionLink"
                                    value="link"
                                    name="ebook_option">
                                <label class="form-check-label" for="optionLink">Enter Link</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3" id="fileInputGroup" hidden>
                        <label class="col-form-label control-label">File Ebook</label>
                            <div class="custom-file">
                                <input id="ebook_file"
                                    type="file"
                                    name="ebook_file"
                                    data-allowed-file-extensions="pdf"
                                    accept=".pdf"
                                    data-max-file-size="10M"
                                    class="custom-file-input dropify file_ebook">
                            </div>
                    </div>
                    <div class="form-group mb-3" id="linkInputGroup" hidden>
                        <label class="col-form-label control-label" required>Link Ebook</label>
                            <input id="ebook_link"
                                type="text"
                                class="form-control"
                                name="ebook_link">
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label>Ebook File <span class="text-danger">*</span></label>
                        <input type="file" name="ebook" class="custom-file-input dropify"
                            data-allowed-file-extensions="pdf" accept=".pdf" data-max-file-size="10M" data-default-file="">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update --}}
<div class="modal" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">E-book Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="ebook/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Cover</label>
                        <div class="custom-file">
                            <input type="file" name="up_image_ebook" accept=".jpg, .png, .jpeg"
                                data-max-file-size="1M" data-allowed-file-extensions="jpg png"
                                class="custom-file-input dropify">
                            <input type="hidden" name="up_id_buku" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title</label>
                        <input placeholder="Judul" type="text" name="up_judul" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea placeholder="Desc" type="text" name="up_desc" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price</label>
                        <input placeholder="10000" type="text" name="up_harga" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Genre</label>
                        <input placeholder="Genre" type="up_text" name="up_genre" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Author</label>
                        <input placeholder="Author" type="text" name="up_author" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Publication Year</label>
                        <input placeholder="20xx" type="number" name="up_tahun" class="form-control"
                            required>
                    </div>
                    <div class="col mb-3">
                        <label>Ebook</label>
                        <div class="custom-file show-file">
                            {{-- <object width="100%" name="up_ebook" height="512" data="" type="application/pdf"></object> --}}
                            <iframe width="100%" name="up_ebook" height="512" style="border: 5px #3d3d3d solid;"
                                seamless="yes" allowfullscreen="yes" frameborder="0"></iframe>
                        </div>
                        <div class="hidden" style="display: none;">
                            <input type="file" name="frame_ebook" id="frame_ebook" class="custom-file-input dropify"
                                data-allowed-file-extensions="pdf" data-max-file-size="10M" data-default-file="">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button type="button" class="btn btn-secondary" id="ganti">Change Ebook</button>
                        <button type="button" class="btn btn-danger" id="cancel">Cancel</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete --}}
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
            <form id="form-user" action="ebook/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Do you want to delete this e-book ?</p>
                    <input type="hidden" name="del_id_ebook" value="" readonly>
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

    $('#cancel').hide();

    $('#ganti').click(function(e) {
        $(this).hide();
        $('#cancel').show();
        $('.show-file').hide();
        $('.hidden').show();
    });

    $('#cancel').click(function(e) {
        $(this).hide();
        $('#ganti').show();
        $('.show-file').show();
        $('.hidden').hide();
    });

    $(document).ready(function() {
        var $editor = $('#desc');
        $editor.summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
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

    function addModal() {
        $('#addModal').modal('show')
    }

    $(document).ready(function () {
    // Pastikan setiap kali modal dibuka, event listener aktif
        $('#addModal').on('shown.bs.modal', function () {
            $('.ebook-option').on('change', function () {
                let selectedOption = $(this).val();

                // Sembunyikan semua input dulu
                $('#fileInputGroup, #linkInputGroup').attr('hidden', true);
                $('#ebook_file, #ebook_link').val('');

                // Tampilkan input yang dipilih
                if (selectedOption === 'file') {
                    $('#fileInputGroup').removeAttr('hidden').css('display', 'block');
                } else if (selectedOption === 'link') {
                    console.log('link');
                    $('#linkInputGroup').removeAttr('hidden').css('display', 'block');
                }
            });
        });
    });


    document.getElementById("frame_ebook").removeAttribute("src");

    function openviewModal(viewData) {
        var data = JSON.parse(viewData);
        var url_book = data.LINK_EBOOK + '#toolbar=0&navpanes=0';
        var test = data.IMAGE_EBOOK;

        $(document).ready(function() {
        var $editor = $('#up_desc');
        $editor.summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
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

        // Load Image
        var cover_book = $('input[name="up_image_ebook"]').dropify();
        cover_book = cover_book.data('dropify');
        cover_book.resetPreview();
        cover_book.clearElement();
        cover_book.settings['defaultFile'] = test;
        cover_book.destroy();
        cover_book.init();

        var ebook = $('input[name="frame_ebook"]').dropify();
        ebook = ebook.data('dropify');
        ebook.resetPreview();
        ebook.clearElement();
        ebook.settings['defaultFile'] = url_book;
        ebook.destroy();
        ebook.init();

        $('input[name="up_id_buku"]').val(data.ID_BUKU)
        $('input[name="up_judul"]').val(data.JUDUL)
        $('input[name="up_desc"]').val(data.DESC)
        $('input[name="up_harga"]').val(data.PRICE)
        $('input[name="up_genre"]').val(data.GENRE)
        $('input[name="up_author"]').val(data.AUTHOR)
        $('input[name="up_tahun"]').val(data.TAHUN)
        $('iframe[name="up_ebook"]').attr('src', url_book)
        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)

        $('input[name="del_id_ebook"]').val(data.ID_BUKU)
        $('#deleteModal').modal('show')
    }

    $('.dropify').dropify({
        messages: {
            default: 'Drag atau drop untuk memilih file',
            replace: 'Ganti',
            remove: 'Hapus',
            error: 'error'
        }
    });
</script>
