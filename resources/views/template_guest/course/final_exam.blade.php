@if ($nilai_final_exam == null)
<div class="container d-flex justify-content-center align-items-center flex-column my-4">
    <h6 class="fw-semibold mt-5 w-100 text-start">Final Exam :</h6>
    <?php if (is_null($quiz_grade)) {
        $no_soal = 0;
        foreach ($data as $item) {
            $soal = explode(";", $item->PIL_JWB);
    ?>
            <div class="bg-white my-3 p-4 rounded-3 shadow fw-semibold w-75">
                <?= $item->SOAL ?>
            </div>
            <div class="my-4 d-flex flex-wrap flex-column gap-3 w-75">
                <?php
                $pilihan = ['a', 'b', 'c', 'd'];
                $no = 0;
                $no_pilihan = 0;
                foreach ($soal as $soal_item) :
                    if (!empty(trim($soal_item))) {
                ?>
                <button class="btn btn-outline-dark py-2 px-3 rounded-3 shadow fw-semibold"
                    data-value="<?= $pilihan[$no] ?>"
                    id="jwbn_<?= $item->ID_DETAIL . '' . ++$no ?>"
                    onclick="SelectJwbn<?= $item->ID_DETAIL . '' . $item->ORDER_LIST ?>(this)">
                    <?= $pilihan[$no_pilihan].'. '.$soal_item ?>
                </button>
                <?php                    
                    $no_pilihan++;
                    }
                endforeach;
                ?>
                <input type="hidden" name="id_quiz" value="<?= $item->ID_QUIZ ?>">
                <input type="hidden" name="id_detail[]" value="<?= $item->ID_DETAIL ?>">
                <input type="hidden" name="jwbn[]">
            </div>
            <script>
                $("#jwbn_<?= $item->ID_DETAIL . '1' ?>").trigger('click')

                function SelectJwbn<?= $item->ID_DETAIL . '' . $item->ORDER_LIST ?>(e) {
                    $("[id^='jwbn_<?= $item->ID_DETAIL ?>']").removeClass("btn-secondary");
                    $('input[name="jwbn[]"]').eq(<?= $no_soal++ ?>).val($(e).data("value"));
                    $(e).addClass("btn-secondary");
                }
            </script>
    <?php }
    } else { ?>
        <div class="text-center py-5 w-75">
            <img class="img-fluid rounded-circle" src="<?= $quiz_grade->NILAI == 100 ? 'https://img.freepik.com/free-vector/completed-concept-illustration_114360-3891.jpg' : 'https://img.freepik.com/free-vector/hr-management-hiring-employees-people-cv_107791-11222.jpg' ?>" style="max-width: 50%;">
            <h6 class="fw-semibold pt-4">
                Anda Sudah Menyelesaikan Quiz dan Mendapatkan Nilai: <?= $quiz_grade->NILAI ?>
            </h6>
        </div>
        <?php if (!empty($data_all_mapping) && $last_item[0]->ID_ITEM == $id_item) { ?>
            <button class="btn btn-secondary mt-4 px-4 py-2 rounded-3 shadow fw-semibold w-75" data-iditem="<?= $id_item ?>" data-status="2" data-type="2" onclick="NextItem(this)">Continue</button>
        <?php } ?>
    <?php } ?>

    <?php if (is_null($quiz_grade)) { ?>
        <button class="btn btn-secondary px-4 py-2 mt-2 rounded-3 shadow fw-semibold w-75" data-bs-toggle="modal" data-bs-target="#ShowConfirmSubmitKuis<?= $item->ID_ITEM ?>">
            Kumpulkan Kuis
        </button>
        <div class="modal fade" id="ShowConfirmSubmitKuis<?= $item->ID_ITEM ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content px-3 py-3 text-center">
                    <div class="modal-body">
                        <img class="img-fluid rounded-circle" src="<?= url('assets/images/modal-img.svg') ?>" style="width: 80%;">
                        <h5 class="fw-semibold mt-3">Apakah Anda Yakin Ingin Mengumpulkan Kuis?</h5>
                    </div>
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-danger w-50" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-dark w-50" onclick="submitKuis<?= $item->ID_ITEM ?>(this)">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function submitKuis<?= $item->ID_ITEM ?>(e) {
                var id_detail = $('input[name="id_detail[]"]').map(function() { return this.value; }).get();
                var pilih_jwbn = $('input[name="jwbn[]"]').map(function() { return this.value; }).get();
                var id_activity = @json($id_activity);

                $("#ShowConfirmSubmitKuis<?= $item->ID_ITEM ?> .modal-body").html('<div class="d-flex justify-content-center align-items-center h-100 mt-4"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>');
                $("#ShowConfirmSubmitKuis<?= $item->ID_ITEM ?> .modal-footer").html('');
                jQuery.ajax({
                    url: "<?= Request::segment(0) ?>/course/final-exam/evaluation/",
                    type: "POST",
                    data: { 
                        "_token": "{{ csrf_token() }}", 
                        "id_quiz": $('input[name="id_quiz"]').val(), 
                        "id_detail": id_detail, 
                        "code_exam": "<?= $code ?>",
                        "id_activity": id_activity, 
                        "pilih_jwbn": pilih_jwbn 
                    },
                    success: function(data) {
                        $("#ShowConfirmSubmitKuis<?= $item->ID_ITEM ?> .modal-body").html('<img class="img-fluid rounded-circle" src="https://img.freepik.com/free-vector/completed-concept-illustration_114360-3891.jpg" style="width: 80%;"><h6 class="fw-semibold text-center mt-3">Nilai Anda: ' + data.nilai + '</h6>');
                        $("#ShowConfirmSubmitKuis<?= $item->ID_ITEM ?> .modal-footer").html('<button type="button" class="btn btn-danger w-50" data-bs-dismiss="modal">Close</button>');
                        $(e).hide();
                        $('#ShowConfirmSubmitKuis<?= $item->ID_ITEM ?>').on('hidden.bs.modal', function () {
                            window.location.href = "<?= Request::segment(0) ?>/course/detail/course-after_final?id_activity=<?= $id_activity_parent ?>";
                        });
                    }
                });
            }
        </script>
    <?php } ?>
</div>
@endif