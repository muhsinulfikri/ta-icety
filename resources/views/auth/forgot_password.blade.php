<div class="mb-5">
    <div class="container d-grid d-md-flex p-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= url('assets/images/login-1.png') ?>" class="float-end d-block img-fluid rounded-5 rounded-start h-auto ">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 absolute-auth" id="formLogin">
                <div class="d-flex ps-4 flex-column justify-content-center h-100">
                    <?= (!empty($msg) ? $msg : "") ?>
                    <h4 class="ps-1 fw-semibold">Reset Password</h4>
                    <h5 class="fw-normal mt-5">Please Enter Your Email Address To <br>Reset Your Password</h5>
                    <form class="fw-normal" action="<?= url('forgotPassword') ?>" method="POST">
                    @csrf
                        <div class="my-4 float-label-control">
                            <input type="email" class="form-control input-text woocommerce-Input woocommerce-Input--text"  id="exampleInputEmail1" name="email" placeholder="Email" aria-describedby="emailHelp">
                        </div>
                        <div class="my-4">
                            <button type="submit" class="btn  btn-main-2 btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0">Reset Password</button>
                        </div>
                        <div class="my-4 text-center">
                            <a href="<?= url('login') ?>" class="text-decoration-none text-black">Back to Login</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            @if (session()->has('resp_msg'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('resp_msg') }}'
            });
            @endif
        });
</script>
