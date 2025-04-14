<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Add <?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('dashboard') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Home</a>
                <a class="breadcrumb-item" href="<?= asset('manage/activity/course') ?>"><?= $title ?></a>
                <span class="breadcrumb-item active">Add <?= $title ?></span>
            </nav>
        </div>
    </div>
    {{-- <?php if (!empty(validation_errors())) { ?>
        <div class="alert alert-warning">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-exclamation-o"></i>
                </span>
                <span><?= validation_errors() ?></span>
            </div>
        </div>
    <?php } ?> --}}
    <div class="card">
        <div class="card-body">
            <div class="m-t-25">
                <form id="form-user" action="store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Cover <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="image_activity" class="custom-file-input dropify"
                                    accept=".jpg, .png, .jpeg" data-allowed-file-extensions="jpg png jpeg" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Title <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="title_activity" placeholder="Title Course"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Alias <span
                                class="text-danger">*</span></label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="alias_course" placeholder="Alias Course"
                                        required pattern="[A-Z\s]+" title="Only uppercase letters are allowed"
                                        oninput="this.value = this.value.toUpperCase()">
                                    <small id="alias-feedback"></small>
                                </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Price <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="number" class="form-control CurrencyInput" name="price_course"
                                placeholder="0" required>
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
                        <label class="col-sm-2 col-form-label control-label">Date <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
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
                        <label class="col-sm-2 col-form-label control-label">Duration in Month<span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" name="duration_month" placeholder="Duration Complete Course in Month"
                                required>
                            <small class="text-danger">* Input number only</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Duration in Hours<span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" name="duration_hour" placeholder="Duration Complete Course in Hours"
                                required>
                            <small class="text-danger">* Input number only</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Announcement <span
                        class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea class="form-announcement" name="announcement" id="announcement"  style="opacity: 0; position: absolute; z-index: -1;"></textarea>
                            <div id="announcement_editor"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Description <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea class="form-desc-course" name="desc_course" id="desc_course" rows=11 cols=50 maxlength=250  style="opacity: 0; position: absolute; z-index: -1;"></textarea>
                            <div id="desc_course_editor"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">What to Learn ? <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea class="form-desc-learn" name="desc_what_to_learn" id="desc_what_to_learn" rows=11 cols=50 maxlength=250  style="opacity: 0; position: absolute; z-index: -1;"></textarea>
                            <div id="desc_learn_editor"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Title Certificate<span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="title_certificate" placeholder="Title Certificate"
                                required>
                                <small class="text-danger">* Title Certificate for display in Certificate</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Certifikat Template</span>
                        </label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="sertif_image" class="custom-file-input dropify"
                                    accept=".jpg" data-allowed-file-extensions="jpg" required>
                                <small class="text-danger">Input JPG only file, Jika tidak input maka akan menggunakan sertifikat template</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Modules for Certificate<span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea class="form-modules" name="modules_certificate" id="modules_certificate" rows=11 cols=50 maxlength=250  style="opacity: 0; position: absolute; z-index: -1;"></textarea>
                            <div id="modules_certificate_editor"></div>
                            <small class="text-danger">* Modules Certificate for display in Certificate</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Summary Certificate<span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea class="form-summary" name="summary_certificate" id="summary_certificate" rows=11 cols=50 maxlength=250  style="opacity: 0; position: absolute; z-index: -1;"></textarea>
                            <div id="summary_certificate_editor"></div>
                            <small class="text-danger">* Summary Certificate for display in Certificate</small>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Price For Certificate <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="number" class="form-control CurrencyInputSertif" name="price_sertif"
                                placeholder="0" required>
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
                        <div class="col-md-5">
                            <select class="select2" name="is_public">
                                <option value="1">Public</option>
                                <option value="0">Private</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Category <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <select class="select2" name="category">
                                @foreach ($kategori as $item)
                                    <option value="<?= $item->ID_KATEGORI ?>"><?= $item->KATEGORI ?>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Status</label>
                        <div class="col-md-5 row">
                            Not Active
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" id="switch-1" name="status" checked="">
                                <label for="switch-1"></label>
                            </div>
                            Active
                        </div>
                    </div>
                    <div class="accordion materi_form" id="accordion-default">

                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div data-toggle="modal" id="add_item" data-target="#exampleModalCenter"
                                class="btn btn-primary m-r-5 col-md-12" style="cursor: pointer;">
                                <i class="anticon anticon-loading m-r-5"></i>
                                <span class="col-md-12">Add Item</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right mt-5">
                        <button type="submit" class="btn btn-primary btn-submit-form">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Start Add Item --}}
