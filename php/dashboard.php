<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
include 'db_connection.php';
include './notifications/notifications.php';

$stmt = $pdo->prepare("SELECT id, directeur, agence_id FROM users WHERE username = ?");
$stmt->execute([$username]); // Remplacez $username par la valeur appropriée
$user = $stmt->fetch();
$userId = $user['id']; // Changez $user_id en $userId
$userDirecteur = $user['directeur']; // Changez $user_id en $userId
$agenceId = $user['agence_id']; // Changez $user_id en $userId

if (!isset($_SESSION['username'])) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header('Location: ../index.php');
    exit;
} else {
    // L'utilisateur est connecté, affichez son nom d'utilisateur dans la console du navigateur
    echo "<script>console.log('Connecté en tant que : " . $_SESSION['username'] . "');</script>";
    echo "<script>console.log('Connecté en tant que : " . $userDirecteur . "');</script>";
    echo "<script>console.log('Mon agence : " . $agenceId . "');</script>";
}

// Préparation et exécution de la requête pour le CA en prévision du mois en cours
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_prevision) AS CA_prevision_this_month
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND CA.CA_realise IS NULL AND clients.statut = "actif" AND MONTH(CA.date_realisation) = MONTH(CURDATE())
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_prevision_this_month = $stmt->fetch(PDO::FETCH_ASSOC)['CA_prevision_this_month'];

// Préparation et exécution de la requête pour le CA en prévision des 3 derniers mois
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_prevision) AS CA_prevision_3_months
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND CA.date_realisation >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND clients.statut = "actif"
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_prevision_3_months = $stmt->fetch(PDO::FETCH_ASSOC)['CA_prevision_3_months'];

// Préparation et exécution de la requête pour le CA en prévision depuis le début
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_prevision) AS CA_prevision_total
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND clients.statut = "actif"
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_prevision_total = $stmt->fetch(PDO::FETCH_ASSOC)['CA_prevision_total'];

// Préparation et exécution de la requête pour le CA réalisé
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_realise) AS CA_realise
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND clients.statut = "actif"
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_realise = $stmt->fetch(PDO::FETCH_ASSOC)['CA_realise'];

if ($CA_prevision_3_months != 0) {
    $variation_this_month_vs_3_months = ($CA_prevision_this_month - $CA_prevision_3_months) / $CA_prevision_3_months * 100;
} else {
    if ($CA_prevision_this_month > 0) {
        $variation_this_month_vs_3_months = 100;
    } else {
        $variation_this_month_vs_3_months = 0;
    }
}

$month = date("m");


////////////////////////////////////////////////////////////////////

// Préparation et exécution de la requête pour le CA réalisé du mois dernier
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_realise) AS CA_realise_last_month
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND clients.statut = "actif" AND MONTH(CA.date_realisation) = MONTH(CURDATE() - INTERVAL 1 MONTH)
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_realise_last_month = $stmt->fetch(PDO::FETCH_ASSOC)['CA_realise_last_month'];

// Préparation et exécution de la requête pour le CA réalisé du mois actuel
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_realise) AS CA_realise_this_month
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND clients.statut = "actif" AND MONTH(CA.date_realisation) = MONTH(CURDATE())
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_realise_this_month = $stmt->fetch(PDO::FETCH_ASSOC)['CA_realise_this_month'];

if ($CA_realise_last_month != 0) {
    $variation_realise_last_vs_this_month = ($CA_realise_this_month - $CA_realise_last_month) / $CA_realise_last_month * 100;
} else {
    if ($CA_realise_this_month > 0) {
        $variation_realise_last_vs_this_month = 100;
    } else {
        $variation_realise_last_vs_this_month = 0;
    }
}

// Préparation et exécution de la requête pour compter le nombre total de clients
$stmt = $pdo->prepare('SELECT COUNT(*) AS total_clients FROM clients');
$stmt->execute();
$total_clients = $stmt->fetch(PDO::FETCH_ASSOC)['total_clients'];

// Préparation et exécution de la requête pour compter le nombre de clients avec offres_id 1
$stmt = $pdo->prepare('SELECT COUNT(*) AS clients_with_offer_1 FROM clients WHERE offre_id = 1');
$stmt->execute();
$clients_with_offer_1 = $stmt->fetch(PDO::FETCH_ASSOC)['clients_with_offer_1'];

// Calcul du pourcentage
$percentageOffer = ($clients_with_offer_1 / $total_clients) * 100;



?>

<!DOCTYPE html>

<html lang="fr" class="dark-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/">

<head>
    <meta charset="utf-8" />
    <title>Tableau de bord</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/rtl/core-dark.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default-dark.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
</head>


