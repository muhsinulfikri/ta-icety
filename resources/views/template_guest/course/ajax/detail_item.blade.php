<?php if ($type == 1) { ?>
    <div class="mx-4 my-4">
        <h5 class="py-2 fw-semibold"><?= $detail_item_course->TITLE ?></h5>
        @if ($detail_item_course->LINK_MATERI != null || $detail_item_course->FILE != null)
        <hr>
        <section id="doc-course">
            <div class="d-flex justify-content-center align-items-center" id="document-frame">
                <div class="d-flex align-items-center justify-content-center" style="width:600px; height:300px;">
                    @if ($detail_item_course->LINK_MATERI === '-')
                        <p>Materi tidak tersedia untuk chapter ini</p>
                    @else
                    <button class="btn bg-white px-3 py-2 rounded-3 shadow fw-semibold" onclick="ShowDocument(this)">
                        <i class="bi bi-file-text me-2" style="font-size: 1.1rem;-webkit-text-stroke: 0.2px;"></i>
                        Show Document
                    </button>
                    @endif
                </div>
            </div>
            <script>
                function ShowDocument(e) {
                    $(e).hide();
                    const file = '<?= $detail_item_course->FILE ?>';
                    const materiLink = '<?= $detail_item_course->LINK_MATERI ?>'
                    var pptxRegex = /^https?:\/\/[\w.-]+\/[\w\/.-]+\.pptx(\?.*)?$/;
                    const fliphtmlRegex = /fliphtml5\.com/;
                    const googleDriveRegex = /^https?:\/\/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/;

                    if (!file && !materiLink) {
                        $('#document-frame').html('<p>Dokumen Tidak ditemukan hubungi Instruktur</p>');
                    } else if (pptxRegex.test(file)) {
                        $('#document-frame').html(
                            `<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${file}#toolbar=0&navpanes=0" style="width:600px; height:500px;" frameborder="0"></iframe>`
                        );
                    } else if (fliphtmlRegex.test(materiLink)) {
                        console.log("FlipHTML5 detected:", materiLink);
                        // Embed untuk FlipHTML
                        $('#document-frame').html(
                            `<div style="position:relative;padding-top:max(60%,324px);width:100%;height:0;">
                                <iframe style="position:absolute;border:none;width:100%;height:100%;left:0;top:0;"
                                src="${materiLink}"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" >
                                </iframe>
                            </div>`
                        );
                    } else if (googleDriveRegex.test(materiLink)) {
                        // Embed Google Drive PDF link
                        const fileId = materiLink.match(googleDriveRegex)[1];
                        const embedUrl = `https://drive.google.com/file/d/${fileId}/preview`;
                        $('#document-frame').html(
                            `<iframe src="${embedUrl}" style="width:600px; height:500px;" frameborder="0"></iframe>`
                        );
                    }else {
                        const link_file = file ? file : materiLink;
                        $('#document-frame').html(
                            `<iframe src="${link_file}#toolbar=0&navpanes=0" style="width:600px; height:500px;" frameborder="0" allowfullscreen="true"></iframe>`
                        );
                    }
                }
            </script>
        </section>
        @endif

        @if ($detail_item_course->LINK_YT != "-")
        <hr id="video-course-line">
        <section id="video-course">
            <?php
            $youtubePattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
            $googleDrivePattern = '/drive\.google\.com\/file\/d\/([^\/]+)\//i';
            $url = $detail_item_course->LINK_YT;
            ?>

            <div class="d-flex justify-content-center align-items-center mt-4 mb-4" id="video-frame">
                @if (preg_match($googleDrivePattern, $url, $matches))
                    <?php $fileId = $matches[1]; ?>
                    <iframe src="https://drive.google.com/file/d/{{ $fileId }}/preview" class="w-100" style="height: 512px;" frameborder="0" allowfullscreen></iframe>
                @elseif(preg_match($youtubePattern, $url, $matches))
                    <?php $videoId = $matches[1]; ?>
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen style="width:700px; height:400px;"></iframe>
                @elseif($url == "-")
                @else
                    <h6>Video cannot be opened. Contact the instructor for more information.</h6>
                @endif
            </div>
        </section>
        @endif
        <hr id="desc-course">
        <section id="desc-course">
            <h6 class="fw-semibold">Chapter Description :</h6>
            <p class="text-muted">
                <?= $detail_item_course->DESKRIPSI ?>
            </p>
        </section>
    </div>

    <?php if ($type == 1 && !empty($data_all_mapping) && $last_item[0]->ID_ITEM == $id_item) { ?>
        <div class="mx-4 my-4">
            <button class="btn btn-secondary mt-4 px-4 py-2 mb-3 rounded-3 shadow fw-semibold w-100" data-iditem="<?= $id_item ?>" data-status="2" data-type="1" onclick="NextItem(this)">
                Continue
            </button>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="mx-4 my-4">
        <h5><span class="text-danger">*</span>Nilai minimal lulus quiz : {{ $detail_item_course[0]->MIN_NILAI }}</h5>
        <?php if ($quiz_grade == NULL) {
            $no_soal = 0;
            foreach ($detail_item_course as $item) {
                $soal = explode(";", $item->PIL_JWB);
        ?>
                <h6 class="fw-semibold mt-5">Kuis :</h6>
                <div class="d-flex bg-white my-3 p-4 rounded-3 shadow fw-semibold">
                    <?= $item->SOAL ?>
                </div>
                <div class="my-4 d-flex d-lg-block flex-column">
                    <?php
                    $pilihan = ['a', 'b', 'c', 'd'];
                    $no = 0;
                    foreach ($soal as $soal_item) :
                        if (!empty(trim($soal_item))) {
                    ?>
                        <button class="btn btn-outline-dark me-3 mb-3 py-2 px-3 rounded-3 shadow fw-semibold"
                            data-value="<?= $pilihan[$no] ?>"
                            id="jwbn_<?= $item->ID_DETAIL . '' . ++$no ?>"
                            onclick="SelectJwbn<?= $item->ID_DETAIL . '' . $item->ORDER_LIST ?>(this)">
                            <?= $soal_item ?>
                        </button>
                    <?php
                        }
                    endforeach;
                    ?>

                    <input type="hidden" name="id_quiz" value="<?= $item->ID_QUIZ ?>">
                    <input type="hidden" name="id_detail[]" value="<?= $item->ID_DETAIL ?>">
                    <input type="hidden" name="jwbn[]">
                    <script>
                        $("#jwbn_<?= $item->ID_DETAIL . '1' ?>").trigger('click')

                        function SelectJwbn<?= $item->ID_DETAIL . '' . $item->ORDER_LIST ?>(e) {
                            $("#jwbn_<?= $item->ID_DETAIL . '1' ?>").removeClass("btn-secondary")
                            $("#jwbn_<?= $item->ID_DETAIL . '2' ?>").removeClass("btn-secondary")
                            $("#jwbn_<?= $item->ID_DETAIL . '3' ?>").removeClass("btn-secondary")
                            $('input[name="jwbn[]"]').eq(<?= $no_soal++ ?>).val($(e).data("value"))
                            $(e).addClass("btn-secondary")
                        }
                    </script>
                </div>
            <?php }
        } else if ($quiz_grade->NILAI >= $quiz_grade->MIN_NILAI) { ?>
            <div class="col" id="detail-item">
                <div class="py-5">
                    <div class="d-flex justify-content-center">
                        <img class="nav-link rounded-circle" src="https://img.freepik.com/free-vector/completed-concept-illustration_114360-3891.jpg" style="width: 40%;height:50%;background-size:cover"></img>
                    </div>
                    <div class="d-flex justify-content-center pt-4">
                        <h6>Anda Sudah Menyelesaikan Quiz dan Mendapatkan Nilai {{round($quiz_grade->NILAI)}}</h6>
                    </div>
                </div>
            </div>
            <?php if (!empty($data_all_mapping) && $last_item[0]->ID_ITEM == $id_item) { ?>
                <button class="btn btn-secondary mt-4 px-4 py-2 mb-3 rounded-3 shadow fw-semibold w-100" data-iditem="<?= $id_item ?>" data-status="2" data-type="2" onclick="NextItem(this)">
                    Continue
                </button>
            <?php } ?>
        <?php } else { ?>
            <div class="col" id="detail-item">
                <div class="py-5">
                    <div class="d-flex justify-content-center">
                        <img src="https://img.freepik.com/free-vector/hr-management-hiring-employees-people-cv_107791-11222.jpg" alt="Loader.gif" style="max-width: 50%;">
                    </div>
                    <div class="d-flex justify-content-center pt-4">
                        <h6>Anda Sudah Menyelesaikan Quiz dan Mendapatkan Nilai : <?= $quiz_grade->NILAI ?></h6>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($quiz_grade == NULL) { ?>
            <button class="btn btn-secondary px-4 py-2 mt-2 mt-lg-6 mb-3 rounded-3 shadow fw-semibold w-100" data-bs-toggle="modal" data-bs-target="#ShowConfirmSubmitKuis<?= $item->ID_ITEM ?>">
                Kumpulkan Kuis
            </button>
            <div class="modal fade" id="ShowConfirmSubmitKuis<?= $item->ID_ITEM ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-md">
                    <div class="modal-content px-3 py-3">
                        <div class="modal-header border-0">
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body d-flex flex-column align-items-center" style="margin-top:-3rem" id="body-detail">
                            <img class="nav-link rounded-circle" src="<?= url('assets/images/modal-img.svg') ?>" style="width: 80%;height:80%;background-size:cover">
                            </img>
                            <h5 class="fw-semibold text-center mt-3">Apakah anda Yakin Ingin Mengumpulkan Kuis ?
                            </h5>
                        </div>
                        <div class="modal-footer row mx-2 border-0" id="footer_modal_<?= $item->ID_ITEM ?>">
                            <button type="button" class="btn btn-danger rounded fw-semibold col" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-dark rounded fw-semibold col" onclick="submitKuis<?= $item->ID_ITEM ?>(this)">Submit</button>
                        </div>
                    </div>
                </div>
                <script>
                    function submitKuis<?= $item->ID_ITEM ?>(e) {
                        var id_detail = $('input[name="id_detail[]"]').map(function() {
                            return this.value;
                        }).get();

                        var pilih_jwbn = $('input[name="jwbn[]"]').map(function() {
                            return this.value;
                        }).get();

                        $("#body-detail").html('<div class="d-flex justify-content-center align-items-center h-100 mt-40"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>');
                        $("#footer_modal_<?= $item->ID_ITEM ?>").html("");
                        jQuery.ajax({
                            url: "<?= Request::segment(0) ?>/course/quiz/evaluation/",
                            type: "POST",
                            data: {
                                "id_quiz": $('input[name="id_quiz"]').val(),
                                "id_detail": id_detail,
                                "pilih_jwbn": pilih_jwbn
                            },
                            success: function(data) {
                                $("#footer_modal_<?= $item->ID_ITEM ?>").html('<button type="button" class="btn btn-danger rounded fw-semibold col" data-bs-dismiss="modal" data-iditem="<?= $item->ID_ITEM ?>" data-status="0" data-type="4" onclick="ShowDetailItem(this)">Close</button>')
                                $("#body-detail").html('<img class="nav-link rounded-circle" src="https://img.freepik.com/free-vector/completed-concept-illustration_114360-3891.jpg" style="width: 80%;height:80%;background-size:cover"></img><h6 class="fw-semibold text-center mt-3">Nilai Anda : ' + data + '</h6>');
                                $(e).hide()
                            }
                        });
                    }
                </script>
            </div>
        <?php } else if ($quiz_grade->NILAI < $quiz_grade->MIN_NILAI ?? 75) { ?>
            <button class="btn btn-secondary px-4 py-2 mb-3 rounded-3 shadow fw-semibold w-100" data-iditem="<?= $id_item ?>" data-status="0" data-type="3" onclick="ShowDetailItem(this)">
                Try The Quiz Again
            </button>
        <?php } ?>
    </div>
<?php } ?>
<script>
    function NextItem(e) {
        Swal.fire({
            title: 'Are you sure, you want continue?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Continue!'
        }).then((result) => {
            if (result.isConfirmed) {
                ShowDetailItem(e)
                location.reload()
            }
        })
    }

    // var videoFrame = document.getElementById("video-frame");
    // var loadingMessage = document.getElementById("loading-message");

    // videoFrame.addEventListener("load", function() {
    //     loadingMessage.classList.add('d-none')
    //     videoFrame.classList.remove('d-none')
    // });

    // videoFrame.addEventListener("error", function() {
    //     console.log("error")
    // });

    function openVideo() {

    }

    var initialSrc = $('#video-frame').attr('src');
    $('#YTModal').on('hidden.bs.modal', function() {
        $('#video-frame').attr('src', initialSrc);
    });
</script>
