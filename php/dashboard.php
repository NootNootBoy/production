<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
include 'db_connection.php';
include './notifications/notifications.php';

$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]); // Remplacez $username par la valeur appropriée
$user = $stmt->fetch();
$userId = $user['id']; // Changez $user_id en $userId

if (!isset($_SESSION['username'])) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header('Location: ../index.php');
    exit;
} else {
    // L'utilisateur est connecté, affichez son nom d'utilisateur dans la console du navigateur
    echo "<script>console.log('Connecté en tant que : " . $_SESSION['username'] . "');</script>";
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

// Calcul du pourcentage de variation entre le mois dernier et les 3 derniers mois
$variation_this_month_vs_3_months = ($CA_prevision_this_month - $CA_prevision_3_months) / $CA_prevision_3_months * 100;

////////////////////////////////////////////////////////////////////

// Préparation et exécution de la requête pour le CA réalisé du mois dernier
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_realise) AS CA_realise_last_month
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND clients.status = "actif" AND MONTH(CA.date_realisation) = MONTH(CURDATE() - INTERVAL 1 MONTH)
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_realise_last_month = $stmt->fetch(PDO::FETCH_ASSOC)['CA_realise_last_month'];

// Préparation et exécution de la requête pour le CA réalisé du mois actuel
$stmt = $pdo->prepare('
    SELECT SUM(CA.CA_realise) AS CA_realise_this_month
    FROM CA
    JOIN clients ON CA.client_id = clients.id
    WHERE (CA.commercial_id = :userId1 OR CA.second_commercial_id = :userId2) AND clients.status = "actif" AND MONTH(CA.date_realisation) = MONTH(CURDATE())
');
$stmt->execute(['userId1' => $userId, 'userId2' => $userId]);
$CA_realise_this_month = $stmt->fetch(PDO::FETCH_ASSOC)['CA_realise_this_month'];

// Calcul de la variation en pourcentage entre le mois dernier et le mois actuel
if ($CA_realise_last_month == 0) {
    $variation_realise_last_vs_this_month = 100;
} else {
    $variation_realise_last_vs_this_month = ($CA_realise_this_month - $CA_realise_last_month) / $CA_realise_last_month * 100;
}

?>

<!DOCTYPE html>

<html lang="fr" class="dark-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

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
88

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
                            Bonjour <span class="fw-bold"><?php $_SESSION['username']?></span> ! Êtes-vous prêt à faire grimper votre chiffre d'affaire
                            aujourd'hui ?
                          </p>

                          <a href="https://intranet-mindset.com/php/Listing_clients.php" class="btn btn-sm btn-label-primary">Voir les clients</a>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="../../assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
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
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../assets/img/icons/unicons/cc-warning.png"
                                alt="Credit Card"
                                class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                              </div>
                            </div>
                          </div>
                          <span>C.A prevision</span>
                          <h3 class="card-title text-nowrap mb-1"><?php echo number_format($CA_prevision_this_month, 0, ',', ' '); ?> €</h3>
                          <small class="text-<?php echo ($variation_this_month_vs_3_months >= 0) ? 'success' : 'danger'; ?> fw-semibold">
                            <i class="bx <?php echo ($variation_this_month_vs_3_months >= 0) ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'; ?>"></i>
                            <?php echo ($variation_this_month_vs_3_months >= 0) ? '+' : ''; ?><?php echo number_format($variation_this_month_vs_3_months, 2); ?>%
                        </small>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../assets/img/icons/unicons/cc-success.png"
                                alt="Credit Card"
                                class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                              </div>
                            </div>
                          </div>
                          <span>C.A réalisé</span>
                          <h3 class="card-title text-nowrap mb-1"><?php echo number_format($CA_realise_this_month, 0, ',', ' '); ?> €</h3>
                          <small class="text-<?php echo ($variation_realise_last_vs_this_month >= 0) ? 'success' : 'danger'; ?> fw-semibold">
                            <i class="bx <?php echo ($variation_realise_last_vs_this_month >= 0) ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'; ?>"></i>
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
                <div class="row">
                     <!-- pill table -->
                <div class="col-md-6 order-3 order-lg-4 mb-4 mb-lg-0">
                  <div class="card text-center">
                    <div class="card-header py-3">
                    <h5 class="card-title text-primary  style='text-align:left;'">Classement en prévision</h5>
                      <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                          <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-pills-browser"
                            aria-controls="navs-pills-browser"
                            aria-selected="true">
                            Commercial
                          </button>
                        </li>
                        <li class="nav-item">
                          <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-pills-os"
                            aria-controls="navs-pills-os"
                            aria-selected="false">
                            Agence
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
                                <th class="w-50">Objectif de vente (135.000€)</th>
                              </tr>
                            </thead>
                                <tbody>
                                <?php
                                    // Effectuer votre requête pour obtenir les chiffres d'affaires en prévision des commerciaux
                                    // et les trier par ordre décroissant
                                    $stmt = $pdo->prepare('
                                        SELECT users.username, users.avatar, SUM(CA.CA_prevision) AS CA_prevision
                                        FROM users
                                        LEFT JOIN CA ON users.id = CA.commercial_id OR users.id = CA.second_commercial_id
                                        JOIN clients ON CA.client_id = clients.id
                                        WHERE CA.CA_realise IS NULL AND users.rang = "commercial" AND clients.statut = "actif"
                                        GROUP BY users.username
                                        ORDER BY CA_prevision DESC
                                    ');
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Boucle pour afficher les données de chaque commercial
                                    $position = 1;
                                    foreach ($result as $row) {
                                        $username = $row['username'];
                                        $avatar = $row['avatar'];
                                        $CA_prevision = $row['CA_prevision'];
                                        $progress = ($CA_prevision / 135000) * 100;
                                        $progressColor = '';

                                        // Déterminer la couleur de la barre de progression en fonction des seuils
                                        if ($CA_prevision < 30000) {
                                            $progressColor = 'bg-danger';
                                        } elseif ($CA_prevision < 75000) {
                                            $progressColor = 'bg-warning';
                                        } else {
                                            $progressColor = 'bg-success';
                                        }
                                        ?>

                                        <tr>
                                            <td><?php echo $position; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($avatar)) { ?>
                                                        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" width="30px" class="rounded-circle m-2" />
                                                    <?php } else { ?>
                                                        <img src="/assets/img/avatars/1.png" alt="Avatar" width="30px" class="rounded-circle m-2" />
                                                    <?php } ?>
                                                    <span><?php echo $username; ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo number_format($CA_prevision, 0, '.', ' '); ?>€</td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <div class="progress w-100" style="height: 10px">
                                                        <div class="progress-bar <?php echo $progressColor; ?>" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="fw-semibold"><?php echo number_format($progress, 0, '.', ' '); ?>%</small>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                        $position++;
                                    }
                                    ?>
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
                                <th class="w-50">Objectif de vente (135.000€)</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Effectuer votre requête pour obtenir les chiffres d'affaires en prévision des agences
                            // et les trier par ordre décroissant
                            $stmt = $pdo->prepare('
                            SELECT agences.nom AS agence_nom, SUM(CA.CA_prevision) AS CA_prevision
                            FROM users
                            LEFT JOIN CA ON users.id = CA.commercial_id OR users.id = CA.second_commercial_id
                            JOIN agences ON users.agence_id = agences.id
                            JOIN clients ON CA.client_id = clients.id
                            WHERE CA.CA_realise IS NULL AND clients.statut = "actif"
                            GROUP BY agences.nom
                            ORDER BY CA_prevision DESC
                        ');
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                            // Boucle pour afficher les données de chaque agence
                            $position = 1;
                            foreach ($result as $row) {
                                $agence_nom = $row['agence_nom'];
                                $CA_prevision = $row['CA_prevision'];
                                $progress = ($CA_prevision / 135000) * 100;
                                $progressColor = '';

                                // Déterminer la couleur de la barre de progression en fonction des seuils
                                if ($CA_prevision < 30000) {
                                    $progressColor = 'bg-danger';
                                } elseif ($CA_prevision < 75000) {
                                    $progressColor = 'bg-warning';
                                } else {
                                    $progressColor = 'bg-success';
                                }
                                ?>

                                <tr>
                                    <td><?php echo $position; ?></td>
                                    <td><?php echo $agence_nom; ?></td>
                                    <td><?php echo number_format($CA_prevision, 0, '.', ' '); ?>€</td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <div class="progress w-100" style="height: 10px">
                                                <div class="progress-bar <?php echo $progressColor; ?>" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small class="fw-semibold"><?php echo number_format($progress, 0, '.', ' '); ?>%</small>
                                        </div>
                                    </td>
                                </tr>

                                <?php
                                $position++;
                            }
                            ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ pill table -->
                </div>
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

        <!-- Page JS -->

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>