<div class="mb-5">
    <div class="container d-grid d-md-flex p-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= url('assets/images/login-1.png') ?>" class="float-end d-block img-fluid rounded-5 rounded-start h-auto ">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 absolute-auth" id="formLogin">
                <div class="d-flex ps-4 flex-column justify-content-center h-100">
                    <h4 class="ps-1 fw-semibold">Create New Password</h4>
                    <h5 class="fw-normal mt-5">Your new password must be different from previous used passwords</h5>
                    <form class="fw-normal" action="<?= url('resetPassword') ?>" method="POST">
                    <input type="hidden" value="<?= $token->ID_USER?>" name="id_user">
                    @csrf
                        <div class="input-group my-4">
                            <input type="password" class="form-control border-bottom border-0 shadow-none rounded-0 ps-1" id="registerPassword1" placeholder="Password" name="password" aria-describedby="passwordHelp" required>
                            <span class="align-self-center fw-semibold" id="togglePassword1" style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i class="far fa-eye fs-4"></i></span>
                        </div>
                        <div class="input-group my-4 pb-lg-3">
                            <input type="password" class="form-control border-bottom border-0 shadow-none rounded-0 ps-1" id="registerPassword2" placeholder="Confirm Password" aria-describedby="passwordHelp" required>
                            <span class="align-self-center fw-semibold" id="togglePassword2" style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i class="far fa-eye fs-4"></i></span>
                        </div>
                        <div class="my-4 mt-6">
                            <button type="submit" class="btn btn-primary btb-main-2 w-100 rounded-3 fw-semibold py-2 text-black border-0">Reset
                                Password</button>
                        </div>
                        <div class="my-4 text-center">
                            <a href="<?= url('login') ?>" class="text-decoration-none text-black">Back
                                to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    }

    password.onchange = validatePassword;
    password2.onkeyup = validatePassword;
    document.addEventListener('DOMContentLoaded', function () {
        @if (session()->has('succ_msg'))
            Swal.fire({
                    icon: 'success',
                    title: '{{ session('succ_msg') }}'
                })
        @endif
        @if (session()->has('resp_msg'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('resp_msg') }}'
            });
        @endif
    });
</script>
