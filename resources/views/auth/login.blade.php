<!-- Login -->
<div class="mb-5">
    <div class="container d-grid d-md-flex p-0 p-lg-4 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= asset('assets/images/login-1.png') ?>" class="float-end d-block img-fluid rounded-5 rounded-start h-auto ">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 pe-4 pe-md-5 bg-white rounded-5 absolute-auth" id="formLogin">
                <div class="d-flex ps-md-4 flex-column justify-content-center h-100">
                    {{--
                        msg error
                    --}}
                    <h4 class="ps-1 fw-semibold">Login</h4>
                    <form class="fw-normal" action="<?= url('login/authentication') ?>" method="POST">
                        @csrf
                        <div class="my-4 float-label-control">
                            <input type="email" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" name="email" placeholder="Email" aria-describedby="emailHelp" required>
                        </div>
                        <div class="input-group my-4">
                            <input type="password" class="form-control input-text woocommerce-Input woocommerce-Input--text rounded-3" name="password" id="exampleInputPassword1" placeholder="Password" aria-describedby="passwordHelp" required>
                            <span class="align-self-center fw-semibold" id="togglePassword" style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i class="far fa-eye fs-4"></i></span>
                        </div>
                        <div class="mt-4 my-3">
                            <div class="slidercaptcha card" id="card-captcha">
                                <div class="card-header">
                                    <span>Please complete security verification before Login!</span>
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
                        <div class="mt-3 my-3">
                            <a href="<?= url('forgot-password') ?>" class="text-decoration-none fw-bold text-black">Forgot Password?</a>
                        </div>
                        <div class="my-4">
                            <button id="btn-login" type="submit" class="btn  btn-main-2 btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0" disabled>Login</button>
                        </div>
                        <div class="my-4 text-center">
                            <span>Don't have account? <a href="<?= url('register') ?>" class="text-decoration-none fw-bold text-black">Register</a></span>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- End Login -->

<style>
    #g-recaptcha-response {
        display: block !important;
        position: absolute;
        margin: -78px 0 0 0 !important;
        width: 302px !important;
        height: 76px !important;
        z-index: -999999;
        opacity: 0;
    }
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
<script src="{{ asset('js/sliderPuzzle.js') }}"></script>
<script>
    window.onload = function() {
        var $recaptcha = document.querySelector('#g-recaptcha-response');

        if ($recaptcha) {
            $recaptcha.setAttribute("required", "required");
        }
        const $form = document.querySelector('form');
        $form.addEventListener('submit', (event) => {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                event.preventDefault();
            }
        });
    };

    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#exampleInputPassword1");

    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if(session()->has('succ_msg'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('succ_msg') }}'
        })
        @endif
        @if(session()->has('error_msg'))
        Swal.fire({
            icon: 'error',
            title: '{{ session('error_msg') }}'
        });
        @endif
        @if(session()->has('resp_msg'))
        Swal.fire({
            icon: 'error',
            title: '{{ session('resp_msg') }}'
        });
        @endif
        @if(session()->has('msg_auth'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('msg_auth') }}'
        });
        @endif
    });

    togglePassword.addEventListener("click", function(e) {
        if (password.value) {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            togglePassword.innerHTML = password.getAttribute("type") === "password" ?
                "<i class='far fa-eye fs-4'></i>" :
                "<i class='far fa-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });
</script>
