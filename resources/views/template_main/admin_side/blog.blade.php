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
                    <label class="card-title" style="font-size: 20px">Blog</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" onclick="addModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Add Blog</button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Gambar</th>
                            <th>Isi Konten</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($blog as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->TITLE_BLOG ?></td>
                                <td><img src="<?= $item->IMAGE_BLOG ?>" alt="" style="width: 100px; height: 80px"></td>
                                <!-- membatasi text yang show agar tidak terlalu panjang -->
                                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                    title="<?= htmlspecialchars($item->TEXT_BLOG, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= substr($item->TEXT_BLOG, 0, 100) . (strlen($item->TEXT_BLOG) > 100 ? '...' : '') ?>
                                </td>
                                <td><?= $item->CATEGORY_BLOG ?></td>
                                <td><?= $item->DATE_UPLOAD ?></td>
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
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="blogs/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Gambar Blog <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="image_blog" accept=".jpg, .png, .jpeg" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input placeholder="Judul" type="text" name="title_blog" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Isi Konten</label>
                        <textarea placeholder="Isi konten" type="text" name="text_blog" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <input placeholder="Kategori" type="text" name="category_blog" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Tanggal Upload <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="date_upload" class="form-control" required>
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

{{-- Start Modal Update --}}
<div class="modal" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Blog Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="blogs/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="up_id_blog" value="" readonly>
                    <div class="form-group mb-3">
                        <label>Gambar Blog <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="up_image_blog" accept=".jpg, .png, .jpeg" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input placeholder="Judul" type="text" name="up_title_blog" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Isi Konten</label>
                        <textarea placeholder="Isi konten" type="text" id="up_text_blog" name="up_text_blog" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <input placeholder="kategori" type="text" name="up_category_blog" class="form-control" required>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
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
            <form id="form-user" action="blogs/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Do you want to delete this blog ?</p>
                    <input type="hidden" name="del_id_blog" value="" readonly>
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

    function openviewModal(viewData) {
        viewData = viewData.replace(/[\r\n]+/g, ' ').replace(/\\'/g, "'");
        var data = JSON.parse(viewData);


        $(document).ready(function() {
        var $editor = $('#up_text_blog');
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
        var image_blog = $('input[name="up_image_blog"]').dropify();
        image_blog = image_blog.data('dropify');
        image_blog.resetPreview();
        image_blog.clearElement();
        image_blog.settings['defaultFile'] = data.IMAGE_BLOG;
        image_blog.destroy();
        image_blog.init();

        $('input[name="up_id_blog"]').val(data.ID_BLOG)
        $('input[name="up_title_blog"]').val(data.TITLE_BLOG)
        // $('input[name="up_text_blog"]').val(data.TEXT_BLOG)
        $('#up_text_blog').summernote('code', data.TEXT_BLOG);
        $('input[name="up_category_blog"]').val(data.CATEGORY_BLOG)
        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        viewData = viewData.replace(/[\r\n]+/g, ' ').replace(/\\'/g, "'");
        var data = JSON.parse(viewData)
        $('input[name="del_id_blog"]').val(data.ID_BLOG)
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
