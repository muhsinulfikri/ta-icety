<!-- Register -->
<div class="mb-5">
    <div class="container d-grid d-md-flex p-0 p-lg-4 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= asset('assets/images/login-1.png') ?>"
                    class="float-end d-block img-fluid rounded-5 rounded-start h-auto " alt="Gambar nih bos">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 absolute-auth" id="formLogin">
                <div class="d-flex ps-md-4 flex-column justify-content-center h-100">
                    <h4 class="ps-1 fw-semibold mt-5">Register as User</h4>
                    <form class="fw-normal" action="<?= url('register/store') ?>" method="POST">
                        @csrf
                        <div id="form-1">

                            <div class="my-4 float-label-control">
                                <input type="text"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="exampleInputEmail1" placeholder="Name" name="name" aria-describedby=""
                                    required>
                            </div>
                            <div class="my-4 float-label-control">
                                <input type="email"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="exampleInputEmail1" placeholder="Email address" name="email"
                                    aria-describedby="emailHelp" required>
                            </div>
                            <div class="my-4 float-label-control">
                                <select name="category_user" id="category_user" class="form-control form-select pe-5" style="color: #999999" required>
                                    <option value="" disabled selected>Choose your Category</option>
                                    <option value="2">Perusahaan</option>
                                    <option value="3">Umum</option>
                                    <option value="4">Institusi Pemerintah</option>
                                    <option value="5">Institusi Pendidikan</option>
                                    <option value="6">Organisasi Nirlaba</option>
                                </select>
                            </div>
                            <div class="my-4 float-label-control">
                                <input type="text" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputAgency" placeholder="Name of your Perusahaan/Institusi" name="agency" aria-describedby="" required>
                            </div>
                            <div class="my-4 float-label-control">
                                <input type="text" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Phone Number" name="telp" aria-describedby="" required>
                            </div>
                            <div class="input-group my-4">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text rounded-3"
                                    id="registerPassword1" placeholder="Create password" name="password"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword1"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                            <div class="input-group my-4 pb-lg-3">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text rounded-3"
                                    id="registerPassword2" placeholder="Confirm Password"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword2"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                            <div class="col-md-12 mr-2 px-md-1 mt-1">
                                <button type="submit"
                                    class="btn btn-primary btn-main-2 w-100 rounded-3 fw-semibold py-2 text-black border-0"
                                    id="next-2">Register</button>
                            </div>
                            <div class="my-4 text-center">
                                <span>Have an account? <a href="<?= url('login') ?>"
                                        class="text-decoration-none fw-bold text-black">Login</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Register -->
<script>
    var x = document.getElementById("form-1");
    var y = document.getElementById("form-2");

    const togglePassword1 = document.querySelector("#togglePassword1");
    const password = document.querySelector("#registerPassword1");

    const togglePassword2 = document.querySelector("#togglePassword2");
    const password2 = document.querySelector("#registerPassword2");

    function funcNext() {
        x.classList.add("d-none");
        y.classList.remove("d-none");
    }

    function funcPrev() {
        y.classList.add("d-none");
        x.classList.remove("d-none");
    }

    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if (session()->has('error_msg'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('error_msg') }}'
            });
        @endif
    });


    togglePassword1.addEventListener("click", function(e) {
        if (password.value) {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            togglePassword1.innerHTML = password.getAttribute("type") === "password" ?
                "<i class='far fa-eye fs-4'></i>" :
                "<i class='far fa-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });

    togglePassword2.addEventListener("click", function(e) {
        if (password2.value) {
            const type = password2.getAttribute("type") === "password" ? "text" : "password";
            password2.setAttribute("type", type);
            togglePassword2.innerHTML = password2.getAttribute("type") === "password" ?
                "<i class='far fa-eye fs-4'></i>" :
                "<i class='far fa-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });

    function validatePassword() {
        if (password.value != password2.value) {
            password2.setCustomValidity("Passwords Don't Match");
        } else {
            password2.setCustomValidity('');
        }

        if (password.value.length < 8 && password2.value.length < 8) {
            password.setCustomValidity("Passwords must contain at least 8 characters");
        } else {
            password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    password2.onkeyup = validatePassword;

    document.getElementById("category_user").addEventListener("change", function() {
        if (this.value) {
            this.style.color = "black";
        } else {
            this.style.color = "#999999";
        }
    });

    $(document).ready(function () {
        $("#category_user").change(function () {
            let agencyInput = $("#exampleInputAgency");
            let agencyField = agencyInput.closest(".float-label-control");

            if ($(this).val() === "3") { // Jika "Umum" dipilih
                agencyField.hide();
                agencyInput.removeAttr("required");
            } else {
                agencyField.show();
                agencyInput.attr("required", "required");
            }
        });
    });
</script>
