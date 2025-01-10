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
<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <form action="/profile/academic/change" id="academic-form" method="POST">
        @csrf
        <h3 class="fw-bold pb-5" style="color:#5580E9">Academic Data</h3>
        <h5 class="text-black ps-1">University Name</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="univ" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama Universitas" value="<?= !empty($academic->UNIV) ? $academic->UNIV : ''  ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">NIM</h5>
        <div class="my-3 float-label-control">
            <input type="number" name="nim" class="form-control input-text woocommerce-Input woocommerce-Input--text number" placeholder="NIM" value="<?= !empty($academic->NIM) ? $academic->NIM : '' ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Study Program</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="study" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama" value="<?= !empty($academic->STUDY) ? $academic->STUDY : '' ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Degree</h5>
        <div class="my-3 float-label-control">
            <select name="degree" class="form-select woocommerce-Input woocommerce-Input--text" required>
                <option value="" <?= !empty($academic->DEGREE) ? 'selected' : "" ?>>--Select Degree--</option>
                <option value="D3" <?= !empty($academic->DEGREE) ? ($academic->DEGREE == "D3" ? 'selected' : "")
                                        : '' ?>>Associate Degree</option>
                <option value="S1" <?= !empty($academic->DEGREE) ? ($academic->DEGREE == "S1" ? 'selected' : "")
                                        : '' ?>>Bachelor Degree</option>
                <option value="S2" <?= !empty($academic->DEGREE) ? ($academic->DEGREE == "S2" ? 'selected' : "")
                                        : '' ?>>Master Degree</option>
            </select>
        </div>
        <h5 class="text-black ps-1 mt-4">Semester</h5>
        <div class="my-3 float-label-control">
            <input type="number" name="sem" class="form-control input-text woocommerce-Input woocommerce-Input--text number" placeholder="Semester" value="<?= !empty($academic->SEMESTER) ? $academic->SEMESTER : '' ?>">
            <span><small class="text-danger">* If you graduated, just left semester field empty</small></span>
        </div>

        <button type="button" class="btn btn-primary rounded rounded-4 fw-semibold py-2 w-100 mt-5 edit" style="--bs-btn-padding-x: 4.5rem;">Save</button>
    </form>
</div>

<!-- (session->flashdata('resp_msg'));  -->

<script>
    $(function() {
        $(".number").on("keypress keyup blur", function(event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    });
    const edit = document.querySelector(".edit");
    edit.addEventListener('click', function() {
        $('#academic-form').submit()
    })
</script>
@endsection