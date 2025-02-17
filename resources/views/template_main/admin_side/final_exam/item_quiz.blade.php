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
                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}">
                <input type="hidden" class="form-control" name="type[]" value="2">
                <div id="delete_quiz_{{ $no }}" class="btn btn-danger px-1 py-0 float-right"
                    style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
                </div>
            </a>
        </h5>
    </div>
    <input type="hidden" name="materi_file[]">
    <input type="hidden" name="materi_title[]">
    <input type="hidden" name="materi_link[]">
    <input type="hidden" name="desc_materi[]">
    <div id="collapse{{ $no }}" class="collapse show" data-parent="#accordion-default">
        <div class="form-group ps-3 pe-3 row mt-3">
            <label class="col mt-3">Minimum Nilai Lulus<span class="text-danger">*</span></label>
            <div class="col-md-10">
                <input type="number" class="form-control" id="min_nilai_{{ $no }}" name="min_nilai_{{ $no }}" placeholder="75" required>
                <small class="text-danger">Minimal Nilai lulus di quiz ini</small>
            </div>
        </div>
        <div class="card-body">
            <div class="soal_form_{{ $no }}"></div>
            <div class="form-group row justify-content-center align-items-center">
                <div id="add_new_soal_{{ $no }}" class="btn btn-success col-md-2  float-right mx-2"
                    style="cursor: pointer;">
                    <i class="anticon anticon-loading m-r-5"></i>
                    <span class="col-md-12">Add New Question</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#collapse{{ $no }}').collapse('hide')

    $('#delete_quiz_{{ $no }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_quiz_{{ $no }}").removeClass("is-loading")
        $("#quiz_item_{{ $id_quiz }}").remove();
    });

    var no_quiz = 1;
    $('#add_new_soal_{{ $no }}').click(function() {
        $('#add_new_soal_{{ $no }}').toggleClass("is-loading");
        $.ajax({
            url: 'add_question/' + {{$no}} + '/' + no_quiz,
            success: function(html) {
                $(".soal_form_{{ $no }}").append(html);
                $('#add_new_batch_soal_{{ $no }}').removeClass("is-loading");
                $('#add_new_soal_{{ $no }}').removeClass("is-loading");
                no_quiz++;
            }
        });
    })

    $(".soal_form_{{ $no }}").sortable({
        cursor: "grabbing",
        helper: "clone",
         placeholder: "ui-state-highlight",
        start: function(event, ui) {
            ui.helper.addClass("ui-sortable-helper");
        }
    });
    $(".soal_form_{{ $no }}").disableSelection();
</script>