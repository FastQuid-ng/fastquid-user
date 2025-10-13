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
                    <h1 class="ls-tight fw-bolder h3">Forgot password</h1>
                    <div class="mt-3 text-sm text-muted">
                        <span>If you forgot your password, well, then we’ll email you instructions to reset your password.</span>
                    </div>
                </div>
                <form id="forgotForm">
                    <div class="mb-5">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                    </div>
                    <div class="col-12r">
                        <button type="submit" class="btn btn-dark w-100" id="submitBtn">Send Reset Link</button>
                    </div>
                </form>
                <div class="mt-5 text-center">
                    <span>Go back to</span> <a href="./" class="fw-semibold">Login</a>
                </div>
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

        document.getElementById("forgotForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const btn = document.getElementById("submitBtn");
            btn.disabled = true;
            btn.textContent = "Sending link...";

            try {
                const response = await fetch("./auth/forgot_password_auth.php", {
                    method: "POST",
                    body: new FormData(this)
                });

                const result = await response.json();
                btn.disabled = false;
                btn.textContent = "Send Reset Link";

                if (result.success) {
                    notyf.success(result.message);
                    // Optional redirect after a few seconds
                    setTimeout(() => {
                        window.location.href = "./";
                    }, 2500);
                } else {
                    notyf.error(result.message || "Unable to process your request.");
                }

            } catch (err) {
                btn.disabled = false;
                btn.textContent = "Send Reset Link";
                notyf.error("Network error. Please try again.");
                console.error("Forgot password error:", err);
            }
        });
    </script>


</body>

</html>