<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-5" style="color:#5580E9">Change Password</h3>
    <h5 class="text-black ps-1">Your Current Password</h5>
    <div class="input-group my-4">
        <input type="password" class="form-control border-bottom border-0 shadow-none rounded-0 ps-1" id="currentPassword" placeholder="Your Current Password" name="password" value="bahagia">
        <span class="align-self-center fw-semibold" id="togglePassword1" style="cursor: pointer; margin-left: -25px; z-index: 5;"><i class="bi bi-eye fs-4"></i></span>
    </div>

    <h5 class="text-black ps-1">New Password</h5>
    <div class="input-group my-4 pb-lg-3">
        <input type="password" class="form-control border-bottom border-0 shadow-none rounded-0 ps-1" id="newPassword" placeholder="New Password" value="bahagia">
        <span class="align-self-center fw-semibold" id="togglePassword2" style="cursor: pointer; margin-left: -25px; z-index: 5;"><i class="bi bi-eye fs-4"></i></span>
    </div>
    <h5 class="text-black ps-1">Confirm New Password</h5>
    <div class="input-group my-4 pb-lg-3">
        <input type="password" class="form-control border-bottom border-0 shadow-none rounded-0 ps-1" id="confirmPassword" placeholder="Confirm New Password" value="bahagia">
        <span class="align-self-center fw-semibold" id="togglePassword3" style="cursor: pointer; margin-left: -25px; z-index: 5;"><i class="bi bi-eye fs-4"></i></span>
    </div>
    <button type="submit" class="btn btn-primary rounded-4 fw-semibold py-2 w-100" style="--bs-btn-padding-x: 4.5rem;">Save</button>
</div>

<script>
    const togglePassword1 = document.querySelector("#togglePassword1");
    const password = document.querySelector("#currentPassword");

    togglePassword1.addEventListener("click", function(e) {
        if (password.value) {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            togglePassword1.innerHTML = password.getAttribute("type") === "password" ?
                "<i class='bi bi-eye fs-4'></i>" :
                "<i class='bi bi-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });
    const togglePassword2 = document.querySelector("#togglePassword2");
    const password2 = document.querySelector("#newPassword");


    togglePassword2.addEventListener("click", function(e) {
        if (password2.value) {
            const type = password2.getAttribute("type") === "password" ? "text" : "password";
            password2.setAttribute("type", type);
            togglePassword2.innerHTML = password2.getAttribute("type") === "password" ?
                "<i class='bi bi-eye fs-4'></i>" :
                "<i class='bi bi-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });

    const togglePassword3 = document.querySelector("#togglePassword3");
    const password3 = document.querySelector("#confirmPassword");


    togglePassword3.addEventListener("click", function(e) {
        if (password3.value) {
            const type = password3.getAttribute("type") === "password" ? "text" : "password";
            password3.setAttribute("type", type);
            togglePassword3.innerHTML = password2.getAttribute("type") === "password" ?
                "<i class='bi bi-eye fs-4'></i>" :
                "<i class='bi bi-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });
</script>