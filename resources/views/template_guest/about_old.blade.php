<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <h5 class="py-2 fw-semibold">About</h5>
    <hr class="opacity-25">
    <div class="d-flex justify-content-center w-100 my-6">
        <img src="<?= base_url('assets/images/logo_bigger.svg') ?>" class="d-block justify-content-center img-logo img-fluid">
    </div>
    <div class="mx-2 mx-lg-6 text-muted mb-6">
        <p>TBH Academy is a versatile platform that empowers organizers to effortlessly create events,
            whether they are free or paid. With a host of user-friendly features at your fingertips,
            including video conference platform management, event link generation, automated certificate issuance,
            and secure event payment processing, TBH Academy is your one-stop solution for seamlessly orchestrating
            classes comprising diverse meetings and modules. Our platform streamlines the event creation process,
            allowing organizers to focus on delivering enriching educational experiences.</p>
        <p>Not only does TBH Academy cater to event organizers, but it also offers a wealth of learning opportunities to participants.
            The platform boasts an extensive array of events that cater to a wide range of interests and fields of study.
            Whether you're looking to expand your knowledge,
            TBH Academy has you covered. Each event is meticulously curated to uphold professional standards in both content and speaker quality,
            ensuring that every learning experience is not only informative but also engaging and inspiring.</p>
        <p>In addition to its robust event offerings, TBH Academy fosters a thriving community of learners and experts. Our platform encourages
            meaningful interactions among participants, allowing you to connect with like-minded individuals,
            exchange ideas, and build valuable networks. With TBH Academy, education extends beyond the confines of
            traditional classrooms, offering a dynamic and accessible approach to learning that adapts to your schedule and preferences.
            Join our vibrant community today and embark on a journey of continuous learning and personal growth.</p>
    </div>
    <hr class="opacity-25 mx-2 mx-lg-6">
    <div class="row mx-2 mx-lg-6">
        <div class="col-lg-4 pb-4">
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="d-none d-lg-block bg-primary rounded-3 mb-3 h-50 overflow-hidden" style="width: 94%;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1975.6568654849596!2d112.60876838907387!3d-7.966493549666502!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7882889f4d1b3f%3A0xa57e19534d73a2d8!2sSTIKI!5e0!3m2!1sen!2sid!4v1663893485888!5m2!1sen!2sid" width="715" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <h5 class="fw-semibold">Contact</h5>
                <div class="d-grid mt-lg-2 mt-3 gap-2">
                    <div class="">
                        <i class="bi bi-telephone-fill fs-5"></i>
                        <span class="ms-3">+62 857 8723 8237</span>
                    </div>
                    <div class="">
                        <i class="bi bi-envelope fs-5"></i>
                        <span class="ms-3">tbhacademy@gmail.com</span>
                    </div>
                    <div class="d-inline-flex">
                        <i class="bi bi-geo-alt fs-5"></i>
                        <span class="ms-3" style="margin-left:1.2rem !important">Jl. Raya Tidar No.100, Karangbesuki,
                            Kec. Sukun, <br>
                            Kota Malang, East Java 65146,
                            13910</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <form class="fw-normal" action="<?= base_url('send/mail') ?>" method="POST">
                        <div class="card-body">
                            <div>
                                <p>Do you have any questions about using our website? </p>
                                <p> complete the form below and we will contact you as soon as possible.</p>
                            </div>
                            <div class="my-4 float-label-control">
                                <label for="#exampleInputtext1">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-1 ps-1" id="exampleInputtext1" name="nama" aria-describedby="textHelp" required>
                            </div>
                            <div class="my-4 float-label-control">
                                <label for="#exampleInputtext1">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control rounded-1 ps-1" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" required>
                            </div>
                            <div class="my-4 float-label-control">
                                <label for="#exampleInputtext1">Nomor Telepon <span class="text-mute">(optional)</span></label>
                                <input type="text" class="form-control rounded-1 ps-1" id="exampleInputtext2" name="noHP" aria-describedby="textHelp">
                            </div>
                            <div class="my-4 float-label-control">
                                <label for="#exampleInputtext1">Pesan <span class="text-danger">*</span></label>
                                <textarea name="pesan" id="" cols="30" rows="10" class="form-control rounded-1 ps-1" required></textarea>
                            </div>
                            <div class="my-4 float-label-control">
                                <div class="g-recaptcha" data-sitekey="6LfZlSETAAAAAC5VW4R4tQP8Am_to4bM3dddxkEt"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
</style>
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
</script>

<?= $this->session->flashdata('msg_send'); ?>