<div class="modal fade" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Chapter or Quiz ?</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 text-center d-flex justify-content-around">
                    <a href="javascript.void(0)" id="add_materi" data-dismiss="modal"
                        class="btn btn-success col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-book text-white"></i></h1> CHAPTER
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
{{-- End add Item --}}

<script>
    var i = 0;
    var id_quiz = 1;
    var limit = 0;

    $(document).ready(function() {
        function initializeSummernote(editorSelector, textareaSelector, formSelector) {
            var $editor = $(editorSelector);
            var $textarea = $(textareaSelector);
            var $form = $(formSelector);
            console.log($form);


            $editor.summernote({
                height: 200,
                callbacks: {
                    onPaste: function(e) {
                        console.log('Called event paste', e);
                    },
                    onImageUpload: function(files) {
                        console.log(files);
                        $editor.summernote('insertNode', imgNode);
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

            $form.on('submit', function(e) {
                var content = $editor.summernote('code').trim();

                // Set textarea value to the editor content
                $textarea.val(content);
                $textarea[0].setCustomValidity(''); // Reset error

                // If empty, prevent submission and show error
                if (!content || content === '<p><br></p>') {
                    e.preventDefault();
                    $textarea[0].setCustomValidity('Please fill out this field.');
                    $textarea[0].reportValidity(); // Trigger browser validation
                    $editor.next('.note-editor').addClass('border border-danger');
                } else {
                    $editor.next('.note-editor').removeClass('border border-danger');
                }
            });

            // Remove error if user types
            $editor.on('summernote.change', function() {
                $textarea[0].setCustomValidity('');
                $editor.next('.note-editor').removeClass('border border-danger');
            });
        }

        // Initialize Summernote for all editors
        initializeSummernote('#announcement_editor', '#announcement', '#form-user');
        initializeSummernote('#desc_course_editor', '#desc_course', '#form-user');
        initializeSummernote('#desc_learn_editor', '#desc_what_to_learn', '#form-user');
        initializeSummernote('#modules_certificate_editor', '#modules_certificate', '#form-user');
        initializeSummernote('#summary_certificate_editor', '#summary_certificate', '#form-user');
    });

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('')
        }
    })

    $('#setFreeSertif').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInputSertif').prop('readonly', true)
            $('.CurrencyInputSertif').val(0)
        } else {
            $('.CurrencyInputSertif').prop('readonly', false)
            $('.CurrencyInputSertif').val('')
        }
    })

    const dateStartInput = document.getElementById('date_start');
    const dateEndInput = document.getElementById('date_end');
    $(document).ready(function() {
        dateStartInput.addEventListener('change', function() {
            // Set the minimum value of date_end to the value of date_start
            dateEndInput.min = dateStartInput.value;

            // If date_end is before date_start, clear the date_end input
            if (dateEndInput.value && dateEndInput.value < dateStartInput.value) {
                dateEndInput.value = '';
            }
        });


        dateEndInput.addEventListener('change', function() {
            // Check if date_end is before date_start
            if (dateEndInput.value < dateStartInput.value) {
                alert('Akhir tanggal tidak bisa dipilih sebelum tanggal dimulai');
                dateEndInput.value = '';
            }
        });
    });

    $('#add_materi').click(function(e) {
        $("#add_item").toggleClass("is-loading");
        $.ajax({
            url: 'add_materi/' + i,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("is-loading");
                i++;
                limit++;
            }
        });
        e.preventDefault();
    });

    $('#add_quiz').click(function(e) {
        $("#add_item").toggleClass("is-loading");
        $.ajax({
            url: 'add_quiz/' + i + '/' + id_quiz,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("is-loading");
                i++;
                limit++;
                id_quiz++;
            }
        });
        e.preventDefault();
    });

    $(document).ready(function() {
        $('#req').change(function() {
            if ($(this).is(':checked')) {
                $('#requirement-container').html(`
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Requirement</label>
                        <div class="col-md-5">
                            <select name="req" id="reqSelect" class="select2" placeholder="Select Requirement ...">
                                @foreach ($requirement as $item)
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
                                @foreach ($final_exam as $item)
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

    $('.dropify').dropify({
        messages: {
            default: 'Drag atau drop to choose file',
            replace: 'Change',
            remove: 'Delete',
            error: 'error'
        }
    });
    $(document).ready(function () {
        $('input[name="alias_course"]').on('input', function () {
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
