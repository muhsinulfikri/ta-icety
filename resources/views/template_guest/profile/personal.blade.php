@extends('template_guest.profile.profile_template')
@section('content')
<style>
    .form-select {
        border: 2px solid #F5F5F5;
        height: 55px;
        padding-left: 20px;
        background-color: #F5F5F5;
    }
</style>
<div class="col ms-0 ms-md-4 mt-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">

    <form action="profile/update" method="POST" enctype="multipart/form-data" id="form-profile">
        @csrf
        <div class="nav-link rounded-circle">
            <input type="file" id="file" name="foto_profile" accept="image/jpeg, image/png" style="display: none;" readonly>
            <button type="button" id="choose-button" style="border: none; background-color: transparent;">
                <img class="nav-link rounded-circle mb-2" src="<?= (!empty($data_personal->FOTO_PROFILE) ? $data_personal->FOTO_PROFILE : 'assets/images/person-circle.svg') ?>" id="preview" style="height:150px; width:150px; object-fit: cover;" />
            </button>
        </div>
        <h3 class="fw-bold py-4" style="color:#AD0B0B">Personal Data</h3>
        <h5 class="text-black ps-1">Email</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="email" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Email" value="<?= $data_personal->EMAIL ?>" aria-describedby="emailHelp" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Nama</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="name_user" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama" value="<?= $data_personal->NAME ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Phone Number</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="no_hp" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Number" value="<?= $data_personal->TELP ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Gender</h5>
        <div class="my-3 float-label-control">
            <select class="form-select woocommerce-Input woocommerce-Input--text" disabled>
                <option value="Laki-laki" <?= ($data_personal->JK == "Laki-laki") ? "selected" : "" ?>>
                    Male</option>
                <option value="Perempuan" <?= ($data_personal->JK == "Perempuan") ? "selected" : "" ?>>
                    Female</option>
            </select>
        </div>
        <input type="hidden" name="jk" id="setJK" value="<?= $data_personal->JK ?>">
    </form>

    <button type="submit" class="btn btn-primary rounded rounded-4 fw-semibold py-2 w-100 mt-5 edit" style="--bs-btn-padding-x: 4.5rem;">Edit</button>
</div>

<script>
    const edit = document.querySelector(".edit");
    if (edit.innerHTML == "Edit") {
        $('#choose-button').css('cursor', 'default')
    }
    edit.addEventListener('click', function() {
        $('.form-control').prop('readonly', (i, v) => !v);
        $('.form-select').prop('disabled', (i, v) => !v);
        edit.innerHTML = edit.innerHTML === "Edit" ? "Save" : "Edit";
        $('#choose-button').css('cursor', 'pointer')
        if (edit.innerHTML == "Edit") {
            $('#form-profile').submit()
        }
    })

    $('.form-select').change(function() {
        $('#setJK').val($(this).val())
    })

    $(document).ready(function() {
        $(".phone").inputmask({
            "mask": "9999-9999-9999",
            // "placeholder": " "
        });
        $(".nik").inputmask({
            "mask": "9999999999999999",
            // "placeholder": " "
        });
        $(function() {
            $(".date").datepicker({
                dateFormat: 'dd MM yy'
            });
            $(".date").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", "2000-12-30"));
        });
    });

    $('#choose-button').click(function() {
        if (edit.innerHTML == "Save") {
            $('#file').click();
        } else {
            $('#choose-button').css('cursor', 'default')
        }
    });

    $('#file').change(function() {
        var file = this.files[0];
        if (file.type.match(/image.*/)) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var dataURL = event.target.result;
                $('#preview').attr('src', dataURL);
            };
            reader.readAsDataURL(file);
        } else {
            $('#preview').empty();
        }
    });
</script>
@endsection