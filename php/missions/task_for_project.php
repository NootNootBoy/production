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
    <div class="col-xl-6">
        <div class="card mb-4">
            <h5 class="card-header">Checkboxes and Radios</h5>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md">
                        <small class="text-light fw-semibold">Tâches :</small>
                        <div class="form-check mt-3">
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM missions WHERE id_mission = :id_mission");
                            $stmt->bindParam(':id_mission', $id_mission);
                            $stmt->execute();
                            $mission = $stmt->fetch();

                            if ($mission) {
                                echo "<h2>" . $mission['nom_mission'] . "</h2>";

                                // Récupérer toutes les tâches de la mission
                                $stmt = $pdo->prepare("SELECT taches.*, taches_predefinies.nom_tache, taches_predefinies.categorie_tache FROM taches INNER JOIN taches_predefinies ON taches.id_tache_predefinie = taches_predefinies.id_tache_predefinie WHERE id_mission = :id_mission ORDER BY taches_predefinies.categorie_tache");
                                $stmt->bindParam(':id_mission', $id_mission);
                                $stmt->execute();
                                $taches = $stmt->fetchAll();

                                // Triez les tâches par catégorie
                                $taches_par_categorie = [];
                                foreach ($taches as $tache) {
                                    $taches_par_categorie[$tache['categorie_tache']][] = $tache;
                                }

                                // Afficher les tâches triées par catégorie
                                echo "<form action='update_taches.php' method='post'>";
                                echo "<input type='hidden' name='id_mission' value='" . $mission['id_mission'] . "'>";
                                echo "<input type='hidden' name='id_user' value='" . $mission['id_user'] . "'>";
                                foreach ($taches_par_categorie as $categorie => $taches_categorie) {
                                    echo "<h3>" . $categorie . "</h3>"; // Titre de la catégorie
                                    foreach ($taches_categorie as $tache) {
                                        echo "<div>";
                                        echo "<input type='checkbox' id='tache" . $tache['id_tache'] . "' name='tache" . $tache['id_tache'] . "' " . ($tache['est_complete'] == '1' ? 'checked' : '') . ">";
                                        echo "<label for='tache" . $tache['id_tache'] . "'>" . $tache['nom_tache'] . "</label>";
                                        echo "</div>";
                                    }
                                }
                                echo "<input type='submit' value='Mettre à jour les tâches'>";
                                echo "</form>";
                            } else {
                                echo "Mission non trouvée.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
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