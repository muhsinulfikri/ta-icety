<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center mt-5">
                    <a href="<?= url('courses') ?>" class="d-flex align-items-center justify-content-start w-100 gap-2 text-dark">
                        <i class="fas fa-chevron-left mr-2"></i>
                        <h3 class="fw-bold mb-0" style="color:#45b104 !important">Update Course </h3>
                    </a>
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
            <div class="mt-5">
                <form id="form-user" action="update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ID_ACTIVITY">
                    <input type="hidden" name="ID_COURSE">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Cover <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <div class="custom-file">
                                <input type="file" name="image_activity" class="custom-file-input dropify"
                                    accept=".jpg, .png" data-allowed-file-extensions="jpg png">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Judul <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title_activity" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Alias <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="alias_course" placeholder="Alias Course"
                                required pattern="[A-Z\s]+" title="Only uppercase letters are allowed" oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Price Course</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control CurrencyInput" name="price" value="">
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Free
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Instructor <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="instructor_activity" placeholder="Instructor Course"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Description Instructor<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea class="form-desc-course" name="desc_instructor" id="desc_instructor"></textarea>
                            <div id="desc_instructor_editor"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label"></label>
                        <div class="d-flex align-items-center mt-2">
                            No Requirement
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" id="req">
                                <label for="req"></label>
                            </div>
                            Need Requirement
                        </div>
                    </div>
                    <div id="requirement-container"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label"></label>
                        <div class="d-flex align-items-center mt-2">
                            No Final Exam
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" id="final-toggle">
                                <label for="final-toggle"></label>
                            </div>
                            Need Final Exam
                        </div>
                    </div>
                    <div id="final-exam-container"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Date Course<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <div class="d-flex align-items-center">
                                <input type="datetime-local" class="form-control" name="date_start"
                                    placeholder="Date Start" required>
                                <span class="p-h-10">to</span>
                                <input type="datetime-local" class="form-control" name="date_end" placeholder="Date End"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Date Download Sertif <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <div class="d-flex align-items-center">
                                <input type="date" class="form-control" name="date_download_sertif"
                                    placeholder="Date Download Sertif" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Durasi per Months<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" name="duration_months" required>
                            <small class="text-danger">* Input number only</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Durasi per Hours<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" name="duration_hours" required>
                            <small class="text-danger">* Input number only</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Announcement<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="announcement" id="announcement" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Description Course<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="desc" id="desc" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">What to Learn ?<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="desc_item" id="desc_item" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Title Certificate<span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="title_certificate" placeholder="Title Certificate"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Certifikat Template <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <div class="custom-file">
                                <input type="file" name="sertif_image" class="custom-file-input dropify"
                                    accept=".jpg" data-allowed-file-extensions="jpg">
                                <small class="text-danger">* Input JPG only file</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Summary Certificate<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="summary_certificate" id="summary_certificate" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Modules for Certificate<span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="modules_certificate" id="modules_certificate" rows=11 cols=50 maxlength=250 required></textarea>
                            <small class="text-danger">* Modules Certificate for display in Certificate</small>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Price Certificate</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control CurrencyInputSertif" name="price_sertif" value="">
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFreeSertif">
                                    <label for="setFreeSertif"></label>
                                </div>
                                Free
                            </span>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Type Course <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="select2" name="is_public">
                                <option value="1">Public</option>
                                <option value="0">Private</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Categori <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="select2" name="category">
                                @foreach ($data['kategori'] as $item)
                                <option value="<?= $item->ID_KATEGORI ?>"><?= $item->KATEGORI ?>
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if (session('user')[0]['ID_ROLE'] == 1)
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Status</label>
                            <div class="col-md-5 column">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="switch-1" name="status" checked="">
                                    <label for="switch-1"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group text-right mt-5">
                        <button type="submit" class="btn btn-primary btn-submit-form">Simpan</button>
                    </div>
                    <div class="accordion materi_form" id="accordion-default">

                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-12">
                            <div data-toggle="modal" id="add_item" data-target="#exampleModalCenter"
                                class="btn btn-primary m-r-5 col-md-12" style="cursor: pointer;">
                                <i class="anticon anticon-loading m-r-5"></i>
                                <span class="col-md-12">Add Materi / Quiz</span>
                            </div>
                        </div>
                    </div> --}}

                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal  -->
