<?php
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

    // Préparer la requête SQL pour récupérer tous les projets
    $stmt = $pdo->prepare("SELECT * FROM Projets");
    $stmt->execute();
    $projets = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-menu-fixed" dir="ltr" data-theme="theme-default-dark"
    data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Clients List</title>

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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Projets</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-header">Listes des projets (<span
                                    class="fw-bold text-primary"><?php echo $projetCount; ?></span>) :</h5>
                            <div style="max-width: 190px;" class="me-3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editUser">
                                    Ajouter un projet
                                </button>
                            </div>
                        </div>
                        <div class="row g-4">
                            <?php
                                        $stmt = $pdo->query('SELECT * FROM Projets');

                                        while ($projet = $stmt->fetch()) {
                                            include 'project_card.php';
                                        }
                                        ?>
                        </div>
                        <!--/ DataTable with Buttons -->
                        <hr class="my-5" />
                        <!-- / Content -->
                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3>Ajouter un client</h3>
                                            <p>Toutes les informations sont obligatoires</p>
                                        </div>
                                        <form action="add_project.php" method="post" class="card-body">
                                            <h6>1. Informations Générales</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="nom_projet">Nom du projet</label>
                                                    <input type="text" id="nom_projet" name="nom_projet"
                                                        class="form-control" placeholder="Nom du projet" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="nom_domaine">Nom de domaine</label>
                                                    <input type="text" id="nom_domaine" name="nom_domaine"
                                                        class="form-control" placeholder="Nom de domaine principale"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="id_client">Client :</label>
                                                    <select id="id_client" name="id_client" class="select2 form-select">
                                                        <?php foreach ($clients as $client): ?>
                                                        <option value="<?= $client['id'] ?>"><?= $client['nom'] ?> -
                                                            <?= $client['societe'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="id_user_developpeur">Développeur
                                                        :</label>
                                                    <select id="id_user_developpeur" name="id_user_developpeur"
                                                        class="select2 form-select">
                                                        <?php foreach ($developpeurs as $developpeur): ?>
                                                        <option value="<?= $developpeur['id'] ?>">
                                                            <?= $developpeur['username'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="id_user_assistant">Assistant
                                                        :</label>
                                                    <select id="id_user_assistant" name="id_user_assistant"
                                                        class="select2 form-select">
                                                        <?php foreach ($assistants as $assistant): ?>
                                                        <option value="<?= $assistant['id'] ?>">
                                                            <?= $assistant['username'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
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
                    text: "Le client a été ajouté avec succès!",
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
        <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
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