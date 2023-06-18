<?php
    // Connexion à la base de données.
    $host = '176.31.132.185';
    $db   = 'vesqbc_producti_db';
    $user = 'vesqbc_producti_db';
    $pass = '7f-yp!QZWOg6_%49';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    // Récupération de l'identifiant du client depuis l'URL.
    $client_id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($client_id) {
      // Récupération des informations du client de la base de données.
      $query = "SELECT clients.*, 
      offres.nom AS offre_nom, offres.prix_mensuel, offres.nombre_villes, offres.nombre_longues_traines,
      users.nom AS commercial_nom, users.avatar AS commercial_avatar
FROM clients
JOIN offres ON clients.offre_id = offres.id
JOIN users ON clients.commercial_id = users.id
WHERE clients.id = ?";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$client_id]);
      $client = $stmt->fetch();
    }else {
      echo "<p>ID de client invalide.</p>";
  }
    ?>

<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>User View - Pages | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-user-view.css" />
    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include 'menu.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include 'navbar.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> Clients /</span> Fiche client
                        </h4>
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="user-avatar-section">
                                            <div class="d-flex align-items-center flex-column">
                                                <img class="img-fluid rounded my-4"
                                                    src="../../assets/img/avatars/interface-mindset-technologie.png"
                                                    height="110" width="110" alt="User avatar" />
                                                <div class="user-info text-center">
                                                    <h4 class="mb-2"><?php echo $client['nom']?></h4>
                                                    <span
                                                        class="badge bg-label-secondary"><?php echo $client['offre_nom']?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="pb-2 border-bottom mb-4">Details</h5>
                                        <div class="info-container">
                                            <ul class="list-unstyled">
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Nom:</span>
                                                    <span><?php echo $client['nom']?></span>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Prenom:</span>
                                                    <span><?php echo $client['prenom']?></span>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Email:</span>
                                                    <?php echo $client['email']?>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Date de signature:</span>
                                                    <?php echo $client['date_signature']?>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Numero de téléphone:</span>
                                                    <?php echo $client['phone_number']?>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Societe:</span>
                                                    <?php echo $client['societe']?>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Date de signature:</span>
                                                    <?php 

                                                    $dateString = $client['date_signature'];

                                                        // Créer un objet DateTime à partir de la chaîne de date récupérée
                                                        $date = new DateTime($dateString);

                                                        // Créer un formateur de date avec la locale en français
                                                        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

                                                        // Afficher la date dans le format 'd F Y' en français
                                                        echo $formatter->format($date);
                                                    ?>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Adresse postal:</span>
                                                    <?php echo $client['adresse'] . ' '. $client['ville'] . ' ' .  $client['code_postal']?>
                                                </li>
                                                <li class="mb-3">
                                                    <span class="fw-bold me-2">Statut:</span>
                                                    <span class="badge bg-label-success">
                                                        <?php echo $client['statut']?></span>
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-center pt-3">
                                                <a href="javascript:;" class="btn btn-primary me-3"
                                                    data-bs-target="#editUser" data-bs-toggle="modal">Modifier</a>
                                                <a href="javascript:;"
                                                    class="btn btn-label-danger suspend-user">Archiver</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                                <!-- Plan Card -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span
                                                class="badge bg-label-primary"><?php echo $client['offre_nom']?></span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency mt-3 mb-0 me-1 text-primary">€</sup>
                                                <h1 class="display-5 mb-0 text-primary">
                                                    <?php echo $client['prix_mensuel']?></h1>
                                                <sub class="fs-6 pricing-duration mt-auto mb-3">/mois</sub>
                                            </div>
                                        </div>
                                        <ul class="ps-3 g-2 my-4">
                                            <li class="mb-2">Nombre de villes: <?php echo $client['nombre_villes']?>
                                            </li>
                                            <li class="mb-2">Nombre de Longues
                                                Traînes: <?php echo $client['nombre_longues_traines']?></li>
                                            <li>Support Basic</li>
                                        </ul>
                                        <div class="progress mb-1" style="height: 8px">
                                            <div class="progress-bar" role="progressbar" style="width: 100%"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class="d-grid w-100 mt-4 pt-2">
                                            <button class="btn btn-primary" data-bs-target="#upgradePlanModal"
                                                data-bs-toggle="modal">
                                                Passer à l'offre suppérieure
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Plan Card -->
                            </div>
                            <!--/ User Sidebar -->

                            <!-- User Content -->
                            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                                <!-- User Pills -->
                                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0);"><i
                                                class="bx bx-user me-1"></i>Fiche client</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="bx bx-detail me-1"></i>Contrat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="bx bx-bell me-1"></i>Projets</a>
                                    </li>
                                </ul>
                                <!--/ User Pills -->

                                <!-- Project table -->

                                <!-- /Project table -->

                                <!-- Activity Timeline -->
                                <div class="card mb-4">
                                    <h5 class="card-header">Timeline du client</h5>
                                    <div class="card-body">
                                        <ul class="timeline">
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-success"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-1">
                                                        <h6 class="mb-0">Rendez-vous client</h6>
                                                        <small class="text-muted">28/04/2023</small>
                                                    </div>
                                                    <p class="mb-2">Remise du projet client</p>

                                                    <div class="d-flex flex-wrap">
                                                        <div class="avatar me-3">
                                                            <?php if (isset($client['commercial_avatar'])) {
              echo "<img src=\"{$client['commercial_avatar']}\" alt=\"Avatar du commercial\" class=\"rounded-circle\">";
          }?>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0"><?php $client['commercial_nom']?></h6>
                                                            <span class="text-muted">Commercial</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-warning"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-1">
                                                        <h6 class="mb-0">Cahier des charges</h6>
                                                        <small class="text-muted">22/03/2023</small>
                                                    </div>
                                                    <p class="mb-2">Complétion du cahier des charges</p>

                                                    <div class="d-flex flex-wrap">
                                                        <div class="avatar me-3">
                                                            <?php if (isset($client['commercial_avatar'])) {
                                                                echo "<img src=\"{$client['commercial_avatar']}\" alt=\"Avatar du commercial\" class=\"rounded-circle\">";
                                                            }?>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0"><?php $client['commercial_nom']?></h6>
                                                            <span class="text-muted">Commercial</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="timeline-end-indicator">
                                                <i class="bx bx-check-circle"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Activity Timeline -->

                                <!-- Invoice table -->

                                <!-- /Invoice table -->
                            </div>
                            <!--/ User Content -->
                        </div>

                        <!-- Modal -->
                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3>Modification du Client</h3>
                                            <p>Toute modification doit faire l'objet d'une validation</p>
                                        </div>
                                        <form action="/php/update_client.php" method="post" class="card-body">
                                            <h6>1. Informations Générales</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="nom">Nom</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['nom']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="prenom">Prénom</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['prenom']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="societe">Société</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['societe']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="siret">SIRET</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['siret']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['email']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="phone_number">Numéro de tel</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['phone_number']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="temps_engagement">Temps d'engagement
                                                        (mois)</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['temps_engagement']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="date_signature">Date de
                                                        signature</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['date_signature']); ?>">
                                                </div>
                                            </div>

                                            <hr class="my-4 mx-n4" />
                                            <h6>2. Adresse</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="adresse">Adresse</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['adresse']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="ville">Ville</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['ville']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="code_postal">Code Postal</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['code_postal']); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="pays">Pays</label>
                                                    <input type="text" id="nom" name="nom" class="form-control"
                                                        placeholder="Dupont" required
                                                        value="<?php echo htmlspecialchars($client['pays']); ?>">
                                                </div>
                                            </div>

                                            <hr class="my-4 mx-n4" />
                                            <h6>3. Options et Commercial</h6>
                                            <div class="row g-3">
                                                <?php foreach ($options as $option): ?>
                                                <div class="col-md-4">
                                                    <input type="checkbox" id="option<?php echo $option['id']; ?>"
                                                        name="options[]" class="form-check-input"
                                                        value="<?php echo $option['id']; ?>"
                                                        <?php if (in_array($option['id'], $client_options)) echo 'checked'; ?>>
                                                    <label class="form-check-label"
                                                        for="option<?php echo $option['id']; ?>"><?php echo htmlspecialchars($option['nom']); ?></label>
                                                </div>
                                                <?php endforeach; ?>

                                                <div class="col-md-6">
                                                    <label class="form-label" for="commercial_id">Commercial</label>
                                                    <select id="commercial_id" name="commercial_id"
                                                        class="select2 form-select">
                                                        <?php foreach ($commerciaux as $commercial): ?>
                                                        <option value="<?php echo $commercial['id']; ?>"
                                                            <?php if ($commercial['id'] == $client['commercial_id']) echo 'selected'; ?>>
                                                            <?php echo htmlspecialchars($commercial['prenom'] . ' ' . $commercial['nom']); ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr class="my-4 mx-n4" />
                                            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                            <div class="pt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Modifier le
                                                    Client</button>
                                                <button type="reset" class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    Annuler
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Edit User Modal -->

                        <!-- Add New Credit Card Modal -->
                        <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3>Upgrade Plan</h3>
                                            <p>Choose the best plan for user.</p>
                                        </div>
                                        <form id="upgradePlanForm" class="row g-3" onsubmit="return false">
                                            <div class="col-sm-9">
                                                <label class="form-label" for="choosePlan">Choose Plan</label>
                                                <select id="choosePlan" name="choosePlan" class="form-select"
                                                    aria-label="Choose Plan">
                                                    <option selected>Choose Plan</option>
                                                    <option value="standard">Standard - $99/month</option>
                                                    <option value="exclusive">Exclusive - $249/month</option>
                                                    <option value="Enterprise">Enterprise - $499/month</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">Upgrade</button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr class="mx-md-n5 mx-n3" />
                                    <div class="modal-body">
                                        <h6 class="mb-0">User current plan is standard plan</h6>
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex justify-content-center me-2 mt-3">
                                                <sup
                                                    class="h5 pricing-currency pt-1 mt-3 mb-0 me-1 text-primary">$</sup>
                                                <h1 class="display-3 mb-0 text-primary">99</h1>
                                                <sub class="h5 pricing-duration mt-auto mb-2">/month</sub>
                                            </div>
                                            <button class="btn btn-label-danger cancel-subscription mt-3">Cancel
                                                Subscription</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Add New Credit Card Modal -->

                        <!-- /Modal -->
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/modal-edit-user.js"></script>
    <script src="../../assets/js/app-user-view.js"></script>
    <script src="../../assets/js/app-user-view-account.js"></script>
</body>

</html>