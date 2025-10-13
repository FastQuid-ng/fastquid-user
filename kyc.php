<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ./'); // or login page
    exit();
}

$firstName = htmlspecialchars($_SESSION['first_name'] ?? '');
$lastName  = htmlspecialchars($_SESSION['last_name'] ?? '');
$userEmail = htmlspecialchars($_SESSION['email'] ?? '');
$fullName  = trim("$firstName $lastName");
$avatar = htmlspecialchars($_SESSION['picture'] ?? '');

?>
<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="color-scheme" content="dark light">

    <title>FastQuid&trade; :: KYC</title>

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
    <div class="row g-0 justify-content-center" style="background: url('./assets/img/kyc-bg.jpg'); background-size: contain; background-repeat: no-repeat; background-position: center; background-position-x: left;">
        <div class="col-12 col-md-12 col-lg-7 offset-lg-5 min-vh-100 overflow-y-auto d-flex flex-column justify-content-center position-relative bg-body rounded-top-start-lg-4 border-start-lg shadow-soft-5">
            <div class="w-md-50 mx-auto px-10 px-md-0 py-10">
                <div class="mb-10">
                    <h1 class="ls-tight fw-bolder h3">Complete your KYC</h1>
                    <div class="mt-3 text-sm text-muted">
                        complete your KYC, and enjoy the faster way to borrow money
                    </div>
                </div>
                <form id="kycForm">
                    <div class="row g-5">
                        <div class="col-sm-6" style="display: none;">
                            <label class="form-label">User ID</label>
                            <input type="text" class="form-control" name="id" value="<?= $_SESSION['user_id'] ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" value="<?= $fullName ?>" disabled required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender" aria-label="Default select example" required>
                                <option selected disabled value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Marital Status</label>
                            <select class="form-select" name="marital_status" aria-label="Default select example" required>
                                <option selected disabled value="">Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">State of Residence</label>
                            <select class="form-select" name="state" id="state" onchange="selectLGA(this)" required>
                                <option selected disabled value="">Select State</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">LGA</label>
                            <select class="form-select" name="lga" id="lga" required>
                                <option selected disabled value="">Select LGA</option>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Residential Address</label>
                            <input type="text" class="form-control" name="residential_address" required>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-dark w-100">Complete KYC</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        document.querySelector("#kycForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const notyf = new Notyf({
                duration: 4000,
                position: { x: 'right', y: 'top' }
            });

            const btn = this.querySelector("button[type='submit']");
            btn.disabled = true;
            btn.textContent = "Submitting KYC...";

            try {
                const response = await fetch("./auth/kyc_auth.php", {
                    method: "POST",
                    body: new FormData(this)
                });
                const result = await response.json();

                btn.disabled = false;
                btn.textContent = "Complete KYC";

                if (result.success) {
                    notyf.success(result.message);

                    // Update avatar dynamically if gender is provided
                    const gender = this.querySelector("select[name='gender']").value;
                    const avatarPath = gender === 'Male' ? 'assets/img/male-avatar.png' : 'assets/img/female-avatar.png';

                    const avatarElements = document.querySelectorAll(".user-avatar, #userAvatar");
                    avatarElements.forEach(el => {
                        if (el.tagName === 'IMG') {
                            el.src = avatarPath;
                        } else {
                            el.style.backgroundImage = `url(${avatarPath})`;
                        }
                    });

                    // Optional: update session avatar (frontend may fetch on next reload)

                    setTimeout(() => window.location.href = "./dashboard", 2000);

                } else {
                    notyf.error(result.message);
                    console.error("KYC Error:", result);
                }
            } catch (error) {
                btn.disabled = false;
                btn.textContent = "Complete KYC";
                notyf.error("Something went wrong. Please try again.");
                console.error("Fetch Error:", error);
            }
        });
    </script>


    <script>
        // Fetch all States and populate the dropdown
        async function fetchStates() {
            try {
                const res = await fetch('https://nga-states-lga.onrender.com/fetch');
                const data = await res.json();
                const stateSelect = document.getElementById("state");

                // Clear any existing options except the default
                stateSelect.innerHTML = '<option selected disabled value="">Select State</option>';

                data.forEach(state => {
                    const option = document.createElement("option");
                    option.value = state;
                    option.textContent = state;
                    stateSelect.appendChild(option);
                });
            } catch (err) {
                console.error("Failed to fetch states:", err);
            }
        }

        // Fetch Local Governments based on selected state
        async function selectLGA(target) {
            const state = target.value;
            const lgaSelect = document.getElementById("lga");

            // Reset LGA dropdown
            lgaSelect.innerHTML = '<option selected disabled value="">Select LGA</option>';

            if (!state) return;

            try {
                const res = await fetch(`https://nga-states-lga.onrender.com/?state=${state}`);
                const data = await res.json();

                data.forEach(lga => {
                    const option = document.createElement("option");
                    option.value = lga;
                    option.textContent = lga;
                    lgaSelect.appendChild(option);
                });
            } catch (err) {
                console.error("Failed to fetch LGAs:", err);
            }
        }

        // Initialize on page load
        fetchStates();
    </script>
</body>

</html>