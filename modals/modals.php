    <div class="modal fade" id="depositLiquidityModal" tabindex="-1" aria-labelledby="depositLiquidityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content overflow-hidden">
                <div class="modal-header pb-0 border-0">
                    <h1 class="modal-title h4" id="depositLiquidityModalLabel">Deposit liquidity</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body undefined">
                    <form class="vstack gap-6">
                        <div class="vstack gap-1">
                            <div class="bg-body-secondary rounded-3 p-4">
                                <div class="d-flex justify-content-between text-xs text-muted"><span class="fw-semibold">From</span> <span>Balance: 10,000 ADA</span></div>
                                <div class="d-flex justify-content-between gap-2 mt-4"><input type="tel" class="form-control form-control-flush text-xl fw-bold flex-fill" placeholder="0.00"> <button class="btn btn-neutral shadow-none rounded-pill flex-none d-flex align-items-center gap-2 py-2 ps-2 pe-4"><img src="../img/crypto/color/ada.svg" class="w-rem-6 h-rem-6" alt="..."> <span class="text-xs fw-semibold text-heading ms-1">ADA</span></button></div>
                            </div>
                            <div class="position-relative text-center my-n4 overlap-10">
                                <div class="icon icon-sm icon-shape bg-body shadow-soft-3 rounded-circle text-sm text-body-tertiary"><i class="bi bi-arrow-down-up"></i></div>
                            </div>
                            <div class="bg-body-secondary rounded-3 p-4">
                                <div class="d-flex justify-content-between text-xs text-muted"><span class="fw-semibold">To</span> <span>Balance: 0 SUN</span></div>
                                <div class="d-flex justify-content-between gap-2 mt-4"><input type="tel" class="form-control form-control-flush text-xl fw-bold flex-fill" placeholder="0.00"> <button class="btn btn-neutral shadow-none rounded-pill flex-none d-flex align-items-center gap-2 py-2 ps-2 pe-4"><img src="../img/pools/pool-1.png" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span class="text-xs fw-semibold text-heading ms-1">SUN</span></button></div>
                            </div>
                        </div>
                        <div><label class="form-label">Slippage tolerance</label>
                            <div class="d-flex flex-wrap gap-1 gap-sm-2">
                                <div class="w-sm-56 input-group input-group-sm input-group-inline"><input type="search" class="form-control" placeholder="1"> <span class="input-group-text">%</span></div>
                                <div class="flex-fill"><input type="radio" class="btn-check" name="options" id="option1" checked="checked"> <label class="btn btn-sm btn-neutral w-100" for="option1">0.5%</label></div>
                                <div class="flex-fill"><input type="radio" class="btn-check" name="options" id="option2" checked="checked"> <label class="btn btn-sm btn-neutral w-100" for="option2">1%</label></div>
                                <div class="flex-fill"><input type="radio" class="btn-check" name="options" id="option3" checked="checked"> <label class="btn btn-sm btn-neutral w-100" for="option3">3%</label></div>
                            </div>
                        </div><button type="button" class="btn btn-primary w-100">Provide liquidity</button></form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="connectWalletModal" tabindex="-1" aria-labelledby="connectWalletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content overflow-hidden">
                <div class="modal-header pb-0 border-0">
                    <h1 class="modal-title h4" id="connectWalletModalLabel">Connect your wallet</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body undefined">
                    <div class="list-group list-group-flush gap-2">
                        <div class="list-group-item border rounded d-flex gap-3 p-4 bg-body-secondary-hover">
                            <div class="icon flex-none"><img src="../img/wallets/metamask.png" class="w-rem-8 h-rem-8" alt="..."></div>
                            <div class="d-flex align-items-center flex-fill">
                                <div><a href="#" class="stretched-link text-heading text-sm fw-bold">MetaMask</a></div>
                                <div class="ms-auto"><span class="badge badge-md text-bg-primary">Popular</span></div>
                            </div>
                        </div>
                        <div class="list-group-item border rounded d-flex gap-3 p-4 bg-body-secondary-hover">
                            <div class="icon flex-none"><img src="../img/wallets/coinbase.webp" class="w-rem-8 h-rem-8" alt="..."></div>
                            <div class="d-flex align-items-center flex-fill">
                                <div><a href="#" class="stretched-link text-heading text-sm fw-bold">Coinbase Wallet</a></div>
                            </div>
                        </div>
                        <div class="list-group-item border rounded d-flex gap-3 p-4 bg-body-secondary-hover">
                            <div class="icon flex-none"><img src="../img/wallets/walletconnect.png" class="w-rem-8 h-rem-8" alt="..."></div>
                            <div class="d-flex align-items-center flex-fill">
                                <div><a href="#" class="stretched-link text-heading text-sm fw-bold">WalletConnect</a></div>
                            </div>
                        </div>
                        <div class="list-group-item border rounded d-flex gap-3 p-4 bg-body-secondary-hover">
                            <div class="icon flex-none"><img src="../img/wallets/phantom.png" class="w-rem-8 h-rem-8" alt="..."></div>
                            <div class="d-flex align-items-center flex-fill">
                                <div><a href="#" class="stretched-link text-heading text-sm fw-bold">Phantom</a></div>
                                <div class="ms-auto"><span class="badge badge-md text-bg-light">Solana</span></div>
                            </div>
                        </div>
                        <div class="list-group-item border rounded d-flex gap-3 p-4 bg-body-secondary-hover">
                            <div class="icon flex-none"><img src="../img/wallets/core.png" class="w-rem-8 h-rem-8" alt="..."></div>
                            <div class="d-flex align-items-center flex-fill">
                                <div><a href="#" class="stretched-link text-heading text-sm fw-bold">Core</a></div>
                                <div class="ms-auto"><span class="badge badge-md text-bg-light">Avalanche</span></div>
                            </div>
                        </div>
                        <div class="list-group-item border rounded d-flex gap-3 p-4 bg-body-secondary-hover">
                            <div class="icon flex-none"><img src="../img/wallets/glow.svg" class="w-rem-8 h-rem-8" alt="..."></div>
                            <div class="d-flex align-items-center flex-fill">
                                <div><a href="#" class="stretched-link text-heading text-sm fw-bold">Glow</a></div>
                                <div class="ms-auto"><span class="badge badge-md text-bg-light">Solana</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-xs text-muted mt-6">By connecting wallet, you agree to Satoshi's <a href="#" class="fw-bold">Terms of Service</a></div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content overflow-hidden">
                <div class="modal-header pb-0 border-0">
                    <h1 class="modal-title h4" id="addCardModalLabel">Add a new card</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body undefined">
                    <form>
                        <div class="row g-5 mb-5">
                            <div class="col-md-12">
                                <div class=""><label class="form-label" for="email">Email</label> <input type="email" class="form-control" id="email" placeholder="Your email"></div>
                            </div>
                            <div class="col-md-12">
                                <div class=""><label class="form-label">Card details</label>
                                    <div class="input-group input-group-inline"><span class="input-group-text"><i class="bi bi-credit-card"></i> </span><input type="tel" class="form-control pe-4" placeholder="Number"> <input type="tel" class="form-control w-rem-16 w-md-20 flex-none" placeholder="MM/YY"
                                            maxlength="4"> <input type="tel" class="form-control w-rem-16 w-md-20 flex-none" placeholder="CVC" maxlength="3"></div><span class="mt-2 valid-feedback">Looks good!</span></div>
                            </div>
                            <div class="col-md-12">
                                <div class=""><label class="form-label" for="cardholder">Cardholder name</label> <input type="text" class="form-control" id="cardholder" placeholder="Name on card"></div>
                            </div>
                            <div class="col-md-12"><label class="form-label">Address</label>
                                <div class="row g-2">
                                    <div class="col-12"><label for="inputStreet" class="visually-hidden">Street</label> <input type="text" id="inputStreet" class="form-control" placeholder="Street, number"></div>
                                    <div class="col-6"><label for="inputCountry" class="visually-hidden">Country</label> <input type="text" id="inputCountry" class="form-control" placeholder="Country"></div>
                                    <div class="col-6"><label for="inputCity" class="visually-hidden">City</label> <input type="text" id="inputCity" class="form-control" placeholder="City"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6"><button type="button" class="btn btn-primary w-100" data-bs-target="#topUpModal" data-bs-toggle="modal">Add card</button>
                            <div class="d-flex align-items-center justify-content-center text-center mt-5 mb-2 text-muted text-sm"><i class="bi bi-lock me-2"></i> All credit cards information are encrypted.</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="topUpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content overflow-hidden">
                <div class="modal-header pb-0 border-0">
                    <h1 class="modal-title h4" id="topUpModalLabel">Fund your account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body undefined">
                    <form class="vstack gap-8">
                        <div>
                            <label class="form-label">I want to spend</label>
                            <div class="d-flex justify-content-between p-4 bg-body-tertiary border rounded"><input type="tel" class="form-control form-control-flush text-xl fw-bold w-rem-40" placeholder="0.00">
                                <div class="dropdown"><button class="btn btn-sm btn-neutral rounded-pill shadow-none flex-none d-flex align-items-center gap-2 p-2" data-bs-toggle="dropdown" aria-expanded="false"><img src="../img/flags/eu.svg" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span>EUR</span> <i class="bi bi-chevron-down text-xs me-1"></i></button>
                                    <ul
                                        class="dropdown-menu dropdown-menu-end dropdown-menu-sm">
                                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><img src="../img/flags/us.svg" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span>USD</span></a></li>
                                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><img src="../img/flags/eu.svg" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span>EUR</span> <span class="ms-auto text-success text-lg"><i class="bi bi-check"></i></span></a></li>
                                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><img src="../img/flags/gb.svg" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span>GBP</span></a></li>
                                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><img src="../img/flags/au.svg" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span>AUD</span></a></li>
                                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><img src="../img/flags/ro.svg" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span>RON</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Select card</label>
                            <div class="vstack gap-2">
                                <div class="">
                                    <input type="radio" name="cards" class="btn-check" id="btnCardCheck1">
                                    <label for="btnCardCheck1" class="btn btn-outline-light shadow-none border-primary-hover test-reset d-flex align-items-center p-4 text-start">
                                        <img src="../img/cards/visa.svg" class="w-rem-16 rounded" alt="..."> 
                                        <span class="ms-4 flex-fill text-muted">
                                            <span class="d-block text-sm mb-1">Visa: 
                                                <span class="fw-semibold">4291</span>
                                            </span>
                                            <span class="d-block text-sm">Exp. date: 
                                                <span class="fw-semibold text-heading">12/26</span> 
                                            </span>
                                        </span>
                                        <span class="ms-auto">
                                            <a href="#" class="text-muted text-danger-hover text-base"><i class="bi bi-trash"></i></a>
                                        </span>
                                    </label>
                                </div>
                                <div class="">
                                    <input type="radio" name="cards" class="btn-check" id="btnCardCheck2"> 
                                    <label for="btnCardCheck2" class="btn btn-outline-light shadow-none border-primary-hover test-reset d-flex align-items-center p-4 text-start">
                                        <span><img src="../img/cards/mastercard.svg" class="w-rem-16 rounded" alt="..."> </span>
                                        <span class="ms-4 flex-fill text-muted">
                                            <span class="d-block text-sm mb-1">Visa: 
                                                <span class="fw-semibold">4291</span>
                                            </span>
                                            <span class="d-block text-sm">Exp. date: 
                                                <span class="fw-semibold text-heading">12/26</span> 
                                            </span>
                                        </span>
                                        <span class="ms-auto">
                                            <a href="#" class="text-muted text-danger-hover text-base"><i class="bi bi-trash"></i></a>
                                        </span>
                                    </label>
                                </div>
                                <div class="d-flex py-4">
                                    <a href="#addCardModal" data-bs-toggle="modal" class="text-sm link-primary fw-semibold"><i class="bi bi-credit-card me-2"></i>Add a new card</a>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary w-100">Deposit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>