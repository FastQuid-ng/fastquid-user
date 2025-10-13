        <div class="d-none d-lg-flex py-3">
            <div class="hstack flex-fill justify-content-end flex-nowrap gap-6 ms-auto px-6 px-xxl-8">
                <div class="dropdown">
                    <a href="#" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-sun-fill"></i></a>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">Light</button>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">Dark</button>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto">System</button>
                    </div>
                </div>
                <div class="dropdown">
                    <a class="avatar avatar-sm text-bg-dark rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        <img src="<?= $avatar ?>">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-header">
                            <span class="d-block text-sm text-muted mb-1">Signed in as</span>
                            <span class="d-block text-heading fw-semibold"><?= $firstName ?> <?= $lastName ?></span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="profile"><i class="bi bi-pencil me-3"></i>Profile</a>
                        <a class="dropdown-item" href="security"><i class="bi bi-gear me-3"></i>Security</a>
                        <a class="dropdown-item" href="bank"><i class="bi bi-bank me-3"></i>Bank</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout"><i class="bi bi-power me-3"></i>Log Out</a>
                    </div>
                </div>
            </div>
        </div>