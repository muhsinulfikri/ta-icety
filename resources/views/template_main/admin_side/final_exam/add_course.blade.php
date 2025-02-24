<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Add <?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('courses') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Kursus</a>
                <span class="breadcrumb-item active">Add <?= $title ?></span>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="m-t-25">
                <form id="form-user" action="{{url("courses/add-final/store")}}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                                required pattern="[A-Z\s]+" title="Only uppercase letters are allowed" oninput="this.value = this.value.toUpperCase()">
                                <small id="alias-feedback"></small>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Price <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="number" class="form-control CurrencyInput" name="price_course"
                                placeholder="0">
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
                        <label class="col-sm-2 col-form-label control-label">Certifikat Template</span>
                        </label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="sertif_image" class="custom-file-input dropify"
                                    accept=".jpg" data-allowed-file-extensions="jpg">
                                <small class="text-danger">Input JPG only file, Jika tidak input maka akan menggunakan sertifikat template</small>
                            </div>
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
                            <div id="add_quiz"
                                class="btn btn-primary m-r-5 col-md-12" style="cursor: pointer;">
                                <i class="anticon anticon-loading m-r-5"></i>
                                <span class="col-md-12">Add Quiz</span>
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

<script>
    var i = 0;
    var id_quiz = 1;
    var limit = 0;

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('')
        }
    })

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('')
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
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
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
