<?php
$pageTitle = 'bank';
include "./components/header.php"; 

require_once __DIR__ . '/config/db.php';

// Fetch user bank accounts
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM user_bank_accounts WHERE user_id = ? ORDER BY is_primary DESC");
$stmt->execute([$user_id]);
$bankAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                                <h1 class="ls-tight">Bank</h1>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-flush gap-6 overflow-x border-0 mt-4">
                            <li class="nav-item"><a href="profile" class="nav-link">Profile</a></li>
                            <li class="nav-item"><a href="security" class="nav-link">Security</a></li>
                            <li class="nav-item"><a href="bank" class="nav-link active">Bank</a></li>
                        </ul>
                    </header>

                    <div class="row g-6 align-items-end justify-content-between">
                        <div class="col">
                            <h4 class="fw-semibold mb-1">Bank Details</h4>
                            <p class="text-sm text-muted">This is the bank account for receiving your loan disbursement.</p>
                        </div>
                        <div class="col-12 col-sm-auto">
                            <div class="hstack gap-2">
                                <button type="button" data-bs-target="#bankAccountModal" data-bs-toggle="modal" class="btn btn-sm btn-primary">Add Bank Account</button>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-6 mb-6">

                    <div class="vstack gap-5">
                        <div class="row">
                            <?php foreach ($bankAccounts as $bank): ?>
                            <div class="col-md-6 mb-5">
                                <div class="card bg-warning bg-opacity-10 border-warning border-opacity-40"
                                    id="bank-card-<?= $bank['id'] ?>"
                                    style="position: relative; overflow: hidden; z-index: 1;">

                                    <!-- Background Image -->
                                    <div class="card-bg"
                                        style="
                                            position:absolute;
                                            top:0; left:0; right:0; bottom:0;
                                            background-image:url('./assets/img/bank_icon.svg');
                                            background-size: contain;
                                            background-repeat: no-repeat;
                                            background-position: 135% 85%;
                                            opacity:0.18;
                                            z-index:0;
                                        ">
                                    </div>

                                    <!-- Foreground content -->
                                    <div class="position-relative p-6 overlap-10" style="z-index: 1;">

                                        <div class="row justify-content-between align-items-center">
                                            <div class="col">
                                                <?php if ($bank['is_primary'] == 1): ?>
                                                    <span class="badge bg-warning text-white">Primary</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Secondary</span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-auto">
                                                <a href="#" 
                                                    class="deleteBankBtn"
                                                    data-id="<?= $bank['id'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteBankAccountModal">
                                                    <img src="./assets/img/trash_icon.svg" class="h-rem-10" alt="Delete">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="mt-8 mb-6">
                                            <span class="surtitle text-dark text-opacity-60">Account Number</span>
                                            <div class="d-flex gap-4 h1 fw-bold">
                                                <?= htmlspecialchars($bank['account_number']) ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <span class="surtitle text-dark text-opacity-60">Account Name</span>
                                                <span class="d-block h6"><?= htmlspecialchars($bank['account_name']) ?></span>
                                            </div>

                                            <div class="col">
                                                <span class="surtitle text-dark text-opacity-60">Bank Name</span>
                                                <span class="d-block h6"><?= htmlspecialchars($bank['bank_name']) ?></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <?php
        include "./modals/bank-modal.php";
        include "./modals/delete-modal.php";
    ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/switcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteButtons = document.querySelectorAll(".deleteBankBtn");
            const deleteBankIdInput = document.getElementById("deleteBankId");
            const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            const notyf = new Notyf();

            deleteButtons.forEach(btn => {
                btn.addEventListener("click", function () {
                    deleteBankIdInput.value = this.dataset.id;
                });
            });

            confirmDeleteBtn.addEventListener("click", async () => {
                const bankId = deleteBankIdInput.value;
                confirmDeleteBtn.disabled = true;

                try {
                    const res = await fetch("./auth/delete_bank_account_auth.php", {
                        method: "POST",
                        body: new URLSearchParams({ bank_id: bankId })
                    });

                    if (!res.ok) throw new Error(`HTTP error: ${res.status}`);

                    const data = await res.json(); // Safe parsing

                    if (data.status) {
                        notyf.success(data.message);

                        const modalElement = document.getElementById("deleteBankAccountModal");
                        let modal = null;

                        if (window.bootstrap) {
                            modal = bootstrap.Modal.getInstance(modalElement);
                            if (modal) modal.hide();
                        }

                        if (data.refresh) {
                            setTimeout(() => location.reload(), 800);
                        } else {
                            document.getElementById("bank-card-" + bankId)?.remove();
                        }

                    } else {
                        notyf.error(data.message);
                    }

                } catch (err) {
                    console.error("FETCH ERROR:", err);
                    notyf.error("Network or server error");
                } finally {
                    confirmDeleteBtn.disabled = false;
                }
            });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const bankSelect = document.getElementById("bankSelect");
            const accountNumber = document.getElementById("accountNumber");
            const accountName = document.getElementById("accountName");
            const accountNameHidden = document.getElementById("accountNameHidden");
            const bankNameHidden = document.getElementById("bankNameHidden"); // This is now only here
            const submitBtn = document.getElementById("submitBankBtn");

            // Load banks
            fetch("./auth/get_banks_auth.php")
                .then(res => res.json())
                .then(data => {
                    if (Array.isArray(data.data)) {
                        data.data.forEach(bank => {
                            const option = document.createElement("option");
                            option.value = bank.code;
                            option.textContent = bank.name;
                            bankSelect.appendChild(option);
                        });
                    }
                });

            // Handle change in bank selection
            bankSelect.addEventListener("change", () => {
                const selected = bankSelect.selectedOptions[0];
                // Ensure we get the bank name correctly
                accountNameHidden.value = selected ? selected.textContent : "";  // Set account name hidden field
                bankNameHidden.value = selected ? selected.textContent : "";     // Set bank name hidden field

                console.log("Bank Name Hidden:", bankNameHidden.value);  // Debugging

                accountName.value = "";  // Reset account name
                submitBtn.disabled = true; // Disable submit button until account is verified
            });

            // Function to show a toast message
            function showToast(message, success = false) {
                const notyf = new Notyf({ duration: 3500, position: { x: "right", y: "top" }, ripple: true });
                success ? notyf.success(message) : notyf.error(message);
            }

            // Verify account number when user types
            accountNumber.addEventListener("keyup", () => {
                const bankCode = bankSelect.value;
                const accNum = accountNumber.value;

                submitBtn.disabled = true; // Disable until verified

                if (bankCode && accNum.length === 10) {
                    accountName.value = "Verifying...";
                    accountNameHidden.value = ""; // Reset hidden value during verification

                    fetch(`./auth/verify_bank_account_auth.php?account_number=${accNum}&bank_code=${bankCode}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                accountName.value = data.data.account_name;
                                accountNameHidden.value = data.data.account_name; // Store the actual account name
                                showToast("Account verified!", true);
                                submitBtn.disabled = false; // Enable submit button after successful verification
                            } else {
                                accountName.value = "";
                                accountNameHidden.value = "";
                                showToast("Invalid bank account details");
                                submitBtn.disabled = true; // Disable if verification fails
                            }
                        })
                        .catch(() => {
                            accountName.value = "";
                            accountNameHidden.value = "";
                            showToast("Verification error");
                            submitBtn.disabled = true;
                        });
                } else {
                    accountName.value = "";
                    accountNameHidden.value = "";
                    submitBtn.disabled = true;
                }
            });

            // Submit form
            document.getElementById("bankForm").addEventListener("submit", e => {
                e.preventDefault();
                submitBtn.disabled = true; // Disable the submit button to prevent multiple submissions

                const formData = new FormData(e.target);

                // Debugging: Log each key-value pair of the FormData
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                fetch("./auth/save_bank_account_auth.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    submitBtn.disabled = false; // Re-enable the submit button after submission
                    if (data.status) {
                        showToast(data.message, true); // Success message
                        setTimeout(() => location.reload(), 1200); // Reload the page after 1.2 seconds
                    } else {
                        showToast(data.message); // Error message
                    }
                })
                .catch(() => {
                    submitBtn.disabled = false;
                    showToast("Network error");
                });
            });
        });
    </script>
</body>                                                             
</html>
