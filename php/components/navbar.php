        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Vérifiez si l'utilisateur est connecté
            if (isset($_SESSION['user_id'])) {
                // Récupérez les informations de l'utilisateur à partir de la base de données
                $user_id = $_SESSION['user_id'];
                $stmt = $pdo->prepare("SELECT * FROM Users WHERE id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch();

                if ($user) {
                    echo "Bonjour, " . $user['username'];
                } else {
                    echo "Utilisateur non trouvé";
                }
            } else {
                echo "Vous n'êtes pas connecté";
            }
        ?>
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar" style="background: #222!important;">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="bx bx-menu bx-sm"></i>
                </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <!-- Search -->
                <div class="navbar-nav align-items-center">
                    <div class="nav-item navbar-search-wrapper mb-0">
                        <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                            <span class="d-none d-md-inline-block text-muted">Intranet Mindset</span>
                        </a>
                    </div>
                </div>
                <!-- /Search -->

                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <!-- Language -->
                    <!--/ Language -->

                    <!-- Style Switcher -->
                    <li class="nav-item me-2 me-xl-0">
                        <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                            <i class="bx bx-sm"></i>
                        </a>
                    </li>
                    <!--/ Style Switcher -->

                    <!-- Quick links  -->
                    <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bx bx-grid-alt bx-sm"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="dropdown-menu-header border-bottom">
                                <div class="dropdown-header d-flex align-items-center py-3">
                                    <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                                    <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i
                                            class="bx bx-sm bx-plus-circle"></i></a>
                                </div>
                            </div>
                            <div class="dropdown-shortcuts-list scrollable-container">
                                <div class="row row-bordered overflow-visible g-0">
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-calendar fs-4"></i>
                                        </span>
                                        <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                        <small class="text-muted mb-0">Appointments</small>
                                    </div>
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-food-menu fs-4"></i>
                                        </span>
                                        <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                        <small class="text-muted mb-0">Manage Accounts</small>
                                    </div>
                                </div>
                                <div class="row row-bordered overflow-visible g-0">
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-user fs-4"></i>
                                        </span>
                                        <a href="app-user-list.html" class="stretched-link">User App</a>
                                        <small class="text-muted mb-0">Manage Users</small>
                                    </div>
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-check-shield fs-4"></i>
                                        </span>
                                        <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                                        <small class="text-muted mb-0">Permission</small>
                                    </div>
                                </div>
                                <div class="row row-bordered overflow-visible g-0">
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-pie-chart-alt-2 fs-4"></i>
                                        </span>
                                        <a href="index.html" class="stretched-link">Dashboard</a>
                                        <small class="text-muted mb-0">User Profile</small>
                                    </div>
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-cog fs-4"></i>
                                        </span>
                                        <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                                        <small class="text-muted mb-0">Account Settings</small>
                                    </div>
                                </div>
                                <div class="row row-bordered overflow-visible g-0">
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-help-circle fs-4"></i>
                                        </span>
                                        <a href="pages-help-center-landing.html" class="stretched-link">Help Center</a>
                                        <small class="text-muted mb-0">FAQs & Articles</small>
                                    </div>
                                    <div class="dropdown-shortcuts-item col">
                                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                            <i class="bx bx-window-open fs-4"></i>
                                        </span>
                                        <a href="modal-examples.html" class="stretched-link">Modals</a>
                                        <small class="text-muted mb-0">Useful Popups</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- Quick links -->


                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img src="../../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="pages-account-settings-account.html">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-online">
                                                <img src="../../assets/img/avatars/1.png" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fw-semibold d-block">Username</span>
                                            <small class="text-muted">Admin</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/php/profil/settings.php">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">Mes informations</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pages-account-settings-account.html">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Mes clients</span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pages-help-center-landing.html">
                                    <i class="bx bx-support me-2"></i>
                                    <span class="align-middle">Support</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pages-faq.html">
                                    <i class="bx bx-help-circle me-2"></i>
                                    <span class="align-middle">FAQ</span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/php/logout.php" target="_blank">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">Se deconnecter</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--/ User -->
                </ul>
            </div>

            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper d-none">
                <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
                    aria-label="Search..." />
                <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
            </div>
        </nav>