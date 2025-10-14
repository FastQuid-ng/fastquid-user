        <?php
            $currentPage = basename($_SERVER['PHP_SELF'], ".php"); 
            // e.g. "dashboard" if you’re on dashboard.php
        ?>
        <nav class="flex-none navbar navbar-vertical navbar-expand-lg navbar-light bg-transparent show vh-lg-100 px-0 py-2" id="sidebar">
            <div class="container-fluid px-3 px-md-4 px-lg-6">
                <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand d-inline-block py-lg-1 mb-lg-5" href="dashboard">
                    <img src="./assets/img/logo-dark.svg" class="logo-dark h-rem-8 h-rem-md-10" alt="...">
                    <img src="./assets/img/logo-light.svg" class="logo-light h-rem-8 h-rem-md-10" alt="...">
                </a>
                <div
                    class="navbar-user d-lg-none">
                    <div class="dropdown">
                        <a class="d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                            <div>
                                <div class="avatar avatar-sm text-bg-dark rounded-circle">
                                    <img src="<?= $avatar ?>">
                                </div>
                            </div>
                            <div class="d-none d-sm-block ms-3"><span class="h6"><?= $firstName ?></span></div>
                            <div class="d-none d-md-block ms-md-2"><i class="bi bi-chevron-down text-muted text-xs"></i></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header">
                                <span class="d-block text-sm text-muted mb-1">Signed in as</span> 
                                <span class="d-block text-heading fw-semibold"><?= $firstName ?> <?= $lastName ?></span>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="profile"><i class="bi bi-person me-3"></i>Profile</a>
                            <a class="dropdown-item" href="security"><i class="bi bi-gear me-3"></i>Security</a>
                            <a class="dropdown-item" href="bank"><i class="bi bi-bank me-3"></i>Bank</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout"><i class="bi bi-power me-3"></i>Log Out</a>
                        </div>
                    </div>
                </div>

                <div class="collapse navbar-collapse overflow-x-hidden mt-10" id="sidebarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item my-1">
                            <a class="nav-link d-flex align-items-center rounded-pill <?= ($currentPage === 'dashboard') ? 'active' : '' ?>" href="dashboard">
                                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span> 
                                <span class="badge badge-sm rounded-pill me-n2 bg-success-subtle text-success ms-auto"></span>
                            </a>
                        </li>

                        <li class="nav-item my-1 mt-7">
                            <a class="nav-link d-flex align-items-center rounded-pill <?= ($currentPage === 'loan') ? 'active' : '' ?>" href="loan">
                                <i class="bi bi-currency-exchange"></i> <span>Loan</span> 
                                <span class="badge badge-sm rounded-pill me-n2 bg-success-subtle text-success ms-auto"></span>
                            </a>
                        </li>

                        <li class="nav-item my-1 mt-7">
                            <a class="nav-link d-flex align-items-center rounded-pill <?= ($currentPage === 'profile') ? 'active' : '' ?>" href="profile">
                                <i class="bi bi-person-fill"></i> <span>Profile</span> 
                                <span class="badge badge-sm rounded-pill me-n2 bg-success-subtle text-success ms-auto"></span>
                            </a>
                        </li>

                        <li class="nav-item my-1 mt-7">
                            <a class="nav-link d-flex align-items-center rounded-pill <?= ($currentPage === 'security') ? 'active' : '' ?>" href="security">
                                <i class="bi bi-shield-fill-check"></i> <span>Security</span> 
                                <span class="badge badge-sm rounded-pill me-n2 bg-success-subtle text-success ms-auto"></span>
                            </a>
                        </li>

                        <li class="nav-item my-1 mt-7">
                            <a class="nav-link d-flex align-items-center rounded-pill <?= ($currentPage === 'bank') ? 'active' : '' ?>" href="bank">
                                <i class="bi bi-bank2"></i> <span>Bank</span> 
                                <span class="badge badge-sm rounded-pill me-n2 bg-success-subtle text-success ms-auto"></span>
                            </a>
                        </li>
                    </ul>

                    <div class="mt-auto"></div>

                    <div class="card bg-dark border-0 mt-5 mb-3">
                        <div class="card-body">
                            <div class="vstack gap-4">
                                <a href="logout" class="btn btn-sm btn-primary w-100">Log Out<i class="bi bi-power ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>