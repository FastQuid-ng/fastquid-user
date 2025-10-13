<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="color-scheme" content="dark light">

    <title>FastQuid&trade; :: Sign Up</title>

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
    <div class="row g-0 justify-content-center" style="background: url('./assets/img/signup-bg.webp'); background-size: contain; background-repeat: no-repeat; background-position: center; background-position-x: left;">
        <div class="col-12 col-md-12 col-lg-7 offset-lg-5 min-vh-100 overflow-y-auto d-flex flex-column justify-content-center position-relative bg-body rounded-top-start-lg-4 border-start-lg shadow-soft-5">
            <div class="w-md-50 mx-auto px-10 px-md-0 py-10">
                <div class="mb-10">
                    <a class="d-inline-block mb-10" href="./">
                        <img src="./assets/img/logo-dark.svg" class="h-rem-10" alt="logo">
                    </a>
                    <h1 class="ls-tight fw-bolder h3">Get started. It&#39;s free</h1>
                    <div class="mt-3 text-sm text-muted">
                        <span>Already have an account?</span> 
                        <a href="./" class="fw-semibold">Sign in</a> to your account.
                    </div>
                </div>
                <form id="registerForm">
                    <div class="row g-5">
                        <div class="col-sm-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Enter first name" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter last name" name="last_name" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone" placeholder="Enter phone number" required pattern="^\+?[0-9]{7,15}$">
                        </div>
                        <div class="col-sm-12 position-relative">
                            <label class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control pe-5" name="password" id="passwordField" placeholder="Enter password" required>
                                <span id="togglePassword" 
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">How did you hear about us?</label>
                            <select class="form-select" name="referee" aria-label="Default select example" required>
                                <option selected disabled value="">------</option>
                                <option value="From a friend">From a friend</option>
                                <option value="Online search">Online search</option>
                                <option value="Social media">Social media</option>
                                <option value="Advertising">Advertising</option>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-dark w-100">Create Free Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        document.querySelector("#registerForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const notyf = new Notyf({
                duration: 4000,
                position: { x: 'right', y: 'top' }
            });

            const formData = new FormData(this);

            try {
                const btn = this.querySelector("button[type='submit']");
                btn.disabled = true;
                btn.textContent = "Creating account...";

                const response = await fetch("./auth/signup_auth.php", {
                    method: "POST",
                    body: formData
                });

                btn.disabled = false;
                btn.textContent = "Sign up";

                const result = await response.json();

                if (result.success) {
                    notyf.success(result.message);
                    setTimeout(() => {
                        window.location.href = "./verify-account"; // adjust path
                    }, 5000);
                } else {
                    notyf.error(result.message);
                }
            } catch (error) {
                notyf.error("Something went wrong. Please try again.");
            }
        });
    </script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#passwordField');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle icon
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>