<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include './components/menu.php'; ?>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include './components/navbar.php'; ?>
                <!-- / Navbar -->

                <!-- / Layout page -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-lg-8 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Tableau de bord🎉</h5>
                                                <p class="mb-4">
                                                    Bonjour <span class="fw-bold"><?php $_SESSION['username']?></span> !
                                                    Êtes-vous prêt à faire grimper votre chiffre d'affaire
                                                    aujourd'hui ?
                                                </p>

                                                <a href="https://intranet-mindset.com/php/Listing_clients.php"
                                                    class="btn btn-sm btn-label-primary">Voir les clients</a>
                                                <?php 
                                                  if ($userDirecteur == '1') { ?>
                                                <button type="button" class="btn btn-sm btn-label-primary ms-1"
                                                    data-bs-toggle="modal" data-bs-target="#objectifModal">
                                                    Définir l'objectif mensuel
                                                </button>
                                                <div class="modal fade" id="objectifModal" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Définir l'objectif mensuel</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="./ca/set_objectif.php" method="post">
                                                                    <div class="mb-3">
                                                                        <label for="objectif"
                                                                            class="form-label">Objectif mensuel
                                                                            :</label>
                                                                        <input type="number" id="objectif"
                                                                            name="objectif" step="0.01" min="0"
                                                                            class="form-control">
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Fermer</button>
                                                                <input type="submit" value="Envoyer"
                                                                    class="btn btn-primary">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                  }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-5 text-center text-sm-left">
                                            <div class="card-body pb-0 px-0 px-md-4">
                                                <img src="../../assets/img/illustrations/man-with-laptop-light.png"
                                                    height="140" alt="View Badge User"
                                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 order-1">
                                <div class="row">
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['rang'] == 'commercial') {?>

                                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="../assets/img/icons/unicons/cc-warning.png"
                                                            alt="Credit Card" class="rounded" />
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="cardOpt6"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="cardOpt6">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span>C.A réalisé mensuel</span>
                                                <h3 class="card-title text-nowrap mb-1">
                                                    <?php echo number_format($CA_prevision_this_month, 0, ',', ' '); ?>
                                                    €</h3>
                                                <small
                                                    class="text-<?php echo ($variation_this_month_vs_3_months >= 0) ? 'success' : 'danger'; ?> fw-semibold">
                                                    <i
                                                        class="bx <?php echo ($variation_this_month_vs_3_months >= 0) ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'; ?>"></i>
                                                    <?php echo ($variation_this_month_vs_3_months >= 0) ? '+' : ''; ?><?php echo number_format($variation_this_month_vs_3_months, 2); ?>%
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="../assets/img/icons/unicons/cc-success.png"
                                                            alt="Credit Card" class="rounded" />
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="cardOpt6"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="cardOpt6">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span>C.A validé mensuel</span>
                                                <h3 class="card-title text-nowrap mb-1">
                                                    <?php echo number_format($CA_realise_this_month, 0, ',', ' '); ?> €
                                                </h3>
                                                <small
                                                    class="text-<?php echo ($variation_realise_last_vs_this_month >= 0) ? 'success' : 'danger'; ?> fw-semibold">
                                                    <i
                                                        class="bx <?php echo ($variation_realise_last_vs_this_month >= 0) ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'; ?>"></i>
                                                    <?php echo ($variation_realise_last_vs_this_month >= 0) ? '+' : ''; ?><?php echo number_format($variation_realise_last_vs_this_month, 2); ?>%
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                     }
                     ?>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['rang'] == 'commercial') {?>
                        <div class="row">

                            <!-- Sales Stats -->
                            <div class="col-md-6 col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex align-items-center justify-content-between mb-30">
                                        <h5 class="card-title m-0 me-2">Meilleure offre vendue sur le marché</h5>
                                    </div>
                                    <div id="salesStats"></div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-around">
                                            <div class="d-flex align-items-center lh-1 mb-3 mb-sm-0">
                                                <span class="badge badge-dot bg-success me-2"></span> Offre Ambition
                                            </div>
                                            <div class="d-flex align-items-center lh-1 mb-3 mb-sm-0">
                                                <span class="badge badge-dot bg-label-secondary me-2"></span> Autres
                                                offres
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Sales Stats -->
                            <!-- pill table -->
                            <div class="col-md-6 order-3 order-lg-4 mb-4 mb-lg-0">
                                <div class="card text-center">
                                    <div class="card-header py-3 h-100">
                                        <h5 class="card-title text-primary  style='text-align:left;'">Classement du C.A
                                            réalisé du mois de <?php echo "$month"?> </h5>
                                        <ul class="nav nav-pills" role="tablist">
                                            <li class="nav-item">
                                                <button type="button" class="nav-link active" role="tab"
                                                    data-bs-toggle="tab" data-bs-target="#navs-pills-browser"
                                                    aria-controls="navs-pills-browser" aria-selected="true">
                                                    Consultants
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#navs-pills-os" aria-controls="navs-pills-os"
                                                    aria-selected="false">
                                                    Cabinets
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#navs-pills-options"
                                                    aria-controls="navs-pills-options" aria-selected="false">
                                                    Options
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content pt-0">
                                        <div class="tab-pane fade show active" id="navs-pills-browser" role="tabpanel">
                                            <div class="table-responsive text-start">
                                                <table class="table table-borderless text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Consultant</th>
                                                            <th>C.A</th>
                                                            <th class="w-50">Objectif de vente (30.000€)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php include 'components/classement_commercial_prevision.php' ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="navs-pills-os" role="tabpanel">
                                            <div class="table-responsive text-start">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Agence</th>
                                                            <th>C.A</th>
                                                            <th class="w-50">Objectif de vente</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php include 'components/classement_agences_prevision.php' ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show active" id="navs-pills-options" role="tabpanel">
                                            <div class="table-responsive text-start">
                                                <table class="table table-borderless text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Consultant</th>
                                                            <th>C.A</th>
                                                            <th class="w-50">Objectif options</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php include 'components/classement_options_commercial.php' ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ pill table -->
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/ui-modals.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
    let BestOffer = <?php echo $percentageOffer; ?>;
    </script>
    <script src="/assets/js/dashboards-crm.js"></script>

</body>

</html>