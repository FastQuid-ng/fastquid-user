<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="color-scheme" content="dark light">

    <title>FastQuid&trade; :: Log In</title>

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
    <div class="row g-0 justify-content-center" style="background: url('./assets/img/login-bg.jpg'); background-size: contain; background-repeat: no-repeat; background-position: center; background-position-x: left;">
        <div class="col-12 col-md-12 col-lg-7 offset-lg-5 min-vh-100 overflow-y-auto d-flex flex-column justify-content-center position-relative bg-body rounded-top-start-lg-4 border-start-lg shadow-soft-5">
            <div class="w-md-50 mx-auto px-10 px-md-0 py-10">
                <div class="mb-5">
                    <a class="d-inline-block mb-10" href="./">
                        <img src="./assets/img/logo-dark.svg" class="h-rem-10" alt="logo">
                    </a>
                    <div class="text-center d-flex flex-column mb-10">
                        <p class="mb-2 text-dark font-size-sm">Please check that you are visiting the correct URL</p>
                        <span style="border-radius:20px;letter-spacing:.09rem;border-color:#eee !important;background-color:whitesmoke;" class="w-auto px-8 border text-dark font-size-h6 font-weight-light py-2">
                            <i class="bi bi-lock-fill text-success"></i><span class="text-success">https://</span>my.fastquid.ng
                        </span>
                    </div>
                    <h1 class="ls-tight fw-bolder h3">Sign in to your account</h1>
                    <div class="mt-3 text-sm text-muted">
                        <span>Don't have an account?</span> 
                        <a href="signup" class="fw-semibold">Sign up</a> in minutes to get started.
                    </div>
                </div>
                <form id="loginForm">
                    <div class="mb-5">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                    </div>

                    <div class="mb-7 position-relative">
                        <div class="d-flex justify-content-between gap-2 mb-2 align-items-center">
                            <label class="form-label">Password</label>
                            <a href="forgot-password" class="text-sm text-muted text-danger-hover text-underline">Forgot password?</a>
                        </div>
                        <div class="position-relative">
                            <input type="password" class="form-control pe-5" name="password" id="passwordField" placeholder="Enter password" required>
                            <span id="togglePassword" 
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-dark w-100">Sign In</button>
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

        document.querySelector("#loginForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            const btn = this.querySelector("button[type='submit']");
            btn.disabled = true;
            btn.textContent = "Signing in...";

            const formData = new FormData(this);

            try {
                const response = await fetch("./auth/login_auth.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                btn.disabled = false;
                btn.textContent = "Sign In";

                // Handle verify-account redirect
                if (!result.success && result.redirect === "verify-account") {
                    notyf.error(result.message);
                    setTimeout(() => window.location.href = "./verify-account", 2000);
                    return;
                }

                // Handle success
                if (result.success) {
                    notyf.success(result.message);
                    setTimeout(() => {
                        if (result.redirect === "kyc") {
                            window.location.href = "./kyc";
                        } else {
                            window.location.href = "./dashboard";
                        }
                    }, 2000);
                    return;
                }

                // Handle general errors
                notyf.error(result.message || "Login failed. Please try again.");

            } catch (error) {
                console.error(error);
                btn.disabled = false;
                btn.textContent = "Sign In";
                notyf.error("Unable to sign in. Please try again later.");
            }
        });

        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#passwordField');
        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>


</body>

</html>