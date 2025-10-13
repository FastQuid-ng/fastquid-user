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
                                <h4 class="fw-semibold">Total Balance</h4>
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
                    <div class="card-body pb-0">
                        <div class="mb-2 d-flex align-items-center">
                            <h5>Cards List</h5>
                            <div class="ms-auto text-end"><a href="#" class="text-sm fw-semibold">Edit</a></div>
                        </div>
                        <div class="hstack gap-2 mt-4 mb-6"><button class="btn btn-sm btn-neutral"><i class="bi bi-plus me-2 d-none d-sm-inline-block"></i>New card</button> <button class="btn btn-sm btn-neutral"><i class="bi bi-gear me-2 d-none d-sm-inline-block"></i>Manage</button></div>
                        <div
                            class="surtitle mb-2">My cards</div>
                    <div class="vstack gap-2 mx-n3">
                        <div class="position-relative d-flex align-items-center p-3 rounded-3 bg-body-secondary-hover">
                            <div class="flex-none"><img src="../img/cards/visa.svg" class="w-rem-16 w-md-20 rounded" alt="..."></div>
                            <div class="ms-3 ms-md-4 flex-fill">
                                <div class="stretched-link text-limit text-sm text-heading fw-semibold" role="button" data-bs-toggle="offcanvas" data-bs-target="#cardDetailsOffcanvas" aria-controls="cardDetailsOffcanvas">John Snow - Metal</div>
                                <div class="d-block text-xs gap-2 mt-1"><span>**4291 - Exp: 12/26</span></div>
                            </div>
                            <div class="d-none d-sm-block ms-auto text-end"><span class="badge bg-body-secondary text-success">Active</span>
                                <div class="d-none d-sm-block text-xs text-muted mt-2">Last used: 2 hrs ago</div>
                            </div>
                        </div>
                        <div class="position-relative d-flex align-items-center p-3 rounded-3 bg-body-secondary-hover">
                            <div class="flex-none"><img src="../img/cards/mastercard.svg" class="w-rem-16 w-md-20 rounded" alt="..."></div>
                            <div class="ms-3 ms-md-4 flex-fill">
                                <div class="stretched-link text-limit text-sm text-heading fw-semibold" role="button" data-bs-toggle="offcanvas" data-bs-target="#cardDetailsOffcanvas" aria-controls="cardDetailsOffcanvas">John Snow - Virtual</div>
                                <div class="d-block text-xs gap-2"><span>**4291 - Exp: 12/26</span></div>
                            </div>
                            <div class="d-none d-sm-block ms-auto text-end"><span class="badge bg-body-secondary text-success">Active</span>
                                <div class="d-none d-sm-block text-xs text-muted mt-2">Last used: 2 hrs ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4">
        <div class="offcanvas-xxl m-xxl-0 rounded-sm-4 rounded-xxl-0 offcanvas-end overflow-hidden m-sm-4" tabindex="-1" id="responsiveOffcanvas" aria-labelledby="responsiveOffcanvasLabel">
            <div class="offcanvas-header rounded-top-4 bg-light">
                <h5 class="offcanvas-title" id="responsiveOffcanvasLabel">Quick Stats</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#responsiveOffcanvas" aria-label="Close"></button></div>
            <div class="offcanvas-body d-flex flex-column p-3 p-sm-6 p-xxl-0 gap-3 gap-xxl-6">
                <div class="vstack gap-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div>
                                    <h5>Recent transactions</h5>
                                </div>
                                <div class="hstack align-items-center"><a href="#" class="text-muted"><i class="bi bi-arrow-repeat"></i></a></div>
                            </div>
                            <div class="vstack gap-6">
                                <div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon icon-shape flex-none text-base text-bg-dark rounded-circle"><img src="../img/crypto/white/btc.svg" class="w-rem-6 h-rem-6" alt="..."></div>
                                        <div>
                                            <h6 class="progress-text mb-1 d-block">Bitcoin</h6>
                                            <p class="text-muted text-xs">Pending - 3 min ago</p>
                                        </div>
                                        <div class="text-end ms-auto"><span class="h6 text-sm">-1,500 USD</span></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon icon-shape flex-none text-base text-bg-dark rounded-circle"><img src="../img/crypto/white/ada.svg" class="w-rem-6 h-rem-6" alt="..."></div>
                                        <div>
                                            <h6 class="progress-text mb-1 d-block">Cardano</h6>
                                            <p class="text-muted text-xs">Canceled - 3 min ago</p>
                                        </div>
                                        <div class="text-end ms-auto"><span class="h6 text-sm">-1,500 USD</span></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon icon-shape flex-none text-base text-bg-dark rounded-circle"><img src="../img/crypto/white/bnb.svg" class="w-rem-6 h-rem-6" alt="..."></div>
                                        <div>
                                            <h6 class="progress-text mb-1 d-block">Binance</h6>
                                            <p class="text-muted text-xs">Pending - 3 min ago</p>
                                        </div>
                                        <div class="text-end ms-auto"><span class="h6 text-sm">-1,500 USD</span></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon icon-shape flex-none text-base text-bg-dark rounded-circle"><img src="../img/crypto/white/btc.svg" class="w-rem-6 h-rem-6" alt="..."></div>
                                        <div>
                                            <h6 class="progress-text mb-1 d-block">Bitcoin</h6>
                                            <p class="text-muted text-xs">Pending - 3 min ago</p>
                                        </div>
                                        <div class="text-end ms-auto"><span class="h6 text-sm">-1,500 USD</span></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon icon-shape flex-none text-base text-bg-dark rounded-circle"><img src="../img/crypto/white/btc.svg" class="w-rem-6 h-rem-6" alt="..."></div>
                                        <div>
                                            <h6 class="progress-text mb-1 d-block">Bitcoin</h6>
                                            <p class="text-muted text-xs">Pending - 3 min ago</p>
                                        </div>
                                        <div class="text-end ms-auto"><span class="h6 text-sm">-1,500 USD</span></div>
                                    </div>
                                </div>
                            </div>
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

            let isVisible = true;
            const actualBalance = balanceAmount.textContent; // store real balance

            toggleBtn.addEventListener('click', function () {
            if (isVisible) {
                balanceAmount.textContent = '₦********';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                balanceAmount.textContent = actualBalance;
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
            isVisible = !isVisible;
            });
        });
    </script>
</body>

</html>