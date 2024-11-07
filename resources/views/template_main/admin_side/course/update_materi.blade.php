<div class="card" id="materi_item_{{ $no }}">
    <div class="card-header">
        <h5 class="card-title d-flex row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12">
                <span class="col-md-11">Detail - Materi <?= $item['TITLE'] ?></span>
                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}" required>
                <input type="hidden" class="form-control" name="type[]" value="1" required>
                <input type="hidden" name="default_file[]" value="<?= $item['FILE'] ?>">
                <input type="hidden" name="ID_ITEM[]" value="<?= $item['ID_ITEM'] ?>">
                <div id="delete_materi_{{ $no }}" class="btn btn-danger px-1 py-0 float-right d-flex align-items-center" style="cursor: pointer;">
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
                        <input type="radio" class="form-check-input" id="optionFile" name="materi_option[]" value="file" onclick="toggleInput('file')" >
                        <label class="form-check-label" for="optionFile">Upload File</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="optionLink" name="materi_option[]" value="link" onclick="toggleInput('link')" >
                        <label class="form-check-label" for="optionLink">Enter Link</label>
                    </div>
                </div>
            </div>
            <div class="form-group row" id="fileInputGroup">
                <label class="col-sm-2 col-form-label control-label">Chapter File</label>
                <div class="col-md-5">
                    <div class="custom-file">
                        <input type="file" name="materi_file[]" accept=".pdf, .ppt, .pptx" id="materi_file<?=$no?>"
                            class="custom-file-input file_materi" value="{{ $item['FILE'] }}">
                    </div>
                </div>
            </div>
            <div class="form-group row" id="linkInputGroup">
                <label class="col-sm-2 col-form-label control-label" required>Link Materi</label>
                <div class="col-md-5">
                    <input id="materi_link" type="text" class="form-control" name="materi_link[]"
                    value="{{ $item['LINK_MATERI'] }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label" required>Chapter Name</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="materi_title[]" value="<?= $item['TITLE'] ?>"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Youtube Link</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="materi_link_yt[]" value="<?= $item['LINK_YT'] ?>"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Chapter Description</label>
                <div class="col-md-5">
                    <textarea name="desc_materi[]" id="mytextarea_<?= $no ?>" required>
                    {{ $item['DESKRIPSI'] }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('input[name="materi_file[]"]').each(function() {
        var dropifyInstance = $(this).data('dropify');

        if ($(this).attr('type') === 'hidden') {
            if (dropifyInstance) {
                dropifyInstance.destroy();
            }
        } else if ($(this).attr('id') === 'file-upload') {
            if (dropifyInstance) {
                dropifyInstance.destroy();
            }
        } else {
            var dropifyElement = $("#materi_file<?=$no?>").dropify();
            dropifyInstance = dropifyElement.data('dropify');
            dropifyInstance.resetPreview();
            dropifyInstance.clearElement();
            dropifyInstance.settings.defaultFile = "{{ $item['FILE'] }}";
            dropifyInstance.destroy();
            dropifyInstance.init();
        }
    });

    function toggleInput(type) {
        const fileInputGroup = document.getElementById('fileInputGroup');
        const linkInputGroup = document.getElementById('linkInputGroup');

        if (type === 'file') {
            fileInputGroup.hidden = false;
            linkInputGroup.hidden = true;
        } else if (type === 'link') {
            linkInputGroup.hidden = false;
            fileInputGroup.hidden = true;
        } else {
            linkInputGroup.hidden = true;
            fileInputGroup.hidden = true;
        }
    }

    $(document).ready(function() {
        var $editor = $('#mytextarea_{{ $no }}');
        $editor.summernote({
            height: 200,
            callbacks: {
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
                default: 'Drag or Drop to Change Image',
                replace: 'Change',
                remove: 'Delete',
                error: 'Error'
            }
        });
    });

    $('#collapse<?= $no ?>').collapse('hide')

    $('#delete_materi_{{ $no }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_materi_{{ $no }}").removeClass("is-loading")
        $("#materi_item_{{ $no }}").remove();
        item--;
        e.preventDefault();
    });
</script>
