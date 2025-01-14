@extends('template_guest.profile.profile_template')
@section('content')
<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-5" style="color:#AD0B0B">Supporting Document</h3>

    <section id="cv-section">
        <div class="dropzone-container">
            <div class="row col-md-12">
                <div class="col-md-8">
                    <h5 class="text-black ps-1">Curriculum Vitae </h5>
                    <h6 class="text-muted ps-1 pt-1">Upload in PDF format with a maximum size of 2 MB</h6>
                </div>
                <div class="col-md-4 d-flex align-items-end btn-container">
                    <button type="button" class="btn btn-danger rounded-4 fw-semibold w-100 edit-cancel mb-2 d-none">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-4 fw-semibold w-100 edit-file mb-2">Change File</button>
                </div>
            </div>
        </div>
        <div id="preview-data" class="d-none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <object style="width: 100%; height: 309px;" data="<?= !empty($document->CV) ? $document->CV : '' ?>">
                                Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
                            </object>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="input-data" class="d-none">
            <form action="/profile/document/change" method="post" enctype="multipart/form-data">
                @csrf
                <input id="input-file1" name="file_cv" type="file" accept="application/pdf" />
                <button type="submit" title="Upload selected files" id="upload-button1" style="display: none;"
                    class="btn btn-primary rounded-1 fw-semibold w-7 edit-file mb-2" tabindex="500"><i
                        class="bi-upload"></i> <span class="hidden-xs">Upload</span></button>
            </form>
        </div>
    </section>
    <hr>
    <section id="porto-section">
        <div class="dropzone-container">
            <div class="row col-md-12">
                <div class="col-md-8">
                    <h5 class="text-black ps-1 mt-4">Portfolio</h5>
                    <h6 class="text-muted ps-1 pt-1">Upload in PDF format with a maximum size of 2 MB </h6>
                </div>
                <div class="col-md-4 d-flex align-items-end btn-container">
                    <button type="button" class="btn btn-danger rounded-4 fw-semibold w-100 edit-cancel mb-2 d-none">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-4 fw-semibold w-100 edit-file mb-2">Change File</button>
                </div>
            </div>
        </div>
        <div id="preview-data" class="d-none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <object style="width: 100%; height: 309px;" data="<?= !empty($document->PORTOFOLIO) ? $document->PORTOFOLIO : '' ?>">
                                Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
                            </object>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="input-data" class="d-none">
            <form action="/profile/document/change" method="post" enctype="multipart/form-data">
                @csrf
                <input id="input-file2" name="file_porto" type="file" accept="application/pdf" />
                <button type="submit" title="Upload selected files" id="upload-button2" style="display: none;"
                    class="btn btn-primary rounded-1 fw-semibold w-7 edit-file mb-2" tabindex="500"><i
                        class="bi-upload"></i> <span class="hidden-xs">Upload</span></button>
            </form>
        </div>
    </section>
    <hr>
    <section id="cert-section">
        <div class="dropzone-container">
            <div class="row col-md-12">
                <div class="col-md-8">
                    <h5 class="text-black ps-1 mt-4">Certificates/Supporting Documents</h5>
                    <h6 class="text-muted ps-1 pt-1">Upload in PDF format with a maximum size of 2 MB </h6>
                </div>
                <div class="col-md-4 d-flex align-items-end btn-container">
                    <button type="button" class="btn btn-danger rounded-4 fw-semibold w-100 edit-cancel mb-2 d-none">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-4 fw-semibold w-100 edit-file mb-2">Change File</button>
                </div>
            </div>
        </div>
        <div id="preview-data" class="d-none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php $sertif = explode(';', !empty($document->SERTIFIKAT) ? $document->SERTIFIKAT : '');
                        foreach ($sertif as $link) { ?>
                            <div class="col-md-4">
                                <object style="width: 100%; height: 309px;" data="<?= $link ?>">
                                    Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
                                </object>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="input-data" class="d-none">
            <form action="/profile/document/change" method="post" enctype="multipart/form-data">
                @csrf
                <input id="input-file3" name="file_cert" type="file" accept="application/pdf" multiple />
                <button type="submit" title="Upload selected files" id="upload-button3" style="display: none;"
                    class="btn btn-primary rounded-1 fw-semibold w-7 edit-file mb-2" tabindex="500"><i
                        class="bi-upload"></i> <span class="hidden-xs">Upload</span></button>
            </form>
        </div>
    </section>
    <hr>
    <section id="recom-letter-section">
        <div class="dropzone-container">
            <div class="row col-md-12">
                <div class="col-md-8">
                    <h5 class="text-black ps-1 mt-4">University Recommendation Letter</h5>
                    <h6 class="text-muted ps-1 pt-1">Upload in PDF format with a maximum size of 2 MB </h6>
                </div>
                <div class="col-md-4 d-flex align-items-end btn-container">
                    <button type="button" class="btn btn-danger rounded-4 fw-semibold w-100 edit-cancel mb-2 d-none">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-4 fw-semibold w-100 edit-file mb-2">Change File</button>
                </div>
            </div>
        </div>
        <div id="preview-data" class="d-none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <object style="width: 100%; height: 309px;" data="<?= !empty($document->SURAT_RECOM) ? $document->SURAT_RECOM : '' ?>">
                                Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
                            </object>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="input-data" class="d-none">
            <form action="/profile/document/change" method="post" enctype="multipart/form-data">
                @csrf
                <input id="input-file4" name="file_recom" type="file" accept="application/pdf" />
                <button type="submit" title="Upload selected files" id="upload-button4" style="display: none;"
                    class="btn btn-primary rounded-1 fw-semibold w-7 edit-file mb-2" tabindex="500"><i
                        class="bi-upload"></i> <span class="hidden-xs">Upload</span></button>
            </form>
        </div>
    </section>
</div>

<!-- $this->session->flashdata('resp_msg');  -->

<style>
    .btn-file {
        overflow: hidden;
        cursor: pointer;
    }

    .btn-outline-secondary {
        --bs-btn-color: #6178ff;
        --bs-btn-border-color: #6178ff;
        --bs-btn-hover-color: #FFF;
        --bs-btn-hover-bg: #6178ff;
        --bs-btn-hover-border-color: #f5f5f5;
        --bs-btn-focus-shadow-rgb: 245, 245, 245;
        --bs-btn-active-color: #000;
        --bs-btn-active-bg: #f5f5f5;
        --bs-btn-active-border-color: #f5f5f5;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #f5f5f5;
        --bs-btn-disabled-bg: transparent;
        --bs-btn-disabled-border-color: #f5f5f5;
        --bs-gradient: none;
    }

    .close {
        margin-right: 0.07rem;
        margin-left: 0.07rem;
        margin-bottom: 0.5rem;
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid #f72d2d;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        cursor: pointer;
        text-transform: none;
        overflow: visible;
        outline: none;
        border-radius: 50%;
        line-height: 20px !important;
        background-color: #f68686;
        color: #fff;
    }

    .close:hover {
        background-color: #c82333;
        border-color: #c82333;
        color: #fff;
        text-decoration: none;
    }

    .close:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
        text-decoration: none;
    }
