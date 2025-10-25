<!-- Register -->
{{-- <div class="mb-5">
    <div class="container d-grid d-md-flex p-0 p-lg-4 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= asset('assets/images/login-1.png') ?>"
                    class="float-end d-block img-fluid rounded-5 rounded-start h-auto " alt="Gambar nih bos">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 absolute-auth" id="formLogin">
                <div class="d-flex ps-md-4 flex-column justify-content-center h-100">
                    <h4 class="ps-1 fw-semibold mt-5">{{ __('register.txt_rau') }}</h4>
                    <form class="fw-normal" action="<?= url('register/store') ?>" method="POST">
                        @csrf
                        <div id="form-1">

                            <div class="my-4 float-label-control">
                                <input type="text"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="exampleInputEmail1" placeholder="{{ __('register.txt_name') }}" name="name" aria-describedby=""
                                    required>
                            </div>
                            <div class="my-4 float-label-control">
                                <input type="email"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="exampleInputEmail1" placeholder="{{ __('register.txt_email') }}" name="email"
                                    aria-describedby="emailHelp" required>
                            </div>
                            <div class="my-4 float-label-control">
                                <select name="category_user" id="category_user" class="form-control form-select pe-5" style="color: #999999" required>
                                    <option value="" disabled selected>{{ __('register.txt_category') }}</option>
                                    <option value="2">{{ __('register.txt_company') }}</option>
                                    <option value="3">{{ __('register.txt_umum') }}</option>
                                    <option value="4">{{ __('register.txt_pemerintah') }}</option>
                                    <option value="5">{{ __('register.txt_pendidikan') }}</option>
                                    <option value="6">{{ __('register.txt_nirlaba') }}</option>
                                </select>
                            </div>
                            <div class="my-4 float-label-control">
                                <input type="text" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputAgency" placeholder="{{ __('register.txt_institution') }}" name="agency" aria-describedby="" required>
                            </div>
                            <div class="my-4 float-label-control">
                                <input type="number" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="{{ __('register.txt_number') }}" name="telp" aria-describedby="" required>
                            </div>
                            <div class="input-group my-4">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text rounded-3"
                                    id="registerPassword1" placeholder="{{ __('register.txt_password') }}" name="password"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword1"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                            <div class="input-group my-4 pb-lg-3">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text rounded-3"
                                    id="registerPassword2" placeholder="{{ __('register.txt_confirm') }}"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword2"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                            <div class="mt-4 my-3">
                                <div class="slidercaptcha card" id="card-captcha">
                                    <div class="card-header">
                                        <span>{{ __('register.txt_captcha_reg') }}</span>
                                    </div>
                                    <div class="card-body" id="body-captcha">
                                        <div id="captcha"></div>
                                    </div>
                                </div>
                                <div id="checkmark" class="checkmark" style="display: none">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                        <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                        <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                    </svg>
                                </div>
                            </div>
                            <div class="col-md-12 mr-2 px-md-1 mt-1">
                                <button type="submit"
                                    class="btn btn-primary btn-main-2 w-100 rounded-3 fw-semibold py-2 text-black border-0"
                                    id="next-2">{{ __('register.txt_register') }}</button>
                            </div>
                            <div class="my-4 text-center">
                                <span>{{ __('register.txt_have') }} <a href="<?= url('login') ?>"
                                        class="text-decoration-none fw-bold text-black">{{ __('register.txt_login') }}</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="mb-5">
  <div class="container p-0 p-lg-4 position-relative">
    <div class="row align-items-center">

      <!-- Kolom Form (KIRI) -->
      <div class="col-12 col-lg-6 bg-white rounded-5 p-4" id="formLogin">
        <div class="d-flex flex-column justify-content-center h-100">
          <h4 class="fw-semibold mt-3">{{ __('register.txt_rau') }}</h4>

          <form action="{{ url('register/store') }}" method="POST" class="fw-normal">
            @csrf
            <div id="form-1">

              <div class="my-3">
                <input type="text" class="form-control" name="name" placeholder="{{ __('register.txt_name') }}" required>
              </div>

              <div class="my-3">
                <input type="email" class="form-control" name="email" placeholder="{{ __('register.txt_email') }}" required>
              </div>

              <div class="my-3">
                <select name="category_user" id="category_user" class="form-control form-select pe-5" style="color: #999999" required>
                                    <option value="" disabled selected>{{ __('register.txt_category') }}</option>
                                    <option value="2">{{ __('register.txt_company') }}</option>
                                    <option value="3">{{ __('register.txt_umum') }}</option>
                                    <option value="4">{{ __('register.txt_pemerintah') }}</option>
                                    <option value="5">{{ __('register.txt_pendidikan') }}</option>
                                    <option value="6">{{ __('register.txt_nirlaba') }}</option>
                                </select>
              </div>

              <div class="my-3" id="col_agency">
                <input type="text" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputAgency" placeholder="{{ __('register.txt_institution') }}" name="agency" aria-describedby="" required>
              </div>

              <div class="my-3">
                <input type="number" class="form-control" name="telp" placeholder="{{ __('register.txt_number') }}" required>
              </div>

              <div class="input-group my-3 pb-lg-3">
                <input type="password" class="form-control input-text woocommerce-Input woocommerce-Input--text rounded-3" id="registerPassword1" name="password" placeholder="{{ __('register.txt_password') }}" required>
                <span class="align-self-center fw-semibold" id="togglePassword1" style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i class="far fa-eye fs-4"></i></span>
              </div>

              <div class="input-group my-3 pb-lg-3">
                <input type="password" class="form-control input-text woocommerce-Input woocommerce-Input--text rounded-3" id="registerPassword2" placeholder="{{ __('register.txt_confirm') }}" required>
                <span class="align-self-center fw-semibold" id="togglePassword2" style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i class="far fa-eye fs-4"></i></span>
              </div>

              <div class="mt-4 my-3">
                            <div class="slidercaptcha card" id="card-captcha">
                                <div class="card-header">
                                    <span>{{ __('login.txt_captcha') }}</span>
                                </div>
                                <div class="card-body" id="body-captcha">
                                    <div id="captcha"></div>
                                </div>
                            </div>
                            <div id="checkmark" class="checkmark" style="display: none">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                    <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                    <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                </svg>
                            </div>
                        </div>

              <button id="btn-register" type="submit" class="btn btn-primary w-100 fw-semibold py-2" disabled>{{ __('register.txt_register') }}</button>

              <div class="my-3 text-center">
                <span>{{ __('register.txt_have') }}
                  <a href="{{ url('login') }}" class="fw-bold text-black text-decoration-none">{{ __('register.txt_login') }}</a>
                </span>
              </div>

            </div>
          </form>
        </div>
      </div>

      <!-- Kolom Gambar (KANAN) -->
      <div class="col-lg-6 d-none d-lg-block">
        <img src="{{ asset('assets/images/login-1.png') }}"
             class="img-fluid rounded-5 h-auto w-100 object-fit-cover"
             alt="Gambar login">
      </div>

    </div>
  </div>
</div>
<style>
    svg {
    width: 60px;
    display: block;
    margin: 40px auto 0;
    }
    .path {
    stroke-dasharray: 1000;
    stroke-dashoffset: 0;
    &.circle {
        -webkit-animation: dash .9s ease-in-out;
        animation: dash .9s ease-in-out;
    }
    &.line {
        stroke-dashoffset: 1000;
        -webkit-animation: dash .9s .35s ease-in-out forwards;
        animation: dash .9s .35s ease-in-out forwards;
    }
    &.check {
        stroke-dashoffset: -100;
        -webkit-animation: dash-check .9s .35s ease-in-out forwards;
        animation: dash-check .9s .35s ease-in-out forwards;
    }
    }
    p {
    text-align: center;
    margin: 20px 0 60px;
    font-size: 1.25em;
    &.success {
        color: #73AF55;
    }
    &.error {
        color: #D06079;
    }
    }
    @-webkit-keyframes dash {
    0% {
        stroke-dashoffset: 1000;
    }
    100% {
        stroke-dashoffset: 0;
    }
    }
    @keyframes dash {
    0% {
        stroke-dashoffset: 1000;
    }
    100% {
        stroke-dashoffset: 0;
    }
    }
    @-webkit-keyframes dash-check {
    0% {
        stroke-dashoffset: -100;
    }
    100% {
        stroke-dashoffset: 900;
    }
    }
    @keyframes dash-check {
    0% {
        stroke-dashoffset: -100;
    }
    100% {
        stroke-dashoffset: 900;
    }
}
</style>
<!-- End Register -->
<script src="{{ asset('js/sliderPuzzle.js') }}"></script>
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
            let agencyField = agencyInput.closest("#col_agency");

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
