<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Trial Code</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('dashboard') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Home</a>
                <span class="breadcrumb-item active">Trial Code</span>
            </nav>
        </div>
    </div>
    <?php if (!empty(session('err_msg'))) { ?>
        <div class="alert alert-danger">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span><?= session('err_msg') ?></span>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty(session('succ_msg'))) { ?>
        <div class="alert alert-success">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span><?= session('succ_msg') ?></span>
            </div>
        </div>
    <?php } ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <label class="card-title" style="font-size: 20px">Trial Code</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" onclick="addModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Add Code
                        </button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Aktivitas</th>
                            <th>Kategori</th>
                            <th>Kode</th>
                            <th>Jumlah Kode</th>
                            <th>Kedaluwarsa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>
                        @foreach ($redeem as $item)
                        <?php $number++; ?>
                        <tr>
                            <td><?= $number ?></td>
                            <td><?= $item->TITLE_ACTIVITY ?></td>
                            <td><?= $item->CAT ?></td>
                            <td><?= $item->LIST_KODE ?></td>
                            <td><?= $item->TOTAL_CODE ?></td>
                            <td><?= $item->EXPIRED_DATE ?></td>
                            <td>
                                <button type="button" class="btn btn-success" onclick="generateExcell(`<?= url('redeem-code/excell') ?>/${btoa('<?= $item->ID_ACTIVITY ?>')}`)">
                                    <i class="far fa-file-excel font-size-16 align-middle"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Content Wrapper END -->
<div class="modal" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Promo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="main-form" action="<?= url('redeem-code/submit') ?>" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Course<span class="text-danger">*</span></label>
                        <select name="id_course" id="id_course" class="form-control" required>
                            <option value="">-- Choose Course --</option>
                            @foreach($activity as $item)
                            <option value="<?= $item->ID_ACTIVITY ?>"><?= $item->TITLE_ACTIVITY ?></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Trial For<span class="text-danger">*</span></label>
                        <select name="trial_for" id="trial_for" class="form-control" required>
                            <option value="">-- Choose Trial For --</option>
                            @foreach($trial_for as $item)
                            <option value="<?= $item->ID_CATEGORY_USER ?>"><?= $item->NAME_CATEGORY_USER ?></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Code<span class="text-danger">*</span></label>
                        <input placeholder="Count how many this code generated" type="text" name="total_code" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Expired Date<span class="text-danger">*</span></label>
                        <input type="date" name="exp_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success ml-2",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    $('#dtTable').DataTable()

    document.querySelectorAll('input[name="unit"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var discountDiv = document.querySelector('.input_discount');
            discountDiv.innerHTML = ''; // Kosongkan isi dari div input_discount

            var input = document.createElement('input');
            input.type = 'number';
            input.name = 'discount';
            input.className = 'form-control';
            input.placeholder = 'Enter discount value here';
            input.required = true;

            if (this.value === 'persen') { // Jika pilihan Persentase
                input.min = 1; // Nilai minimum untuk Persentase
                input.max = 100; // Nilai maksimum untuk Persentase
            }

            // Tambahkan elemen input ke dalam div input_discount
            discountDiv.appendChild(input);
        });
    });

    function addModal() {
        $('#modal').modal('show')
    }

    function submitForm() {
        var isValid = true;
        var form = $('#main-form')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            isValid = false;
            return false;
        }

        if (isValid) {
            $('#modal').modal('hide')
            Swal.fire({
                title: "Saving...",
                html: "Please wait, the system is still saving...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            form.submit();
        }
    }

    function generateExcell(url) {
        Swal.fire({
            title: 'Sedang Membuat Excell ...',
            html: `Excell sedang dibuat mohon untuk bersabar
                <br>
                <div style="background-color: transparent; width: 100px; height: 100px; display: flex; transform: translate(180%, 0%); justify-content: center; align-items: center;">
                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                        <path fill="#3f87f5" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                        </path>
                    </svg>
                </div>`,
            timerProgressBar: false,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false
        })

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    showToast('Laporan gagal di generate. Mohon cek kembali jaringan anda.');
                }
                const contentDisposition = response.headers.get('content-disposition');
                const filenameMatch = contentDisposition.match(/filename="(.+)"/);

                if (filenameMatch && filenameMatch.length > 1) {
                    const originalFilename = filenameMatch[1];
                    return response.blob().then(blob => {
                        return {
                            blob,
                            originalFilename
                        };
                    });
                } else {
                    showToast('Laporan gagal di generate. Gagal mendapatkan nama original file.');
                }
            })
            .then(({
                blob,
                originalFilename
            }) => {
                const blobUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = originalFilename;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();

                URL.revokeObjectURL(blobUrl);

                Swal.close()
            })
            .catch(error => {
                Swal.close()
                showToast('Laporan gagal di generate. Tidak ada data atau sistem sedang mengalami error.');
            });

        function showToast(msg) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: msg,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

        }
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="id_promo"]').val(data.ID_PROMO)
        $('#deleteModal').modal('show')
    }
</script>