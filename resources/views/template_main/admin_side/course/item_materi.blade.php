<div class="card new-materi" id="materi_item_{{ $no }}">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12">
                <span class="col-md-11">Detail - Materi</span>
                <input type="hidden" name="DELETED[]" value="0">
                <input type="hidden" name="ID_ITEM[]" value="">
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
                        <input type="hidden" name="default_file[]" value="">
                        <input type="radio" class="form-check-input materi-option"
                            id="optionFile_{{ $no }}"
                            value="file"
                            name="materi_option_{{ $no }}"
                            data-no="{{ $no }}">
                        <label class="form-check-label" for="optionFile_{{ $no }}">Upload File</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input materi-option"
                            id="optionLink_{{ $no }}"
                            value="link"
                            name="materi_option_{{ $no }}"
                            data-no="{{ $no }}">
                        <label class="form-check-label" for="optionLink_{{ $no }}">Enter Link</label>
                    </div>
                </div>
            </div>
            <div class="form-group row" id="fileInputGroup_{{ $no }}" hidden>
                <label class="col-sm-2 col-form-label control-label">File Materi</label>
                <div class="col-md-5">
                    <div class="custom-file">
                        <input id="materi_file_{{ $no }}"
                            type="file"
                            name="materi_file[]"
                            accept=".pdf, .ppt, .pptx"
                            class="custom-file-input file_materi_{{ $no }}">
                    </div>
                </div>
            </div>
            <div class="form-group row" id="linkInputGroup_{{ $no }}" hidden>
                <label class="col-sm-2 col-form-label control-label" required>Link Materi</label>
                <div class="col-md-5">
                    <input id="materi_link_{{ $no }}"
                        type="text"
                        class="form-control"
                        name="materi_link[]">
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
    <div class="form-group text-right mt-5">
        <button
            type="button"
            class="btn btn-success btn-save-new-materi">
            Simpan Materi Baru
        </button>
    </div>
</div>
</div>

<script>
    $(document).on('click', '.btn-save-new-materi', function() {

        let card = $(this).closest('.card');

        let formData = new FormData();

        formData.append(
            'ID_COURSE',
            $('#id_course').val()
        );

        formData.append(
            'TITLE',
            card.find('input[name="materi_title[]"]').val()
        );

        formData.append(
            'LINK_YT',
            card.find('input[name="materi_link_yt[]"]').val()
        );

        formData.append(
            'LINK_MATERI',
            card.find('input[name="materi_link[]"]').val()
        );

        formData.append(
            'DESKRIPSI',
            card.find('textarea[name="desc_materi[]"]').val()
        );

        formData.append(
            'ORDER_LIST',
            card.find('input[name="order_list[]"]').val()
        );

        let fileInput = card.find('input[name="materi_file[]"]')[0];

        if (fileInput && fileInput.files.length > 0) {
            formData.append(
                'materi_file',
                fileInput.files[0]
            );
        }

        $.ajax({
            url: '/courses/item/store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                console.log(response);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.succ_msg
                }).then(() => {

                    location.reload();

                });

            },
            error: function(xhr) {

                console.log(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error'
                });
            }
        });

    });
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $('#form-submit').on('submit', function(e) {
            $('.file_materi').each(function() {
                var fileInput = $(this)[0];
                var files = fileInput.files;
                var allowedExtensions = /(\.pdf|\.ppt|\.pptx)$/i;

                if (files.length > 0) {
                    for (var i = 0; i < files.length; i++) {
                        if (!allowedExtensions.exec(files[i].name)) {
                            alert('Invalid file type. Only PDF, PPT, and PPTX files are allowed.');
                            fileInput.value = '';
                            e.preventDefault();
                            return false;
                        }
                    }
                }
            });
        });
    });

    function toggleMateriInput(no, type) {
        // Reset semua input dan group
        $(`#fileInputGroup_${no}, #linkInputGroup_${no}`).prop('hidden', true);
        $(`#materi_file_${no}, #materi_link_${no}`).val('');

        if (type === 'file') {
            $(`#fileInputGroup_${no}`).prop('hidden', false);
        } else if (type === 'link') {
            $(`#linkInputGroup_${no}`).prop('hidden', false);
        }
    }

    document.querySelectorAll('.materi-option').forEach(radio => {
        radio.addEventListener('click', function(e) {
            const no = this.getAttribute('data-no');
            const type = this.value;
            toggleMateriInput(no, type);
        });
    });

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
        $('.file_materi_{{ $no }}').dropify({
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
        // i--;
        e.preventDefault();
    });
</script>
