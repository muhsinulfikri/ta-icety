<div class="form-soal py-4 my-3 pl-4" data-id="{{ $item['ID_DETAIL'] }}" id="form-soal-{{ $item['ID_DETAIL'] }}" style="border: 1px solid #edf2f9; border-radius: .25rem; cursor: grab">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label control-label" id="label_soal">Question</label>
        <input type="hidden" class="form-control" name="order_list_question[]" value="{{ $no }}">
        <input type="hidden" class="form-control" name="list_quiz[]" value="{{ $index }}">
        <input type="hidden" name="ID_DETAIL" value="{{ $item['ID_DETAIL'] }}">
        <input type="hidden" name="ID_COURSE[{{ $item['ID_DETAIL'] }}]" value="{{ $item['ID_COURSE'] }}">
        <input type="hidden" name="ID_QUIZ[{{ $item['ID_DETAIL'] }}]" value="{{ $item['ID_QUIZ'] }}">
        <div class="col-md-10">
            <div class="d-flex flex-row">
                <div class="pe-3 flex-1 w-100">
                    <input type="text" class="form-control" name="question[{{ $no }}][{{ $index }}]" id="soal_{{ $item['ID_DETAIL'] }}"
                    value="{{ $item['SOAL'] }}">
                </div>
                {{-- <div id="delete_question_{{ $no }}{{ $index }}" class="justify-content-center rounded btn btn-danger px-3 py-0 float-end d-flex align-items-center" style="cursor: pointer;">
                    <span><i class="anticon anticon-close"></i> </span>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 d-flex align-self-center">
        </label>
        <div class="col-md-10">
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio1{{ $no }}{{ $index }}"
                        name="kunci_soal[{{ $item['ID_DETAIL'] }}]" id="kunci_soal_[{{ $item['ID_DETAIL'] }}]" type="radio"
                        value="a" <?= $item['KUNCI'] == 'a' ? 'checked' : '' ?>>
                    <label for="radio1{{ $no }}{{ $index }}" class="mr-1">A. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_a_{{ $item['ID_DETAIL'] }}" name="jawaban_a[]"
                        value="<?= $item['PIL_A'] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio2{{ $no }}{{ $index }}"
                        name="kunci_soal[{{ $item['ID_DETAIL'] }}]" id="kunci_soal_[{{ $item['ID_DETAIL'] }}]" type="radio"
                        value="b" <?= $item['KUNCI'] == 'b' ? 'checked' : '' ?>>
                    <label for="radio2{{ $no }}{{ $index }}" class="mr-1">B. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_b_{{ $item['ID_DETAIL'] }}" name="jawaban_b[]"
                        value="<?= $item['PIL_B'] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio3{{ $no }}{{ $index }}"
                        name="kunci_soal[{{ $item['ID_DETAIL'] }}]" id="kunci_soal_[{{ $item['ID_DETAIL'] }}]" type="radio"
                        value="c" <?= $item['KUNCI'] == 'c' ? 'checked' : '' ?>>
                    <label for="radio3{{ $no }}{{ $index }}" class="mr-1">C. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_c_{{ $item['ID_DETAIL'] }}" name="jawaban_c[]"
                        value="<?= $item['PIL_C'] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio4{{ $no }}{{ $index }}"
                        name="kunci_soal[{{ $item['ID_DETAIL'] }}]" id="kunci_soal_[{{ $item['ID_DETAIL'] }}]" type="radio"
                        value="d" <?= $item['KUNCI'] == 'd' ? 'checked' : '' ?>>
                    <label for="radio4{{ $no }}{{ $index }}" class="mr-1">D. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_d_{{ $item['ID_DETAIL'] }}" name="jawaban_d[]"
                        value="<?= $item['PIL_D'] ?>">
                </div>
            </div>
            <div class="form-group text-right mt-5">
                <button type="button" class="btn btn-primary btn-submit-form" onclick="saveUpdate(this)" data-id="{{ $item['ID_DETAIL'] }}">Simpan Kuis</button>
            </div>
        </div>
    </div>
</div>
<script>
    function saveUpdate(button) {
        let idDetail = $(button).data('id');
        let idCourse = $(`input[name="ID_COURSE[${idDetail}]"]`).val();
        let idQuiz = $(`input[name="ID_QUIZ[${idDetail}]"]`).val();
        let jawaban_a = $('#jawaban_a_' + idDetail).val();
        let jawaban_b = $('#jawaban_b_' + idDetail).val();
        let jawaban_c = $('#jawaban_c_' + idDetail).val();
        let jawaban_d = $('#jawaban_d_' + idDetail).val();
        let kunci = $(`input[name="kunci_soal[${idDetail}]"]:checked`).val();


        let formData = new FormData();
        formData.append('ID_DETAIL', idDetail);
        formData.append('ID_COURSE', idCourse);
        formData.append('ID_QUIZ', idQuiz);
        formData.append('SOAL', $('#soal_' + idDetail).val());
        formData.append('PIL_JWB', `${jawaban_a};${jawaban_b};${jawaban_c};${jawaban_d}`);
        formData.append('KUNCI', kunci);

        $.ajax({
            url: 'update/item_quiz',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function(response) {
                Swal.fire('Berhasil', 'Soal berhasil diperbarui!', 'success');
            },
            error: function(xhr) {
                Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan!', 'error');
            }
        });
    }

    $('#delete_question_{{ $no }}{{ $index }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_question_{{ $no }}{{ $index }}").removeClass("is-loading")
        $(".form-soal-{{ $no }}{{ $index }}").remove();
        e.preventDefault();
    });
</script>
