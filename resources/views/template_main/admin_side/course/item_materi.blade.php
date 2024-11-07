<div class="card" id="materi_item_{{ $no }}">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12">
                <span class="col-md-11">Detail - Materi</span>
                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}" required>
                <input type="hidden" class="form-control" name="type[]" value="1" required>
                <div id="delete_materi_{{ $no }}" class="btn btn-danger px-1 py-0 float-right"
                    style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
                </div>
            </a>
        </h5>
    </div>
    <div id="collapse{{ $no }}" class="collapse show" data-parent="#accordion-default">
        <div class="card-body">
            <span class="text-danger">* Select pdf or link for materi</span>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Select Option</label>
                <div class="col-md-5">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="optionFile" name="materi_option" onclick="toggleInput('file')">
                        <label class="form-check-label" for="optionFile">Upload File</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="optionLink" name="materi_option" onclick="toggleInput('link')">
                        <label class="form-check-label" for="optionLink">Enter Link</label>
                    </div>
                </div>
            </div>
            <div class="form-group row" id="fileInputGroup" hidden>
                <label class="col-sm-2 col-form-label control-label">File Materi</label>
                <div class="col-md-5">
                    <div class="custom-file">
                        <input id="materi_file" type="file" name="materi_file[]" accept=".pdf, .ppt, .pptx" class="custom-file-input file_materi" >
                    </div>
                </div>
            </div>
            <div class="form-group row" id="linkInputGroup" hidden>
                <label class="col-sm-2 col-form-label control-label" required>Link Materi</label>
                <div class="col-md-5">
                    <input id="materi_link" type="text" class="form-control" name="materi_link[]" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label" required>Nama Materi</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="materi_title[]" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Link Youtube</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="materi_link_yt[]" required>
                    <span class="text-danger">* Upload link video in google drive and submit the link in this field.
                        Example link must contain d/your_id_video like this
                        https://drive.google.com/file/d/1fTx7Ij-ora0xIFAWU0Gz4Ej8kJZh1tgs/view?usp=sharing</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Deskripsi Materi</label>
                <div class="col-md-5">
                    <textarea name="desc_materi[]" id="mytextarea_{{ $no }}" required></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $('#form-submit').on('submit', function(e) {
            var fileInput = $('.file_materi')[0];
            var files = fileInput.files;
            var allowedExtensions = /(\.pdf|\.ppt|\.pptx)$/i;

            for (var i = 0; i < files.length; i++) {
                if (!allowedExtensions.exec(files[i].name)) {
                    alert('Invalid file type. Only PDF, PPT, and PPTX files are allowed.');
                    fileInput.value = '';
                    e.preventDefault();
                    return;
                }
            }
        });
    });

    function toggleInput(type) {
        const fileInputGroup = document.getElementById('fileInputGroup');
        const linkInputGroup = document.getElementById('linkInputGroup');
        const fileInputArea = $('#materi_file').dropify();
        const linkInput = document.getElementById('materi_link');

        if (type === 'file') {
            fileInputGroup.hidden = false;
            linkInputGroup.hidden = true;
            fileInputArea[0].disabled = false;
            linkInput.disabled = true;
            //reset input
            linkInput.value = '';
            fileInputArea.data('dropify').clearElement();
        } else if (type === 'link') {
            linkInputGroup.hidden = false;
            fileInputGroup.hidden = true;
            fileInputArea[0].disabled = true;
            linkInput.disabled = false;
            //reset input
            fileInput.data('dropify').clearElement();
        }
    }

    $(document).ready(function() {
        var $editor = $('#mytextarea_{{ $no }}');
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
        $('.file_materi').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    });

    $('#collapse{{ $no }}').collapse('hide')

    $('#delete_materi_{{ $no }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_materi_{{ $no }}").removeClass("is-loading")
        $("#materi_item_{{ $no }}").remove();
        i--;
        e.preventDefault();
    });
</script>
