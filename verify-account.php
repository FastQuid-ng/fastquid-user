<?php
session_start();
if (!isset($_SESSION['pending_email'])) {
    header("Location: signup");
    exit;
}
$email = $_SESSION['pending_email'];
?>

<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="color-scheme" content="dark light">

    <title>FastQuid&trade; :: Account Verification</title>

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
    <div class="row g-0 justify-content-center" style="background: url('./assets/img/verify-otp-bg.jpg'); background-size: contain; background-repeat: no-repeat; background-position: center; background-position-x: left;">
        <div class="col-12 col-md-12 col-lg-7 offset-lg-5 min-vh-100 overflow-y-auto d-flex flex-column justify-content-center position-relative bg-body rounded-top-start-lg-4 border-start-lg shadow-soft-5">
            <div class="w-md-50 mx-auto px-10 px-md-0 py-10">
                <div class="mb-10">
                    <a class="d-inline-block mb-10" href="./">
                        <img src="./assets/img/logo-dark.svg" class="h-rem-10" alt="logo">
                    </a>
                    <h1 class="ls-tight fw-bolder h3">Account Verification</h1>
                    <div class="mt-3 text-sm text-muted">
                        <span>Enter the 6-digit OTP sent to your email address</span>
                    </div>
                </div>
                <form id="verifyForm">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-2 col-md-2">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp1" required>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp2" required>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp3" required>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp4" required>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp5" required>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp6" required>
                        </div>
                    </div>

                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

                    <div class="mt-6">
                        <button type="submit" class="btn btn-dark w-100">Verify Account</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-sm text-muted">
                        Didn’t get the code?
                        <a href="#" id="resendOtp" class="fw-semibold text-dark">Resend OTP</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' }
        });

        // Automatically move focus to next input
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });

        document.querySelector("#verifyForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            const form = e.target;

            // Combine OTP values
            const otp = Array.from(form.querySelectorAll('.otp-input')).map(i => i.value).join('');
            const email = form.querySelector('[name="email"]').value;

            if (otp.length !== 6) {
                notyf.error("Please enter all 6 digits.");
                return;
            }

            const formData = new FormData();
            formData.append("otp", otp);
            formData.append("email", email);

            const btn = form.querySelector("button[type='submit']");
            btn.disabled = true;
            btn.textContent = "Verifying...";

            try {
                const response = await fetch("./auth/verify_account_auth.php", {
                    method: "POST",
                    body: formData,
                });
                const result = await response.json();

                btn.disabled = false;
                btn.textContent = "Verify Account";

                if (result.success) {
                    notyf.success(result.message);
                    setTimeout(() => window.location.href = "./kyc", 3000);
                } else {
                    notyf.error(result.message);
                }
            } catch (error) {
                notyf.error("Something went wrong. Please try again.");
                btn.disabled = false;
                btn.textContent = "Verify Account";
            }
        });

        // Resend OTP handler
        document.querySelector("#resendOtp").addEventListener("click", async (e) => {
            e.preventDefault();
            const email = document.querySelector('[name="email"]').value.trim();

            if (!email) {
                notyf.error("Email not found. Go back and sign up again.");
                return;
            }

            try {
                const response = await fetch("./auth/resend_otp_auth.php", {
                    method: "POST",
                    body: new URLSearchParams({ email }),
                });
                const result = await response.json();

                if (result.success) {
                    notyf.success(result.message);
                } else {
                    notyf.error(result.message);
                }
            } catch (error) {
                notyf.error("Failed to resend OTP. Try again later.");
            }
        });
    </script>
</body>

</html>