<div class="modal fade" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Materi or Quiz ?</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 text-center d-flex justify-content-around">
                    <a href="javascript.void(0)" id="add_materi" data-dismiss="modal"
                        class="btn btn-success col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-book text-white"></i></h1> MATERI
                    </a>
                    <a href="javascript.void(0)" id="add_quiz" data-dismiss="modal"
                        class="btn btn-danger col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-trophy text-white"></i></h1> QUIZ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->

<script>
    var id_quiz = 1;
    var limit = 0;

    var data = <?= $jsonData ?? '' ?>;
    var price = data.PRICE_ACTIVITY;
    var price_sertif = data.PRICE_SERTIF
    var id_course = data.ID_COURSE;
    var id_act = data.ID_ACTIVITY;
    var req = data.REQUIREMENT;
    var final_exam = data.FINAL_EXAM;

    var item = <?= $data['item'] ?>;
    var last_id = <?= $data['last_id'] ?>;

    // Load Image
    var cover_book = $('input[name="image_activity"]').dropify();
    cover_book = cover_book.data('dropify');
    cover_book.resetPreview();
    cover_book.clearElement();
    cover_book.settings['defaultFile'] = data.IMAGE_ACTIVITY;
    cover_book.destroy();
    cover_book.init();

    var sertif_image = $('input[name="sertif_image"]').dropify();
    sertif_image = sertif_image.data('dropify');
    sertif_image.resetPreview();
    sertif_image.clearElement();
    sertif_image.settings['defaultFile'] = data.SERTIF_IMAGE;
    sertif_image.destroy();
    sertif_image.init();

    $('input[name="ID_ACTIVITY"]').val(id_act);
    $('input[name="ID_COURSE"]').val(data.ID_COURSE);
    $('input[name="title_activity"]').val(data.TITLE_ACTIVITY);
    $('input[name="title_certificate"]').val(data.TITLE_CERTIFICATE);
    $('input[name="alias_course"]').val(data.ALIAS);
    $('input[name="instructor_activity"]').val(data.INSTRUCTOR_NAME);
    $('#desc_instructor').summernote('code', data.DESC_INSTRUCTOR);
    $('#summary_certificate').summernote('code', data.SUMMARY_CERTIFICATE);
    $('#modules_certificate').summernote('code', data.MODULE_CERTIFICATE);
    if (price == 0) {
        $('#setFree').prop('checked', true);
        $('.CurrencyInput').prop('readonly', true)
        $('input[name="price"]').val(0);
    } else {
        $('#setFree').prop('checked', false);
        $('input[name="price"]').val(price);
    }
    if (req == null) {
        $('#req').prop('checked', false);
    } else {
        $('#req').prop('checked', true);
        $('#requirement-container').html(`
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Requirement</label>
                        <div class="col-md-5">
                            <select name="req" id="reqSelect" class="select2" placeholder="Select Requirement ...">
                                @foreach ($data['requirement'] as $item)
                                    <option value="{{ $item->ID_ACTIVITY }}">{{ $item->TITLE_ACTIVITY }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                `);
        $('select[name="req"]').val(req);
    }
    console.log(final_exam);
    if (final_exam == null) {
        $('#final-toggle').prop('checked', false);
    } else {
        $('#final-toggle').prop('checked', true);
        $('#final-exam-container').html(`
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Final Exam</label>
                        <div class="col-md-5">
                            <select name="final_exam" id="finalExamSelect" class="select2" placeholder="Select Final Exam ...">
                                @foreach ($data['final_exam'] as $item)
                                    <option value="{{ $item->ID_ACTIVITY }}">{{ $item->TITLE_ACTIVITY }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                `);
        $('select[name="final_exam"]').val(final_exam);
    }
    $('input[name="date_start"]').val(data.DATE_START);
    $('input[name="date_end"]').val(data.DATE_END);
    $('input[name="date_download_sertif"]').val(data.DATE_DOWNLOAD_SERTIF);
    $('input[name="duration_months"]').val(data.DURATION);
    $('input[name="duration_hours"]').val(data.HOURS);
    if (price_sertif == 0) {
        $('#setFreeSertif').prop('checked', true);
        $('input[name="price_sertif"]').val(0);
    } else {
        $('#setFreeSertif').prop('checked', false);
        $('input[name="price_sertif"]').val(price_sertif);
    }
    $('select[name="is_public"]').val(data.IS_PUBLIC);
    $('select[name="category"]').val(data.ID_KATEGORI);
    $('input[name="status"]').prop('checked', data.STATUS);

    $.ajax({
        url: 'get/' + id_act,
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            $('#announcement').summernote('code', response[0].PENGUMUMAN);
            $('#desc').summernote('code', response[0].DESKRIPSI_COURSE);
            $('#desc_item').summernote('code', response[0].DESKRIPSI_COURSE_ITEM);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val(price)
        }
    })

    $('#setFreeSertif').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInputSertif').prop('readonly', true)
            $('.CurrencyInputSertif').val(0)
        } else {
            $('.CurrencyInputSertif').prop('readonly', false)
            $('.CurrencyInputSertif').val(price_sertif)
        }
    })

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

    $(document).ready(function() {
        var $editor = $('#desc_item');
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

    $(document).ready(function() {
        var $editor = $('#summary_certificate');
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

    $(document).ready(function() {
        var $editor = $('#modules_certificate');
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

    $(document).ready(function() {
        var $editor = $('#announcement');
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

    $('#add_materi').click(function(e) {
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_materi/' + item,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
                item++;
                limit++;
            }
        });
        e.preventDefault();
    });

    $('#add_quiz').click(function(e) {
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_quiz/' + item + '/' + id_quiz,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
                item++;
                limit++;
                id_quiz++;
            }
        });
        e.preventDefault();
    });

    $.ajax({
        url: 'get_course_item/' + id_course,
        type: "GET",
        beforeSend: function() {
            $('#add_item').toggleClass("is-loading");
        },
        success: function(html) {
            $("#add_item").removeClass("is-loading");
            $(".materi_form").append(html);
            limit = item;
        }
    });

    $(document).ready(function() {
        $('#req').change(function() {
            if ($(this).is(':checked')) {
                $('#requirement-container').html(`
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Requirement</label>
                        <div class="col-md-10">
                            <select name="req" id="reqSelect" class="select2" placeholder="Select Requirement ...">
                                @foreach ($data['requirement'] as $item)
                                    <option value="{{ $item->ID_ACTIVITY }}">{{ $item->TITLE_ACTIVITY }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                `);

                $('#reqSelect').select2({
                    placeholder: "Select Requirement ...",
                    allowClear: true,
                    width: '100%'
                });
            } else {
                $('#requirement-container').empty();
            }
        });

        $('#final-toggle').change(function() {
            if ($(this).is(':checked')) {
                $('#final-exam-container').html(`
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Final Exam</label>
                        <div class="col-md-5">
                            <select name="final_exam" id="finalExamSelect" class="select2" placeholder="Select Final Exam ...">
                                @foreach ($data['final_exam'] as $item)
                                    <option value="{{ $item->ID_ACTIVITY }}">{{ $item->TITLE_ACTIVITY }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                `);

                $('#finalExamSelect').select2({
                    placeholder: "Select Final Exam ...",
                    allowClear: true,
                    width: '100%'
                });
            } else {
                $('#final-exam-container').empty();
            }
        });
    });

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Drag or drop image here or klik gambar disini atau klik',
                replace: 'Changes',
                remove: 'Delete',
                error: 'Error'
            },
            error: {
                'fileSize': 'File Size Too Big (Max 1MB).'
            }
        });
    });
</script>
