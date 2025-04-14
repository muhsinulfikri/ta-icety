<div class="form-soal-{{ $no }}{{ $index }} py-4 my-3 pl-4" style="border: 1px solid #edf2f9; border-radius: .25rem; cursor: grab">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label control-label" id="label_soal">Question</label>
        <input type="hidden" class="form-control" name="order_list_question[]"
            value="{{ $no }}">
        <input type="hidden" class="form-control" name="list_quiz[]"
            value="{{ $index }}">
        <input type="hidden" name="ID_DETAIL[{{ $item['ID_QUIZ'] }}][{{ $item['ID_DETAIL'] }}]" value="{{ $item['ID_DETAIL'] }}">
        <div class="col-md-10">
            <div class="d-flex flex-row">
                <div class="pe-3 flex-1 w-100">
                    <input type="text" class="form-control" name="question[{{ $no }}][{{ $index }}]"
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
                        name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio"
                        value="a" <?= $item['KUNCI'] == 'a' ? 'checked' : '' ?>>
                    <label for="radio1{{ $no }}{{ $index }}" class="mr-1">A. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_a{{ $no }}{{ $index }}" name="jawaban_a[]"
                        value="<?= $item['PIL_A'] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio2{{ $no }}{{ $index }}"
                        name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio"
                        value="b" <?= $item['KUNCI'] == 'b' ? 'checked' : '' ?>>
                    <label for="radio2{{ $no }}{{ $index }}" class="mr-1">B. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_b{{ $no }}{{ $index }}" name="jawaban_b[]"
                        value="<?= $item['PIL_B'] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio3{{ $no }}{{ $index }}"
                        name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio"
                        value="c" <?= $item['KUNCI'] == 'c' ? 'checked' : '' ?>>
                    <label for="radio3{{ $no }}{{ $index }}" class="mr-1">C. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_c{{ $no }}{{ $index }}" name="jawaban_c[]"
                        value="<?= $item['PIL_C'] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio4{{ $no }}{{ $index }}"
                        name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio"
                        value="d" <?= $item['KUNCI'] == 'd' ? 'checked' : '' ?>>
                    <label for="radio4{{ $no }}{{ $index }}" class="mr-1">D. </label>
                    <input type="text" class="form-control col-md-10" id="jawaban_d{{ $no }}{{ $index }}" name="jawaban_d[]"
                        value="<?= $item['PIL_D'] ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#delete_question_{{ $no }}{{ $index }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_question_{{ $no }}{{ $index }}").removeClass("is-loading")
        $(".form-soal-{{ $no }}{{ $index }}").remove();
        e.preventDefault();
    });
</script>
