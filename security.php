<?php
$pageTitle = 'security';
include "./components/header.php"; 
?>
    <div class="d-flex flex-column flex-lg-row h-lg-100 gap-1">
        <?php include "./components/side-nav.php"; ?>

        <div class="flex-lg-fill overflow-x-auto ps-lg-1 vstack vh-lg-100 position-relative">
            <?php include "./components/top-nav.php"; ?>
            <div class="flex-fill overflow-y-lg-auto scrollbar bg-body rounded-top-4 rounded-top-start-lg-4 rounded-top-end-lg-0 border-top border-lg shadow-2">
                <main class="container-fluid px-3 py-5 p-lg-6 p-xxl-8">
                    <header class="border-bottom mb-10">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12">
                                <h1 class="ls-tight">Security</h1>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-flush gap-6 overflow-x border-0 mt-4">
                            <li class="nav-item"><a href="profile" class="nav-link">Profile</a></li>
                            <li class="nav-item"><a href="security" class="nav-link active">Security</a></li>
                            <li class="nav-item"><a href="bank" class="nav-link">Bank</a></li>
                        </ul>
                    </header>

                    <div class="vstack gap-5">
                        <form id="changePasswordForm">
                            <!-- Current Password -->
                            <div class="row align-items-center g-3 position-relative mb-5">
                                <div class="col-md-2">
                                    <label class="form-label mb-0">Current password</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <input type="password" id="passwordField" name="old_pass" class="form-control" placeholder="Enter old password" required>
                                        <span id="togglePassword" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="row align-items-center g-3 position-relative mb-5">
                                <div class="col-md-2">
                                    <label class="form-label mb-0">New password</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <input type="password" id="newPasswordField" name="new_pass" class="form-control" placeholder="Enter new password" required minlength="8">
                                        <span id="toggleNewPassword" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="row align-items-center g-3 position-relative mb-5">
                                <div class="col-md-2">
                                    <label class="form-label mb-0">Confirm password</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <input type="password" id="confirmNewPasswordField" name="confirm_pass" class="form-control" placeholder="Re-enter new password" required>
                                        <span id="toggleConfirmNewPassword" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center g-3 position-relative mb-5">
                                <div class="col-md-2"></div>
                                <div class="col-md-6 text-end">
                                    <button type="submit" id="btnChangePass" class="btn btn-primary px-4">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/switcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' }
        });

        document.querySelector("#changePasswordForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const btn = document.querySelector("#btnChangePass");
            const newPass = document.querySelector("#newPasswordField").value;
            const confirmPass = document.querySelector("#confirmNewPasswordField").value;

            if (newPass !== confirmPass) {
                notyf.error("New password and confirmation do not match.");
                return;
            }

            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Updating...`;

            const formData = new FormData(this);

            try {
                const res = await fetch("api/change-password.php", {
                    method: "POST",
                    body: formData
                });

                const data = await res.json();

                if (data.success) {
                    notyf.success(data.message || "Password changed successfully!");
                    this.reset();
                } else {
                    notyf.error(data.message || "Unable to update password.");
                }

            } catch (err) {
                console.error(err);
                notyf.error("Something went wrong. Please try again.");
            } finally {
                btn.disabled = false;
                btn.innerHTML = "Update Password";
            }
        });

        // Toggle visibility for password fields
        const togglePassword = document.querySelector('#togglePassword');
        const toggleNewPassword = document.querySelector('#toggleNewPassword');
        const toggleConfirmNewPassword = document.querySelector('#toggleConfirmNewPassword');

        const passwordField = document.querySelector('#passwordField');
        const newPasswordField = document.querySelector('#newPasswordField');
        const confirmNewPasswordField = document.querySelector('#confirmNewPasswordField');

        togglePassword.addEventListener('click', () => toggleInputVisibility(passwordField, togglePassword));
        toggleNewPassword.addEventListener('click', () => toggleInputVisibility(newPasswordField, toggleNewPassword));
        toggleConfirmNewPassword.addEventListener('click', () => toggleInputVisibility(confirmNewPasswordField, toggleConfirmNewPassword));

        function toggleInputVisibility(input, toggleIcon) {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            toggleIcon.querySelector('i').classList.toggle('bi-eye');
            toggleIcon.querySelector('i').classList.toggle('bi-eye-slash');
        }
    </script>
</body>
</html>
