<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title"><?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('dashboard') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Home</a>
                <span class="breadcrumb-item active"><?= $title ?></span>
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
                    <label class="card-title" style="font-size: 20px">Promo</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" onclick="addModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Add Promo</button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Discount</th>
                            <th>Kuota</th>
                            <th>Expired Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($promo as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->PROMO_NAME ?></td>
                                <td><?= $item->AMMOUNT ?></td>
                                <td><?= $item->KUOTA ?></td>
                                <td><?= $item->EXP_DATE ?></td>
                                <td>
                                    <button type="button"
                                        onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-primary waves-effect waves-light">
                                        <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button"
                                        onclick="opendeleteModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-danger waves-effect waves-light">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
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

{{-- Start Modal Add blom --}}
<div class="modal" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Promo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="promo/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Promo Name<span class="text-danger">*</span></label>
                        <input placeholder="Promo Name" type="text" name="promo_name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Discount<span class="text-danger">*</span></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="unit" id="inlineRadio1"
                                value="persen">
                            <label class="form-check-label" for="inlineRadio1">Persentase</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="unit" id="inlineRadio2"
                                value="nominal">
                            <label class="form-check-label" for="inlineRadio2">Nominal</label>
                        </div>
                        <div class="input_discount"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kuota<span class="text-danger">*</span></label>
                        <input placeholder="ex: 100" type="number" name="kuota" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Discount For<span class="text-danger">*</span></label>
                        <select name="promo_for" id="promo_for" class="form-control">
                            <option value="0">All</option>
                            <option value="1">Course's</option>
                            <option value="2">Event's</option>
                            <option value="3">Book's</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Category User<span class="text-danger">*</span></label>
                        <select name="category_user" id="category_user" class="form-control">
                            <option value="0">All</option>
                            <option value="1">Instructor</option>
                            <option value="2">Student</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Expired Date<span class="text-danger">*</span></label>
                        <input type="datetime-local" name="exp_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update --}}
<div class="modal" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Promo Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="promo/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="up_id_promo" value="" readonly>
                    <div class="form-group mb-3">
                        <label>Promo Name<span class="text-danger">*</span></label>
                        <input placeholder="Promo Name" type="text" name="up_promo_name" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Discount <span class="text-danger">*</span></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="up_unit"
                                id="inlineRadioModal1" value="persen">
                            <label class="form-check-label" for="inlineRadioModal1">Persentase</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="up_unit"
                                id="inlineRadioModal2" value="nominal">
                            <label class="form-check-label" for="inlineRadioModal2">Nominal</label>
                        </div>
                        <!-- Tempat untuk input discount di dalam modal -->
                        <div class="input_discount_modal mt-3"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Discount For<span class="text-danger">*</span></label>
                        <select name="up_promo_for" id="up_promo_for" class="form-control">
                            <option value="0">All</option>
                            <option value="1">Course's</option>
                            <option value="2">Event's</option>
                            <option value="3">Book's</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Expired Date<span class="text-danger">*</span></label>
                        <input type="datetime-local" name="up_exp_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete blom --}}
<div class="modal" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="promo/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Do you want to delete this category ?</p>
                    <input type="hidden" name="id_promo" value="" readonly>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}

<script>
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
        $('#addModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData);

        // Set radio button checked status
        if (data.UNIT == 'persen') {
            $('#inlineRadioModal1').prop('checked', true);
        } else if (data.UNIT == 'nominal') {
            $('#inlineRadioModal2').prop('checked', true);
        }

        // Fungsi untuk mengisi input berdasarkan pilihan radio button
        function fillInput() {
            var selectedValue = $('input[name="up_unit"]:checked').val();
            var discountDivModal = document.querySelector('.input_discount_modal');
            discountDivModal.innerHTML = ''; // Kosongkan isi dari div input_discount_modal

            var inputModal = document.createElement('input');
            inputModal.type = 'number';
            inputModal.name = 'up_discount';
            inputModal.className = 'form-control';
            inputModal.placeholder = 'Enter discount value here';
            inputModal.required = true;

            // Tetapkan nilai input berdasarkan data awal
            inputModal.value = data.AMMOUNT || ''; // Tetapkan nilai jika data.AMMOUNT ada

            if (selectedValue === 'persen') { // Jika pilihan Persentase
                inputModal.min = 0; // Nilai minimum untuk Persentase
                inputModal.max = 100; // Nilai maksimum untuk Persentase
            } else {
                inputModal.removeAttribute('min');
                inputModal.removeAttribute('max');
            }

            // Tambahkan elemen input ke dalam div input_discount_modal
            discountDivModal.appendChild(inputModal);
        }

        // Fungsi untuk menangani perubahan pada radio button
        function unit() {
            var radios = document.querySelectorAll('input[name="up_unit"]');

            radios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    fillInput(); // Panggil fungsi untuk mengisi input berdasarkan perubahan
                });
            });
        }

        // Panggil fungsi unit untuk mengatur event listener
        unit();

        // Panggil fungsi untuk mengisi input saat modal dibuka
        fillInput();

        // Set nilai input lainnya
        $('input[name="up_id_promo"]').val(data.ID_PROMO);
        $('input[name="up_promo_name"]').val(data.PROMO_NAME);
        $('select[name="up_promo_for"]').val(data.PROMO_FOR);
        $('input[name="up_exp_date"]').val(data.EXP_DATE)
        $('#updateModal').modal('show');
    }

    console.log();


    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="id_promo"]').val(data.ID_PROMO)
        $('#deleteModal').modal('show')
    }
</script>