</style>

<script>
    initFileUploader('#cv-section', 1, 'cv')
    initFileUploader('#porto-section', 1, 'porto')
    initFileUploader('#recom-letter-section', 1, 'recom')
    initFileUploader('#cert-section', 1, 'cert')

    document.getElementById('input-file1').addEventListener('change', function() {
        const uploadButton = document.getElementById('upload-button1');
        if (this.files.length > 0) {
            uploadButton.style.display = 'inline-block';
        } else {
            uploadButton.style.display = 'none';
        }
    });
    document.getElementById('input-file2').addEventListener('change', function() {
        const uploadButton2 = document.getElementById('upload-button2');
        uploadButton2.style.display = this.files.length > 0 ? 'inline-block' : 'none';
    });

    document.getElementById('input-file3').addEventListener('change', function() {
        const uploadButton3 = document.getElementById('upload-button3');
        uploadButton3.style.display = this.files.length > 0 ? 'inline-block' : 'none';
    });

    document.getElementById('input-file4').addEventListener('change', function() {
        const uploadButton4 = document.getElementById('upload-button4');
        uploadButton4.style.display = this.files.length > 0 ? 'inline-block' : 'none';
    });

    function initFileUploader(sectioId, limitFile, type) {
        $(document).ready(function() {
            $(sectioId + " #input-file").fileinput({
                browseClass: "float-right btn btn-primary btn-md",
                captionClass: "me-2 rounded",
                allowedFileExtensions: ['pdf'],
                maxFileSize: 2048,
                layoutTemplates: {
                    actionDelete: '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}>{removeIcon}</button>\n',
                },
                maxFileCount: limitFile
            })
        });

        if (type == 'cv') {
            <?= !empty($document->CV) ? ("
                $(sectioId + ' .btn-container').removeClass('d-none')
                $(sectioId + ' #preview-data').removeClass('d-none')
                $(sectioId + ' #input-data').addClass('d-none')"
            ) : ("
                $(sectioId + ' .btn-container').addClass('d-none')
                $(sectioId + ' #preview-data').addClass('d-none')
                $(sectioId + ' #input-data').removeClass('d-none')"
            ) ?>
        } else if (type == 'porto') {
            <?= !empty($document->PORTOFOLIO) ? ("
                $(sectioId + ' .btn-container').removeClass('d-none')
                $(sectioId + ' #preview-data').removeClass('d-none')
                $(sectioId + ' #input-data').addClass('d-none')"
            ) : ("
                $(sectioId + ' .btn-container').addClass('d-none')
                $(sectioId + ' #preview-data').addClass('d-none')
                $(sectioId + ' #input-data').removeClass('d-none')"
            ) ?>
        } else if (type == 'cert') {
            <?= !empty($document->SERTIFIKAT) ? ("
                $(sectioId + ' .btn-container').removeClass('d-none')
                $(sectioId + ' #preview-data').removeClass('d-none')
                $(sectioId + ' #input-data').addClass('d-none')"
            ) : ("
                $(sectioId + ' .btn-container').addClass('d-none')
                $(sectioId + ' #preview-data').addClass('d-none')
                $(sectioId + ' #input-data').removeClass('d-none')"
            ) ?>
        } else if (type == 'recom') {
            <?= !empty($document->SURAT_RECOM) ? ("
                $(sectioId + ' .btn-container').removeClass('d-none')
                $(sectioId + ' #preview-data').removeClass('d-none')
                $(sectioId + ' #input-data').addClass('d-none')"
            ) : ("
                $(sectioId + ' .btn-container').addClass('d-none')
                $(sectioId + ' #preview-data').addClass('d-none')
                $(sectioId + ' #input-data').removeClass('d-none')"
            ) ?>
        }

        $(sectioId + ' .edit-file').click(function() {
            $(this).toggleClass('d-none');
            $(sectioId + ' .edit-cancel').toggleClass('d-none')
            $(sectioId + ' #preview-data').addClass('d-none')
            $(sectioId + ' #input-data').removeClass('d-none')
        })
        $(sectioId + ' .edit-cancel').click(function() {
            $(this).toggleClass('d-none');
            $(sectioId + ' .edit-file').toggleClass('d-none')
            $(sectioId + ' #preview-data').removeClass('d-none')
            $(sectioId + ' #input-data').addClass('d-none')
        })
    }
</script>
@endsection