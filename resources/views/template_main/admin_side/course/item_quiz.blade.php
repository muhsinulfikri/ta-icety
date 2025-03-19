<style>
    .ui-sortable-helper {
        opacity: 0.7;
        cursor: grabbing !important;
    }

    .ui-state-highlight {
        height: 210px;
        line-height: 1.2em;
        background: #edf2f9;
        border-radius: .25rem;
    }
</style>

<div class="card" id="quiz_item_{{ $id_quiz }}">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12">
                <span class="col-md-11">Detail - Quiz</span>

                <input type="hidden" name="DELETED[]" value="0">
                <input type="hidden" name="ID_ITEM[]" value="">
                <input type="hidden" name="default_file[]" value="">
                <input type="hidden" name="materi_link[]" value="">
                <input type="hidden" name="materi_title[]" value="">
                <input type="hidden" name="materi_link_yt[]" value="">
                <input type="hidden" name="desc_materi[]" value="">

                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}">
                <input type="hidden" class="form-control" name="type[]" value="2">
                <div id="delete_quiz_{{ $no }}" class="btn btn-danger px-1 py-0 float-right" style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
                </div>
            </a>
        </h5>
    </div>
    <div id="collapse{{ $no }}" class="collapse show" data-parent="#accordion-default">
        <div class="card-body pb-0">
            <div class="w-100 d-flex justify-content-start align-items-center mt-3">
                <label>Minimum Nilai Lulus<span class="text-danger">*</span></label>
                <div class="col">
                    <input type="number" class="form-control" id="min_nilai_{{ $no }}" name="min_nilai_{{ $no }}"
                        placeholder="75" required>
                    <small class="text-danger">Minimal Nilai lulus di quiz ini</small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="soal_form_{{ $no }}"></div>
            <div class="form-group row justify-content-center align-items-center">
                <div id="add_new_soal_{{ $no }}" class="btn btn-success col-md-3 float-right mx-2"
                    style="cursor: pointer;">
                    <i class="anticon anticon-loading m-r-5"></i>
                    <span>Add New Question</span>
                </div>
                <div id="import_soal_{{ $no }}{{ $id_quiz }}" class="btn btn-success rounded col-md-3 float-end mx-2"
                    style="cursor: pointer;">
                    <span class="col-md-12 text-white">Import Soal</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" style="z-index: 1060;" id="insert_soal_{{ $no }}{{ $id_quiz }}" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalCenterTitle">Import Soal</h4>
                <button type="button" class="btn px-2 py-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <div class="modal-body row d-flex justify-content-center">
                <p>Masukkan File Excel Sesuai Template yang disediakan</p>
                <a href="https://expo-dev.is3.cloudhost.id/CAROUSEL/Image1729761040-1729761040.xlsx"
                    class="btn btn-success rounded text-white" download> Download Template</a>
                <div class="col-md-12 text-center d-flex justify-content-around py-2">
                    <input type="file" name="excel" id="excelFile_{{ $no }}{{ $id_quiz }}"
                        class="custom-file-input dropify" accept=".xlsx" data-allowed-file-extensions="xlsx">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark rounded text-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success rounded text-white"
                    id="submitFile_{{ $no }}{{ $id_quiz }}">Submit</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $('#collapse{{ $no }}').collapse('hide')

    $('#delete_quiz_{{ $no }}').click(function (e) {
        $(this).toggleClass("is-loading");
        $("#delete_quiz_{{ $no }}").removeClass("is-loading")
        $("#quiz_item_{{ $id_quiz }}").remove();
    });

    var no_quiz = 1;
    $('#add_new_soal_{{ $no }}').click(function () {
        $('#add_new_soal_{{ $no }}').toggleClass("is-loading");
        $.ajax({
            url: 'add_question/' + <?= $no ?> + '/' + no_quiz,
            success: function (html) {
                $(".soal_form_{{ $no }}").append(html);
                $('#add_new_batch_soal_{{ $no }}').removeClass("is-loading");
                $('#add_new_soal_{{ $no }}').removeClass("is-loading");
                no_quiz++;
            }
        });
    })

    $('.dropify').dropify({
        messages: {
            default: 'Drag dan drop untuk memilih file',
            replace: 'Ganti',
            remove: 'Hapus',
            error: 'error'
        }
    });

    $("#import_soal_{{ $no }}{{ $id_quiz }}").click(function () {
        $("#insert_soal_{{ $no }}{{ $id_quiz }}").modal('show');
    });

    $('#submitFile_{{ $no }}{{ $id_quiz }}').click(function () {
        Swal.fire({
            title: 'Loading...',
            text: 'Harap Tunggu.',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        $('#insert_soal_{{ $no }}{{ $id_quiz }}').modal('hide');
        $('#excelFile_{{ $no }}{{ $id_quiz }}').dropify('clear');
        const fileInput = document.getElementById('excelFile_{{ $no }}{{ $id_quiz }}');
        const file = fileInput.files[0];

        if (!file) {
            alert('Please select a file first.');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            // Get the first sheet
            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];

            // Convert the sheet to JSON format
            const jsonData = XLSX.utils.sheet_to_json(worksheet);

            function mapData(data) {
                return data.map(row => ({
                    questionNumber: row['No'],
                    question: row['Soal'],
                    optionA: row['Pilihan A'],
                    optionB: row['Pilihan B'],
                    optionC: row['Pilihan C'],
                    optionD: row['Pilihan D'],
                    answer: row['Jawaban (Abjad Saja gunakan huruf kecil)']
                }));
            }

            const mappedData = mapData(jsonData);
            // Create a function that returns a Promise for the AJAX call
            const addQuestion = (row) => {
                return new Promise((resolve, reject) => {
                    $('#add_new_batch_soal_{{ $no }}').toggleClass("is-loading");
                    $('#add_new_soal_{{ $no }}').toggleClass("is-loading");

                    $.ajax({
                        url: 'add_question/{{ $no }}/' + no_quiz,
                        success: function (html) {
                            $(".soal_form_{{ $no }}").append(html);
                            $('#add_new_batch_soal_{{ $no }}').removeClass("is-loading");
                            $('#add_new_soal_{{ $no }}').removeClass("is-loading");

                            callback(row, <?= $no ?? 0 ?>, no_quiz);
                            no_quiz++;
                            resolve(); // Resolve the promise when the AJAX call is successful
                        },
                        error: function (xhr, status, error) {
                            console.log('Error adding question:', error);
                            console.log(xhr.responseText);
                            reject(error); // Reject the promise on error
                        }
                    });
                });
            };

            // Use reduce to chain the promises
            mappedData.reduce((promise, row) => {
                return promise.then(() => {
                    return addQuestion(row);
                });
            }, Promise.resolve()) // Start with a resolved promise
                .then(() => {
                    Swal.close();
                })
                .catch((error) => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error during processing',
                        icon: 'error'
                    });
                    console.log("Error during processing:", error);
                });
        };

        reader.readAsArrayBuffer(file);
    });

    function callback(data, no, no_quiz) {
        $("input[name='question[" + no + "][" + no_quiz + "]']").val(data.question);
        $("#jawaban_a" + no + no_quiz + "").val(data.optionA);
        $("#jawaban_b" + no + no_quiz + "").val(data.optionB);
        $("#jawaban_c" + no + no_quiz + "").val(data.optionC);
        $("#jawaban_d" + no + no_quiz + "").val(data.optionD);
        $("input[name='kunci_soal[" + no + "][" + no_quiz + "]'][value='" + data.answer + "']").prop('checked', true);
    }

    $(".soal_form_{{ $no }}").sortable({
        cursor: "grabbing",
        helper: "clone",
        placeholder: "ui-state-highlight",
        start: function (event, ui) {
            ui.helper.addClass("ui-sortable-helper");
        }
    });

    $(".soal_form_{{ $no }}").disableSelection();
</script>