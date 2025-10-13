<?php
// reset-password.php
$token = $_GET['token'] ?? '';
if (!$token) {
    header("Location: ./");
    exit;
}
?>
<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="color-scheme" content="dark light">

    <title>FastQuid&trade; :: Forgot Password</title>

    <meta name="description" content="At Fastquid, we’ve got you covered with our terrific digital lending solutions designed just for folks like you, whether you work for a big company or a small business.">
    <meta property="og:url" content="https://fastquid.ng/"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="FastQuid&trade; :: A faster way to borrow money"/>
    <meta name="og:description" content="At Fastquid, we’ve got you covered with our terrific digital lending solutions designed just for folks like you, whether you work for a big company or a small business.">
    <meta name="keywords" content="credit, loan, payments, africa, nigeria, fintech, tech in africa, lagos, fastquid, agency banking, money agent, fastquid, Quick Cash">
    <meta name="author" content="Webify">

    <link rel="shortcut icon" href="./assets/img/favicon.png">

    <link rel="stylesheet" type="text/css" href="./assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/utility.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://api.fontshare.com/v2/css?f=satoshi@900,700,500,300,401,400&amp;display=swap">
</head>

<body>
    <div class="row g-0 justify-content-center" style="background: url('./assets/img/forgot-password-bg.png'); background-size: contain; background-repeat: no-repeat; background-position: center; background-position-x: left;">
        <div class="col-12 col-md-12 col-lg-7 offset-lg-5 min-vh-100 overflow-y-auto d-flex flex-column justify-content-center position-relative bg-body rounded-top-start-lg-4 border-start-lg shadow-soft-5">
            <div class="w-md-50 mx-auto px-10 px-md-0 py-10">
                <div class="mb-10">
                    <a class="d-inline-block mb-10" href="./">
                        <img src="./assets/img/logo-dark.svg" class="h-rem-10" alt="logo">
                    </a>
                    <h1 class="ls-tight fw-bolder h3">Reset password</h1>
                    <div class="mt-3 text-sm text-muted">
                        <span>Enter your new password below.</span>
                    </div>
                </div>
                <form id="resetForm">
                    <div class="mb-5" style="display: none">
                        <label class="form-label" for="email">Token</label>
                        <input type="text" class="form-control" name="token" value="<?= htmlspecialchars($token) ?>">
                    </div>
                    <div class="col-sm-12 position-relative mb-5">
                        <label class="form-label">New Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control" name="password" id="passwordField" placeholder="Enter new password" required minlength="8">
                            <span id="togglePassword" 
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 position-relative mb-5">
                        <label class="form-label">Confirm Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control" name="confirm_password" id="confirmPasswordField" placeholder="Confirm new password" required minlength="8">
                            <span id="toggleConfirmPassword" 
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12r">
                        <button type="submit" class="btn btn-dark w-100" id="submitBtn">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' }
        });

        document.getElementById("resetForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const btn = document.getElementById("submitBtn");
            const formData = new FormData(this);
            const pass = formData.get('password');
            const confirm = formData.get('confirm_password');

            if (pass !== confirm) {
                notyf.error("Passwords do not match.");
                return;
            }

            btn.disabled = true;
            btn.textContent = "Resetting...";

            try {
                const res = await fetch("./auth/reset_password_auth.php", {
                    method: "POST",
                    body: formData
                });

                const result = await res.json();
                btn.disabled = false;
                btn.textContent = "Reset Password";

                if (result.success) {
                    notyf.success(result.message);
                    setTimeout(() => window.location.href = "./", 2500);
                } else {
                    notyf.error(result.message || "Reset failed.");
                }

            } catch (err) {
                btn.disabled = false;
                btn.textContent = "Reset Password";
                notyf.error("Network error. Please try again.");
                console.error("Reset error:", err);
            }
        });
    </script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#passwordField');
        const confirmPasswordField = document.querySelector('#confirmPasswordField');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle icon
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordField.setAttribute('type', type);

            // Toggle icon
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>


</body>

</html>