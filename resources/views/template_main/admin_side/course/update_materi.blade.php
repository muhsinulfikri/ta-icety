<div class="card" id="materi_item_{{ $no }}">
    <div class="card-header">
        <h5 class="card-title d-flex row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12 collapsed" aria-expanded="false">
                <span class="col-md-11">Detail - Materi <?= $item['TITLE'] ?></span>
                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}" required>
                <input type="hidden" class="form-control" name="type[]" value="1" required>
                <input type="hidden" name="DELETED[]" value="0">
                <input type="hidden" name="ID_ITEM[]" value="<?= $item['ID_ITEM'] ?>">
                <input type="hidden" id="id_course_{{ $item['ID_ITEM'] }}" value="{{ $item['ID_COURSE'] ?? '' }}">
                {{-- <div id="delete_materi_{{ $no }}" class="btn btn-danger px-1 py-0 float-right d-flex align-items-center" style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
                </div> --}}
            </a>
        </h5>
    </div>
    <div id="collapse{{ $no }}" class="collapse show" data-parent="#accordion-default" aria-expanded="false" style="height: 0px;">
        <div class="card-body">
            <?php
            $hasFile = !empty($item['FILE']);
            $hasLink = !empty($item['LINK_MATERI']);
            ?>
            <input type="hidden" name="default_file[]" value="<?= $item['FILE'] ?? null ?>">
            <div class="form-group row" id="fileInputGroup_{{ $no }}" @if(!$hasFile) style="display: none;" @endif>
                <label class="col-sm-2 col-form-label control-label">Chapter File</label>
                <div class="col-md-10" <?php echo !$hasFile ? 'style="display: none;"' : ''; ?>>
                    <div class="custom-file">
                        <input type="file" name="materi_file" accept=".pdf, .ppt, .pptx" id="materi_file_{{ $item['ID_ITEM'] }}"
                            class="custom-file-input file_materi">
                    </div>
                </div>
            </div>

            <div class="form-group row" id="linkInputGroup_{{ $no }}" <?php echo !$hasLink ? 'style="display: none;"' : ''; ?>>
                <label class="col-sm-2 col-form-label control-label" required>Link Materi</label>
                <div class="col-md-10" <?php echo !$hasLink ? 'style="display: none;"' : ''; ?>>
                    <input id="materi_link_{{ $item['ID_ITEM'] }}" type="<?php echo $hasLink ? 'text' : 'hidden'; ?>" class="form-control" name="materi_link[]"
                    value="{{ $item['LINK_MATERI'] ?? '' }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label" required>Chapter Name</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="materi_title_{{ $item['ID_ITEM'] }}" value="{{ $item['TITLE'] }}"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Youtube Link</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="materi_link_yt_{{ $item['ID_ITEM'] }}" value="{{ $item['LINK_YT'] }}"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Chapter Description</label>
                <div class="col-md-10">
                    <textarea name="desc_materi[]" id="mytextarea_<?= $item['ID_ITEM'] ?>" required>
                    {{ $item['DESKRIPSI'] }}</textarea>
                </div>
            </div>
            <div class="form-group text-right mt-5">
                <button type="button" class="btn btn-primary btn-submit-form" onclick="submitMateriItem(this)" data-id="{{ $item['ID_ITEM'] }}">Simpan Materi</button>
            </div>
        </div>
    </div>
</div>

<script>
    function submitMateriItem(button) {
        let idItem = $(button).data('id');
        let formData = new FormData();

        formData.append('ID_ITEM', idItem);
        formData.append('ID_COURSE', $('#id_course_' + idItem).val());
        formData.append('materi_title', $('#materi_title_' + idItem).val());
        formData.append('materi_link_yt', $('#materi_link_yt_' + idItem).val());
        formData.append('materi_link', $('#materi_link_' + idItem).val());
        formData.append('desc_materi', $('#mytextarea_' + idItem).val());

        let fileInput = $('#materi_file_' + idItem).get(0);
        if (fileInput && fileInput.files.length > 0) {
            formData.append('materi_file', fileInput.files[0]);
        }
        $.ajax({
            url: 'update/item_materi',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function(response) {
                console.log(response);

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.succ_msg,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menyimpan materi.',
                });
                console.log(xhr.responseText);
            }
        });
    }
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
            var dropifyElement = $("#materi_file_{{ $item['ID_ITEM'] }}").dropify();
            dropifyInstance = dropifyElement.data('dropify');
            dropifyInstance.resetPreview();
            dropifyInstance.clearElement();
            dropifyInstance.settings.defaultFile = "{{ $item['FILE'] }}";
            dropifyInstance.destroy();
            dropifyInstance.init();
        }
    });

    $(document).ready(function() {
        var $editor = $("#mytextarea_<?=  $item['ID_ITEM'] ?>");
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
            defaultFile: "{{ $item['FILE'] }}",
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
        // $("#materi_item_{{ $no }}").remove();

        var idItem = $("#materi_item_{{ $no }}").find('input[name="ID_ITEM[]"]').eq(0).val();
        var itemType = $("#materi_item_{{ $no }}").find('input[name="type[]"]').eq(0).val();
        $("#materi_item_{{ $no }}").hide();
        $("#materi_item_{{ $no }}").html(`
                <input type="hidden" name="ID_ITEM[]" value="${idItem}">
                <input type="hidden" name="DELETED[]" value="1">
                <input type="hidden" name="type[]" value="${itemType}">
                <input type="hidden" name="order_list[]" value="">

                <input id="file-upload" type="file" name="materi_file[]" style="display: none;">
                <input type="hidden" name="default_file[]" value="">
                <input type="hidden" name="materi_link[]" value="">
                <input type="hidden" name="materi_title[]" value="">
                <input type="hidden" name="materi_link_yt[]" value="">
                <input type="hidden" name="desc_materi[]" value="">
        `);
        // item--;
        e.preventDefault();
    });
</script>
