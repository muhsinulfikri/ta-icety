<div class="mb-5">
    <div class="container d-grid d-md-flex p-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= url('assets/images/login-1.png') ?>" class="float-end d-block img-fluid rounded-5 rounded-start h-auto ">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 position-absolute" id="formLogin">
                <div class="d-flex ps-4 flex-column justify-content-center h-100">
                    <h4 class="ps-1 fw-semibold">Check Your Email</h4>
                    <h5 class="fw-normal mt-5" style="line-height:inherit">We sent a password reset link to<br><?= $email ?></h5>
                    <div class="my-4">
                        <a href="<?= url('login') ?>" class="btn  btn-main-2 btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0">Back To Login</a>
                    </div>
                    <!-- <form class="fw-normal" action="<?= url('resetPassword') ?>" method="POST">
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0">Open email
                                app</button>
                        </div>
                        <div class="mt-4 text-center">
                            <span>Didn't get code? <a href="" class="text-decoration-none fw-bold text-black">RESEND!</a></span>
                        </div>
                        <div class="my-4 text-center">
                            <a href="<?= url('login') ?>" class="text-decoration-none text-black">Back
                                to Login</a>
                        </div>
                    </form> -->
                </div>

            </div>
        </div>

    </div>
</div>