<?php

session_start();
include '../notifications/notifications.php';

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

try {
    // Préparer la requête SQL pour récupérer tous les clients
    $stmt = $pdo->prepare("SELECT * FROM clients");
    $stmt->execute();
    $clients = $stmt->fetchAll();

    // Préparer la requête SQL pour récupérer tous les développeurs
    $stmt = $pdo->prepare("SELECT * FROM users WHERE rang = 'developpeur'");
    $stmt->execute();
    $developpeurs = $stmt->fetchAll();

    // Préparer la requête SQL pour récupérer tous les assistants
    $stmt = $pdo->prepare("SELECT * FROM users WHERE rang = 'assistant'");
    $stmt->execute();
    $assistants = $stmt->fetchAll();

    // Préparer la requête SQL pour récupérer tous les projets en attente
    $stmt = $pdo->prepare("SELECT * FROM Projets WHERE status = 'en attente'");
    $stmt->execute();
    $projetsEnAttente = $stmt->fetchAll();
    $clientCount = 0; // Initialise la variable $clientCount à 0 avant la boucle
    while ($client = $stmt->fetch()) {
        $clientCount++; // Incrémente la variable $clientCount pour chaque client
    }


} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>

<html lang="fr" class="dark-style layout-menu-fixed" dir="ltr" data-theme="theme-default-dark"
    data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Projets List</title>

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
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core-dark.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default-dark.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->

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
            <?php include '../../php/components/menu.php'; ?>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include '../../php/components/navbar.php'; ?>
                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Projets en
                            Attente</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-header">Liste des projets en attente :</h5>
                        </div>
                        <div class="row g-4">
                            <?php
                foreach ($projetsEnAttente as $projet) {
                    // Inclure le code pour afficher les informations du projet en attente
                    // Remplacer la barre de tâches par un bouton "Compléter"
                    echo '<div class="col-md-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $projet['nom_projet'] . '</h5>';
                    // Afficher d'autres informations du projet en attente ici
                    echo '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#completerProjetModal" data-id="' . $projet['id_projet'] . '">Compléter</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            ?>
                        </div>
                    </div>
                    <!--/ DataTable with Buttons -->
                    <hr class="my-5" />
                    <!-- / Content -->
                    <!-- Edit User Modal -->
                    <!-- Modal pour compléter le projet -->
                    <div class="modal fade" id="completerProjetModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-simple">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3>Compléter le Projet</h3>
                                        <p>Assigner un développeur et un assistant au projet</p>
                                    </div>
                                    <form action="completer_projet.php" method="post" class="card-body">
                                        <input type="hidden" id="id_projet" name="id_projet">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="id_user_developpeur">Développeur
                                                    :</label>
                                                <select id="id_user_developpeur" name="id_user_developpeur"
                                                    class="form-select">
                                                    <?php foreach ($developpeurs as $developpeur): ?>
                                                    <option value="<?= $developpeur['id'] ?>">
                                                        <?= $developpeur['username'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="id_user_assistant">Assistant :</label>
                                                <select id="id_user_assistant" name="id_user_assistant"
                                                    class="form-select">
                                                    <?php foreach ($assistants as $assistant): ?>
                                                    <option value="<?= $assistant['id'] ?>">
                                                        <?= $assistant['username'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pt-4">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Compléter le
                                                projet</button>
                                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">Annuler</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Edit User Modal -->
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Vérifie les paramètres dans l'URL
        var urlParams = new URLSearchParams(window.location.search);
        var userAdded = urlParams.get('userAdded');
        var error = urlParams.get('error');
        var errorMessage = urlParams.get('errorMessage');

        // Si 'userAdded' est vrai, affiche l'alerte de succès
        if (userAdded === 'true') {
            Swal.fire({
                title: 'Bien joué!',
                text: "Le projet a été ajouté avec succès!",
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }
        // Sinon, s'il y a une erreur, affiche l'alerte d'erreur
        else if (error === 'true') {
            Swal.fire({
                title: 'Erreur!',
                text: errorMessage,
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var completerProjetModal = document.getElementById('completerProjetModal');
        completerProjetModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var idProjet = button.getAttribute('data-id');
            var modalBodyInput = completerProjetModal.querySelector('.modal-body #id_projet');
            modalBodyInput.value = idProjet;

            // Charger les informations existantes du projet ici
            // Par exemple, en utilisant une requête AJAX
        });
    });
    </script>
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
    <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../../assets/js/extended-ui-sweetalert2.js"></script>
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <!-- Flat Picker -->
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <!-- Form Validation -->
    <script src="../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/tables-datatables-basic.js"></script>
</body>

</html>