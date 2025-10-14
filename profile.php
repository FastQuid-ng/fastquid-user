<?php
include "./components/header.php";
?>
    <div class="d-flex flex-column flex-lg-row h-lg-100 gap-1">
        <?php include "./components/side-nav.php"; ?>
        
        <div class="flex-lg-fill overflow-x-auto ps-lg-1 vstack vh-lg-100 position-relative">
            <div class="d-none d-lg-flex py-3">
                <div class="flex-none">
                    <div class="input-group input-group-sm input-group-inline w-rem-64 rounded-pill"><span class="input-group-text rounded-start-pill"><i class="bi bi-search me-2"></i> </span><input type="search" class="form-control ps-0 rounded-end-pill" placeholder="Search" aria-label="Search"></div>
                </div>
                <div class="d-lg-none d-xxl-flex align-items-center gap-4 px-4 scrollable-x">
                    <div class="d-flex gap-2 text-xs"><span class="text-heading fw-semibold">Cryptos:</span> <span class="text-muted">21,713</span></div>
                    <div class="d-flex gap-2 text-xs"><span class="text-heading fw-semibold">Market Cap:</span> <span class="text-muted">$871,322,862,585</span></div>
                    <div class="d-flex gap-2 text-xs"><span class="text-heading fw-semibold">24h Vol:</span> <span class="text-muted">$180,639,667,232</span></div>
                </div>
                <div class="hstack flex-fill justify-content-end flex-nowrap gap-6 ms-auto px-6 px-xxl-8"><button type="button" class="btn btn-xs btn-primary rounded-pill text-nowrap" data-bs-target="#connectWalletModal" data-bs-toggle="modal">Connect</button>
                    <div class="dropdown d-none"><a href="#" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-sun-fill"></i></a>
                        <div class="dropdown-menu"><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">Light</button> <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">Dark</button>
                            <button
                                type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto">System</button>
                        </div>
                    </div>
                    <div class="dropdown"><a href="#" class="nav-link" id="dropdown-notifications" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-bell"></i></a>
                        <div class="dropdown-menu dropdown-menu-end px-2" aria-labelledby="dropdown-notifications">
                            <div class="dropdown-item d-flex align-items-center">
                                <h6 class="dropdown-header px-0">Notifications</h6><a href="#" class="text-sm fw-semibold ms-auto">Clear all</a></div>
                            <div class="dropdown-item py-3 d-flex">
                                <div>
                                    <div class="avatar bg-primary text-white rounded-circle">RF</div>
                                </div>
                                <div class="flex-fill ms-3">
                                    <div class="text-sm lg-snug w-rem-64 text-wrap"><a href="#" class="fw-semibold text-heading text-primary-hover">Robert</a> sent a message to <a href="#" class="fw-semibold text-heading text-primary-hover">Webpixels</a></div><span class="text-muted text-xs">30 mins ago</span></div>
                            </div>
                            <div class="dropdown-item py-3 d-flex">
                                <div><img src="../img/people/img-1.jpg" class="avatar rounded-circle" alt="..."></div>
                                <div class="flex-fill ms-3">
                                    <div class="text-sm lg-snug w-rem-64 text-wrap"><a href="#" class="fw-semibold text-heading text-primary-hover">Robert</a> sent a message to <a href="#" class="fw-semibold text-heading text-primary-hover">Webpixels</a></div><span class="text-muted text-xs">30 mins ago</span></div>
                            </div>
                            <div class="dropdown-item py-3 d-flex">
                                <div><img src="../img/people/img-2.jpg" class="avatar rounded-circle" alt="..."></div>
                                <div class="flex-fill ms-3">
                                    <div class="text-sm lg-snug w-rem-64 text-wrap"><a href="#" class="fw-semibold text-heading text-primary-hover">Robert</a> sent a message to <a href="#" class="fw-semibold text-heading text-primary-hover">Webpixels</a></div><span class="text-muted text-xs">30 mins ago</span></div>
                            </div>
                            <div class="dropdown-item py-3 d-flex">
                                <div>
                                    <div class="avatar bg-success text-white rounded-circle">KW</div>
                                </div>
                                <div class="flex-fill ms-3">
                                    <div class="text-sm lg-snug w-rem-64 text-wrap"><a href="#" class="fw-semibold text-heading text-primary-hover">Robert</a> sent a message to <a href="#" class="fw-semibold text-heading text-primary-hover">Webpixels</a></div><span class="text-muted text-xs">30 mins ago</span></div>
                            </div>
                            <div class="dropdown-item py-3 d-flex">
                                <div><img src="../img/people/img-4.jpg" class="avatar rounded-circle" alt="..."></div>
                                <div class="flex-fill ms-3">
                                    <div class="text-sm lg-snug w-rem-64 text-wrap"><a href="#" class="fw-semibold text-heading text-primary-hover">Robert</a> sent a message to <a href="#" class="fw-semibold text-heading text-primary-hover">Webpixels</a></div><span class="text-muted text-xs">30 mins ago</span></div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item py-2 text-center"><a href="#" class="fw-semibold text-muted text-primary-hover">View all</a></div>
                        </div>
                    </div>
                    <div class="dropdown"><a class="avatar avatar-sm text-bg-dark rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false"><img src="../img/memoji/memoji-1.svg"></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header"><span class="d-block text-sm text-muted mb-1">Signed in as</span> <span class="d-block text-heading fw-semibold">Alexis Enache</span></div>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="bi bi-house me-3"></i>Home </a><a class="dropdown-item" href="#"><i class="bi bi-pencil me-3"></i>Edit profile</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="bi bi-gear me-3"></i>Settings </a><a class="dropdown-item" href="#"><i class="bi bi-image me-3"></i>Media </a><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-up me-3"></i>Share</a>
                            <div
                                class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="bi bi-person me-3"></i>Login</a></div>
                </div>
            </div>
        </div>
    <div class="flex-fill overflow-y-lg-auto scrollbar bg-body rounded-top-4 rounded-top-start-lg-4 rounded-top-end-lg-0 border-top border-lg shadow-2">
        <main class="container-fluid px-3 py-5 p-lg-6 p-xxl-8">
            <header class="border-bottom mb-10">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-12">
                        <h1 class="ls-tight">Account Settings</h1>
                    </div>
                </div>
                <ul class="nav nav-tabs nav-tabs-flush gap-6 overflow-x border-0 mt-4">
                    <li class="nav-item"><a href="account-general.html" class="nav-link active">General</a></li>
                    <li class="nav-item"><a href="account-billing.html" class="nav-link">Billing</a></li>
                    <li class="nav-item"><a href="account-password.html" class="nav-link">Password</a></li>
                    <li class="nav-item"><a href="account-notifications.html" class="nav-link">Notifications</a></li>
                    <li class="nav-item"><a href="account-team.html" class="nav-link">Team</a></li>
                </ul>
            </header>
            <div class="d-flex align-items-end justify-content-between">
                <div>
                    <h4 class="fw-semibold mb-1">General</h4>
                    <p class="text-sm text-muted">By filling your data you get a much better experience using our website.</p>
                </div>
                <div class="d-none d-md-flex gap-2"><button type="button" class="btn btn-sm btn-neutral">Cancel</button> <button type="submit" class="btn btn-sm btn-primary">Save</button></div>
            </div>
            <hr class="my-6">
            <div class="row align-items-center">
                <div class="col-md-2"><label class="form-label">Your name</label></div>
                <div class="col-md-8 col-xl-5">
                    <div class=""><input type="text" class="form-control"></div>
                </div>
            </div>
            <hr class="my-6">
            <div class="row align-items-center">
                <div class="col-md-2"><label class="form-label">Bio</label></div>
                <div class="col-md-8 col-xl-5">
                    <div class=""><label class="form-label visually-hidden">Bio</label> <textarea class="form-control" placeholder="Your email" rows="3"></textarea></div>
                </div>
            </div>
            <hr class="my-6">
            <div class="row align-items-center">
                <div class="col-md-2"><label class="form-label">Username</label></div>
                <div class="col-md-8 col-xl-5">
                    <div class="">
                        <div class="input-group position-relative"><span class="input-group-text">satoshi.com/</span> <input type="email" class="form-control" placeholder="username" aria-label="username"> <span class="input-group-text">.com</span></div><span class="mt-2 valid-feedback">Looks good!</span></div>
                </div>
            </div>
            <hr class="my-6">
            <div class="row align-items-center">
                <div class="col-md-2"><label class="form-label">Avatar</label></div>
                <div class="col-md-8 col-xl-5">
                    <div class="">
                        <div class="d-flex align-items-center"><a href="#" class="avatar avatar-lg bg-warning rounded-circle text-white"><img src="../https_/images.unsplash.com/photo-1579463148228-138296ac3b98_ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=256&amp;h=256&amp;q=80.html" alt="..."></a>
                            <div
                                class="hstack gap-2 ms-5"><label for="file_upload" class="btn btn-sm btn-neutral"><span>Upload</span> <input type="file" name="file_upload" id="file_upload" class="visually-hidden"></label> <a href="#" class="btn d-inline-flex btn-sm btn-neutral text-danger"><span><i class="bi bi-trash"></i> </span><span class="d-none d-sm-block me-2">Remove</span></a></div>
                    </div>
                </div>
            </div>
    </div>
    <hr class="my-6">
    <div class="row align-items-center">
        <div class="col-md-2"><label class="form-label">Cover</label></div>
        <div class="col-md-8 col-xl-5">
            <div class=""><label class="form-label visually-hidden">Cover</label>
                <div class="card shadow-none border-2 border-dashed border-primary-hover position-relative">
                    <div class="d-flex justify-content-center px-5 py-5"><label for="cover_upload" class="position-absolute w-100 h-100 top-0 start-0 cursor-pointer"><input id="cover_upload" name="cover_upload" type="file" class="visually-hidden"></label>
                        <div class="text-center">
                            <div class="text-2xl text-muted"><i class="bi bi-upload"></i></div>
                            <div class="d-flex text-sm mt-3">
                                <p class="fw-semibold">Upload a file or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 3MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-6">
    <div class="row align-items-center">
        <div class="col-md-2"><label class="form-label">Privacy</label></div>
        <div class="col-md-8 col-xl-5">
            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="switch_make_public" id="switch_make_public"> <label class="form-check-label ms-2" for="switch_make_public">Make my profile public</label></div>
        </div>
    </div>
    <hr class="my-6 d-md-none">
    <div class="d-flex d-md-none justify-content-end gap-2 mb-6"><button type="button" class="btn btn-sm btn-neutral">Cancel</button> <button type="submit" class="btn btn-sm btn-primary">Save</button></div>
    </main>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/switcher.js"></script>
</body>

</html>