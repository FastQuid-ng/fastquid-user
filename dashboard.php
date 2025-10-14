<?php
include "./components/header.php";
?>
    <div class="d-flex flex-column flex-lg-row h-lg-100 gap-1">
        <?php include "./components/side-nav.php"; ?>

        <div class="flex-lg-fill overflow-x-auto ps-lg-1 vstack vh-lg-100 position-relative">
            <?php include "./components/top-nav.PHP"; ?>

            <div class="flex-fill overflow-y-lg-auto scrollbar bg-body rounded-top-4 rounded-top-start-lg-4 rounded-top-end-lg-0 border-top border-lg shadow-2">
                <main class="container-fluid px-3 py-5 p-lg-6 p-xxl-8">
                    <div class="mb-6 mb-xl-10">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h1 class="ls-tight"><span style="font-weight: 300">Hello,</span> <?= $firstName ?></h1>
                                <span class="eyebrow mb-1" id="greet"></span>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row g-3 g-xl-6">
                        <div class="col-xxl-8">
                            <div class="vstack gap-3 gap-xl-6">
                                <div class="card bg-danger bg-opacity-10 border-danger border-opacity-40">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div>
                                                <div class="hstack gap-3 mb-1">
                                                    <h4 class="fw-semibold">Loan Balance</h4>
                                                    <a href="javascript:void(0);" id="toggle-balance">
                                                        <i class="bi bi-eye" id="eye-icon"></i>
                                                    </a>
                                                </div>
                                                <div class="text-2xl text-heading fw-bolder ls-tight" id="balance-amount">₦23,000.48</div>
                                            </div>
                                            <div class="ms-auto align-self-end">
                                                <button type="button" class="btn btn-sm btn-danger">Get a Loan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body pb-5">
                                        <div class="mb-2 d-flex align-items-center">
                                            <h5>My Loan</h5>
                                            <div class="ms-auto text-end">
                                                <a href="loan" class="text-sm fw-semibold">View all</a>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="vstack gap-2 mx-n3">
                                            <div class="position-relative d-flex align-items-center p-3 rounded-3 bg-body-secondary-hover">
                                                <div class="d-none d-xl-inline-flex icon icon-shape w-rem-8 h-rem-8 rounded-circle text-sm bg-secondary bg-opacity-25 text-secondary">
                                                    <i class="bi bi-currency-exchange"></i>
                                                </div>
                                                <div class="ms-3 ms-md-4 flex-fill">
                                                    <div class="stretched-link text-limit text-sm text-heading fw-semibold" role="button" data-bs-toggle="offcanvas" data-bs-target="#cardDetailsOffcanvas" aria-controls="cardDetailsOffcanvas">John Snow - Metal</div>
                                                    <div class="d-block text-xs gap-2 mt-1"><span>**4291 - Exp: 12/26</span></div>
                                                </div>
                                                <div class="d-none d-sm-block ms-auto text-end">
                                                    <span class="badge bg-success bg-opacity-25 text-success">Active</span>
                                                    <div class="d-none d-sm-block text-xs text-muted mt-2">Last used: 2 hrs ago</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vstack gap-2 mx-n3">
                                            <div class="position-relative d-flex align-items-center p-3 rounded-3 bg-body-secondary-hover">
                                                <div class="d-none d-xl-inline-flex icon icon-shape w-rem-8 h-rem-8 rounded-circle text-sm bg-danger bg-opacity-25 text-danger">
                                                    <i class="bi bi-currency-exchange"></i>
                                                </div>
                                                <div class="ms-3 ms-md-4 flex-fill">
                                                    <div class="stretched-link text-limit text-sm text-heading fw-semibold" role="button" data-bs-toggle="offcanvas" data-bs-target="#cardDetailsOffcanvas" aria-controls="cardDetailsOffcanvas">John Snow - Metal</div>
                                                    <div class="d-block text-xs gap-2 mt-1"><span>**4291 - Exp: 12/26</span></div>
                                                </div>
                                                <div class="d-none d-sm-block ms-auto text-end">
                                                    <span class="badge bg-warning bg-opacity-25 text-warning">Pending</span>
                                                    <div class="d-none d-sm-block text-xs text-muted mt-2">Last used: 2 hrs ago</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4">
                            <div class="vstack gap-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <div>
                                                <h5>Loan Calculator</h5>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="vstack gap-6">
                                            <div>
                                                <form id="loanForm">
                                                    <div class="row g-5">
                                                        <!-- Loan Amount -->
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="loanAmount" placeholder="Enter loan amount" required>
                                                        </div>

                                                        <!-- Loan Type -->
                                                        <div class="col-sm-12">
                                                            <select class="form-select" id="loanType" required>
                                                                <option disabled selected value="">Select Loan Type</option>
                                                                <option value="payday">Payday Loan</option>
                                                                <option value="personal">Personal Loan</option>
                                                            </select>
                                                        </div>

                                                        <!-- Payday Loan Duration -->
                                                        <div class="col-sm-12" id="paydayDurationDiv" style="display: none;">
                                                            <select class="form-select" id="paydayDuration">
                                                                <option disabled selected value="">Select Duration</option>
                                                                <option value="1">1 Month</option>
                                                                <!-- <option value="2">2 Months</option>
                                                                <option value="3">3 Months</option> -->
                                                            </select>
                                                        </div>

                                                        <!-- Personal Loan Duration -->
                                                        <div class="col-sm-12" id="personalDurationDiv" style="display: none;">
                                                        <select class="form-select" id="personalDuration">
                                                            <option disabled selected value="">Select Duration</option>
                                                            <option value="2">2 Months</option>
                                                            <option value="3">3 Months</option>
                                                            <option value="4">4 Months</option>
                                                            <option value="5">5 Months</option>
                                                            <option value="6">6 Months</option>
                                                        </select>
                                                        </div>

                                                        <!-- Repayment Result -->
                                                        <div class="col-sm-12 text-center">
                                                        <p>Repayment Amount</p>
                                                        <h2 class="ls-tight" id="repaymentAmount">₦0.00</h2>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        //Greet User
        var time = new Date().getHours();
        if (time < 4) {
            greeting = "You should be in bed 🙄!";
        }  else if (time < 12) {
            greeting = "Good morning, wash your hands 🌤";
        } else if (time < 16) {
            greeting = "It's lunch 🍛 time, what's on the menu!";
        } else {
            greeting = "Good Evening 🌙, how was your day?";
        }
        document.getElementById("greet").innerHTML = greeting;
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggle-balance');
            const balanceAmount = document.getElementById('balance-amount');
            const eyeIcon = document.getElementById('eye-icon');
            const actualBalance = balanceAmount.textContent.trim();

            // Check stored preference
            let isVisible = localStorage.getItem('showBalance') === 'true';

            // Initialize display based on saved preference
            if (!isVisible) {
            balanceAmount.textContent = '₦•••••••';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
            }

            toggleBtn.addEventListener('click', function () {
            isVisible = !isVisible;
            if (isVisible) {
                balanceAmount.textContent = actualBalance;
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                balanceAmount.textContent = '₦•••••••';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }

            // Save preference
            localStorage.setItem('showBalance', isVisible);
            });
        });
    </script>

    <script>
        const loanAmountInput = document.getElementById('loanAmount');
        const loanTypeSelect = document.getElementById('loanType');
        const paydayDiv = document.getElementById('paydayDurationDiv');
        const personalDiv = document.getElementById('personalDurationDiv');
        const paydaySelect = document.getElementById('paydayDuration');
        const personalSelect = document.getElementById('personalDuration');
        const repaymentText = document.getElementById('repaymentAmount');

        // Format input with commas as user types
        loanAmountInput.addEventListener('input', function(e) {
            const rawValue = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            calculateRepayment();
        });

        // Show/hide duration based on loan type
        loanTypeSelect.addEventListener('change', () => {
            paydayDiv.style.display = loanTypeSelect.value === 'payday' ? 'block' : 'none';
            personalDiv.style.display = loanTypeSelect.value === 'personal' ? 'block' : 'none';
            calculateRepayment();
        });

        // Listen for changes
        [loanTypeSelect, paydaySelect, personalSelect].forEach(el => {
            el.addEventListener('input', calculateRepayment);
        });

        function calculateRepayment() {
            const amountStr = loanAmountInput.value.replace(/,/g, '');
            const amount = parseFloat(amountStr) || 0;
            const type = loanTypeSelect.value;
            let months = 0;
            let rate = 0;

            if (type === 'payday') {
            months = parseInt(paydaySelect.value) || 0;
            rate = 7.5;
            } else if (type === 'personal') {
            months = parseInt(personalSelect.value) || 0;
            rate = 5;
            }

            if (amount > 0 && months > 0 && rate > 0) {
            const total = amount + (amount * (rate / 100) * months);
            const hasDecimal = total % 1 !== 0; // check if there’s a decimal part
            repaymentText.textContent = hasDecimal 
                ? `₦${total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
                : `₦${Math.round(total).toLocaleString()}`;
            } else {
            repaymentText.textContent = '₦0.00';
            }
        }
    </script>

</body>

</html>