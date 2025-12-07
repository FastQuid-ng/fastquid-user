<?php
$pageTitle = 'loan-application';
include "./components/header.php";
?>
    <!-- Styles -->
    <style>
        .step {
            position: relative;
            z-index: 1;
        }
        .circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #ddd;
            color: #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 8px;
        }
        .step.active .circle {
            border-color: #ef2c5a;
            background: #ef2c5a;
            color: #fff;
        }
        .step.completed .circle {
            border-color: #ef2c5a;
            background: #ef2c5a;
            color: #fff;
        }
        .step small {
            color: #6c757d;
        }
        .form-step { display: none; }
        .form-step.active { display: block; }
    </style>
    <div class="d-flex flex-column flex-lg-row h-lg-100 gap-1">
        <?php include "./components/side-nav.php"; ?>

        <div class="flex-lg-fill overflow-x-auto ps-lg-1 vstack vh-lg-100 position-relative">
            <?php include "./components/top-nav.php"; ?>
            <div class="flex-fill overflow-y-lg-auto scrollbar bg-body rounded-top-4 rounded-top-start-lg-4 rounded-top-end-lg-0 border-top border-lg shadow-2">
                <main class="container-fluid px-3 py-5 p-lg-6 p-xxl-8">
                    <header class="mb-10">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12">
                                <h1 class="ls-tight">Loan Application</h1>
                            </div>
                        </div>
                    </header>

                    <!-- Wizard Form -->
                    <div class="container py-5">
                        <div class="card border-1 mx-auto" style="max-width: 800px;">
                            <div class="card-body p-7">
                                <!-- Progress Bar -->
                                <div class="progressbar d-flex justify-content-between position-relative mb-10">
                                    <div class="step active text-center flex-fill">
                                        <div class="circle mx-auto"><i class="bi bi-check-circle-fill"></i></div>
                                    </div>

                                    <div class="step text-center flex-fill">
                                        <div class="circle mx-auto"><i class="bi bi-check-circle-fill"></i></div>
                                    </div>

                                    <div class="step text-center flex-fill">
                                        <div class="circle mx-auto"><i class="bi bi-check-circle-fill"></i></div>
                                    </div>

                                    <div class="step text-center flex-fill">
                                        <div class="circle mx-auto"><i class="bi bi-check-circle-fill"></i></div>
                                    </div>
                                </div>

                                <!-- Wizard Form -->
                                <form id="registerForm">

                                    <!-- Step 1 -->
                                    <div class="form-step active">
                                        <div class="row g-4">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Application Type</label>
                                                <select class="form-select" aria-label="Default select example" required>
                                                    <option selected disabled value="">Select application type</option>
                                                    <option value="Direct Loan">Direct Loan</option>
                                                    <option value="Via Company">Via Company</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Loan Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">₦</span>
                                                    <input
                                                    type="text"
                                                    id="loanAmount"
                                                    class="form-control"
                                                    placeholder="Enter amount"
                                                    required
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Loan Type</label>
                                                <select class="form-select" id="loanType" required>
                                                    <option selected disabled value="">Select loan type</option>
                                                    <option value="Pay Day Loan">Pay Day Loan</option>
                                                    <option value="Personal Loan">Personal Loan</option>
                                                </select>
                                            </div>

                                            <!-- Pay Day Loan Duration -->
                                            <div class="col-sm-6 mb-3" id="payDayLoanContainer">
                                                <label class="form-label">Loan Duration</label>
                                                <select class="form-select" id="payDayLoan" required>
                                                    <option selected disabled value="">Select loan duration</option>
                                                    <option value="1 Month">1 Month</option>
                                                </select>
                                            </div>

                                            <!-- Personal Loan Duration -->
                                            <div class="col-sm-6 mb-3 d-none" id="personalLoanContainer">
                                                <label class="form-label">Loan Duration</label>
                                                <select class="form-select" id="personalLoan" required>
                                                    <option selected disabled value="">Select loan duration</option>
                                                    <option value="2 Months">2 Months</option>
                                                    <option value="3 Months">3 Months</option>
                                                    <option value="4 Months">4 Months</option>
                                                    <option value="5 Months">5 Months</option>
                                                    <option value="6 Months">6 Months</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Reason</label>
                                                <select class="form-select" aria-label="Default select example" required>
                                                    <option selected disabled value="">Select loan reason</option>
                                                    <option value="Education">Education</option>
                                                    <option value="Medical">Medical</option>
                                                    <option value="Rent">Rent</option>
                                                    <option value="Travel">Travel</option>
                                                    <option value="Business">Business</option>
                                                    <option value="Events">Events</option>
                                                    <option value="House keep">House keep</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-5 text-end">
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="form-step">
                                        <div class="row g-4">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Employment Status</label>
                                                <select class="form-select" id="loanType" required>
                                                    <option selected disabled value="">Select loan type</option>
                                                    <option value="Employee">Employee</option>
                                                    <option value="Self employed">Self Employed</option>
                                                    <option value="Unemployed">Unemployed</option>
                                                    <option value="Employer">Employer</option>
                                                    <option value="Internship">Internship</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control" placeholder="Enter company name" required>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Work Email</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="emeka.afolabi@jumia.com" required>
                                                    <button class="btn btn-primary" type="button" id="button-addon2">Send OTP</button>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Verify OTP</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Enter OTP" required>
                                                    <button class="btn btn-primary" type="button" id="button-addon2">Verify</button>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Job Title</label>
                                                <input type="text" class="form-control" placeholder="Enter job title" required>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Salary Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">₦</span>
                                                    <input
                                                    type="text"
                                                    id="salaryAmount"
                                                    class="form-control"
                                                    placeholder="Enter amount"
                                                    required
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Pay Day</label>
                                                <select class="form-select" required>
                                                    <option selected disabled value="">Select pay day</option>
                                                    <option value="1">1st</option>
                                                    <option value="2">2nd</option>
                                                    <option value="3">3rd</option>
                                                    <option value="4">4th</option>
                                                    <option value="5">5th</option>
                                                    <option value="6">6th</option>
                                                    <option value="7">7th</option>
                                                    <option value="8">8th</option>
                                                    <option value="9">9th</option>
                                                    <option value="10">10th</option>
                                                    <option value="11">11th</option>
                                                    <option value="12">12th</option>
                                                    <option value="13">13th</option>
                                                    <option value="14">14th</option>
                                                    <option value="15">15th</option>
                                                    <option value="16">16th</option>
                                                    <option value="17">17th</option>
                                                    <option value="18">18th</option>
                                                    <option value="19">19th</option>
                                                    <option value="20">20th</option>
                                                    <option value="21">21st</option>
                                                    <option value="22">22nd</option>
                                                    <option value="23">23rd</option>
                                                    <option value="24">24th</option>
                                                    <option value="25">25th</option>
                                                    <option value="26">26th</option>
                                                    <option value="27">27th</option>
                                                    <option value="28">28th</option>
                                                    <option value="29">29th</option>
                                                    <option value="30">30th</option>
                                                    <option value="31">31st</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-5 d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-primary prev-step">Previous</button>
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="form-step">
                                        <div class="row g-4">
                                            <div class="col-sm-6">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($user['date_of_birth']) ?>" disabled>
                                            </div>
                                            <div class="col-sm-6">
                                            <label class="form-label">Marital Status</label>
                                            <input type="text" class="form-control" name="marital_status" value="<?= htmlspecialchars($user['marital_status']) ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="mt-5 d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-primary prev-step">Previous</button>
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="form-step">
                                        <div class="row g-4">
                                            <div class="col-sm-6">
                                            <label class="form-label">State of Residence</label>
                                            <input type="text" class="form-control" name="state" value="<?= htmlspecialchars($user['state']) ?>" disabled>
                                            </div>
                                            <div class="col-sm-6">
                                            <label class="form-label">LGA</label>
                                            <input type="text" class="form-control" name="lga" value="<?= htmlspecialchars($user['lga']) ?>" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                            <label class="form-label">Residential Address</label>
                                            <textarea name="address" class="form-control" rows="3" disabled><?= htmlspecialchars($user['residential_address']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="mt-5 d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-primary prev-step">Previous</button>
                                            <a href="support" class="btn btn-primary">Contact admin to update profile</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/switcher.js"></script>

    <script>
        // Format amount input with commas
        const loanAmountInput = document.getElementById("loanAmount");
        loanAmountInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/,/g, ""); // remove commas
            if (!isNaN(value) && value !== "") {
            e.target.value = Number(value).toLocaleString("en-NG");
            } else if (value === "") {
            e.target.value = "";
            }
        });

        // Loan type determines which duration dropdown shows
        const loanTypeSelect = document.getElementById("loanType");
        const payDayContainer = document.getElementById("payDayLoanContainer");
        const personalContainer = document.getElementById("personalLoanContainer");

        loanTypeSelect.addEventListener("change", function () {
            const selected = this.value;

            if (selected === "Pay Day Loan") {
            payDayContainer.classList.remove("d-none");
            personalContainer.classList.add("d-none");
            } else if (selected === "Personal Loan") {
            personalContainer.classList.remove("d-none");
            payDayContainer.classList.add("d-none");
            } else {
            payDayContainer.classList.add("d-none");
            personalContainer.classList.add("d-none");
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.form-step');
            const stepIndicators = document.querySelectorAll('.step');
            let currentStep = 0;

            function updateSteps() {
                steps.forEach((step, i) => step.classList.toggle('active', i === currentStep));
                stepIndicators.forEach((el, i) => {
                el.classList.toggle('active', i === currentStep);
                el.classList.toggle('completed', i < currentStep);
                });
            }

            document.querySelectorAll('.next-step').forEach(btn => {
                btn.addEventListener('click', () => {
                if (currentStep < steps.length - 1) currentStep++;
                updateSteps();
                });
            });

            document.querySelectorAll('.prev-step').forEach(btn => {
                btn.addEventListener('click', () => {
                if (currentStep > 0) currentStep--;
                updateSteps();
                });
            });

            updateSteps();
        });
    </script>

</body>

</html>