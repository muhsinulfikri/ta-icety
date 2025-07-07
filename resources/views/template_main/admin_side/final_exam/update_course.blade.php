<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center mt-5">
                    <h3 class="fw-bold" style="color:#45b104">Update Course </h3>
                </div>
            </div>
            <div class="mt-5">
                <form id="form-user" action="update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ID_ACTIVITY">
                    <input type="hidden" name="ID_COURSE">
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
                        <label class="col-sm-2 col-form-label control-label">Include Course?</label>
                        <div class="col-md-5 row">
                            No
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" id="switch-2" name="setYesNo">
                                <label for="switch-2"></label>
                            </div>
                            Yes
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Remedial <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="number" class="form-control" name="remedial" placeholder="0">
                        </div>
                    </div>
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
                    @endif
                    <div class="accordion materi_form" id="accordion-default">

                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-12">
                            <div id="add_quiz"
                                class="btn btn-primary m-r-5 col-md-12" style="cursor: pointer;">
                                <i class="anticon anticon-loading m-r-5"></i>
                                <span class="col-md-12">Add Quiz</span>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group text-right mt-5">
                        <button type="submit" class="btn btn-primary btn-submit-form">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var id_quiz = 1;
    var limit = 0;

    var data = {!! $jsonData !!};
    var price = data.PRICE_ACTIVITY;
    var id_course = data.ID_COURSE;
    var id_act = data.ID_ACTIVITY;
    var req = data.REQUIREMENT;
    var yesNo = data.INCLUDE_COURSE

    var item = <?= $data['item'] ?>;
    var last_id = <?= $data['last_id'] ?>;

    // Load Image
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

    $('input[name="alias_course"]').val(data.ALIAS)
    if (price == 0) {
        $('#setFree').prop('checked', true);
        $('input[name="price"]').val(0);
    } else {
        $('#setFree').prop('checked', false);
        $('input[name="price"]').val(price);
    }
    if(yesNo == 1) {
        $('#switch-2').prop('checked', true);
    } else {
        $('#switch-2').prop('checked', false);
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
    $('input[name="remedial"]').val(data.REMEDIAL)
    $('input[name="date_start"]').val(data.DATE_START);
    $('input[name="date_end"]').val(data.DATE_END);
    $('input[name="certif_code"]').val(data.SERTIF_CODE);
    $('input[name="status"]').prop('checked', data.STATUS);

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val(price)
        }
    })

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
