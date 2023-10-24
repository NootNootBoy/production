<?php

session_start();
include '../notifications/notifications.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

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

    $id_mission = $_GET['id'];
        
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Basic Inputs - Forms | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

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
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core-dark.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default-dark.css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5>Gestion des Tâches</h5>
            </div>
            <div class="card-body">
                <?php
                    $stmt = $pdo->prepare("SELECT * FROM missions WHERE id_mission = :id_mission");
                    $stmt->bindParam(':id_mission', $id_mission);
                    $stmt->execute();
                    $mission = $stmt->fetch();

                    if ($mission) {
                    echo "<h2 class='mb-4 mt-4 font-weight-bold'>" . $mission['nom_mission'] . " (" . $mission['progression'] . "%)</h2>";
                    echo "<div class='progress mb-4'>";
                    echo "<div class='progress-bar' role='progressbar' style='width: " . $mission['progression'] . "%;' aria-valuenow='" . $mission['progression'] . "' aria-valuemin='0' aria-valuemax='100'>" . $mission['progression'] . "%</div>";
                    echo "</div>";

                    $stmt = $pdo->prepare("SELECT taches.*, taches_predefinies.nom_tache, taches_predefinies.categorie_tache FROM taches INNER JOIN taches_predefinies ON taches.id_tache_predefinie = taches_predefinies.id_tache_predefinie WHERE id_mission = :id_mission ORDER BY taches_predefinies.categorie_tache");
                    $stmt->bindParam(':id_mission', $id_mission);
                    $stmt->execute();
                    $taches = $stmt->fetchAll();

                    $taches_par_categorie = [];
                    foreach ($taches as $tache) {
                    $taches_par_categorie[$tache['categorie_tache']][] = $tache;
                    }

                    echo "<form action='update_taches.php' method='post' class='mt-3'>";
                    echo "<input type='hidden' name='id_mission' value='" . $mission['id_mission'] . "'>";
                    echo "<input type='hidden' name='id_user' value='" . $mission['id_user'] . "'>";
                    foreach ($taches_par_categorie as $categorie => $taches_categorie) {
                    echo "<h4 class='mb-3'>" . $categorie . "</h4>";
                    foreach ($taches_categorie as $tache) {
                        echo "<div class='form-check mb-2'>";
                        echo "<input type='checkbox' class='form-check-input' id='tache" . $tache['id_tache'] . "' name='tache" . $tache['id_tache'] . "' " . ($tache['est_complete'] == '1' ? 'checked' : '') . ">";
                        echo "<label class='form-check-label' for='tache" . $tache['id_tache'] . "'>" . $tache['nom_tache'] . "</label>";
                        echo "</div>";
                    }
                    }
                    echo "<button type='submit' class='btn btn-warning mt-3'>Mettre à jour les tâches</button>";
                    echo "</form>";
                    } else {
                    echo "<div class='alert alert-danger'>Mission non trouvée.</div>";
                    }
                ?>
            </div>
        </div>
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

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->

    <script src="../../assets/js/form-basic-inputs.js"></script>
</body>

</html>