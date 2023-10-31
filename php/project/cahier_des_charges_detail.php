<?php 

session_start();
require_once '../notifications/notifications.php';
include '../../php/db_connection.php';

$projet_id = $_GET['projet_id'];

$stmt = $pdo->prepare('SELECT * FROM cahier_des_charges WHERE projet_id = ?');
$stmt->execute([$projet_id]);
$cahier_des_charges = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h1>Cahier des charges pour le projet : " . htmlspecialchars($cahier_des_charges['nom_projet']) . "</h1>";

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
                            <h5 class="card-header mb-4">Liste des projets en attente :</h5>
                        </div>
                        <div class="container">
                            <div class="card">
                                <div class="card-header">
                                    <h1>Cahier des charges pour le projet :
                                        <?php echo htmlspecialchars($cahier_des_charges['nom_projet']); ?></h1>
                                </div>
                                <div class="card-body">
                                    <h5 style="color: #ff810a; margin-bottom: 20px; margin-top: 20px">Infos générales
                                    </h5>
                                    <?php if (!empty($cahier_des_charges['nom_domaine'])): ?>
                                    <p class="card-text"><strong>Nom de domaine:</strong>
                                        <?php echo htmlspecialchars($cahier_des_charges['nom_domaine']); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($cahier_des_charges['charte_graphique_existante'])): ?>
                                    <p class="card-text"><strong>Charte graphique existante:</strong>
                                        <?php echo htmlspecialchars($cahier_des_charges['charte_graphique_existante']); ?>
                                    </p>
                                    <?php endif; ?>

                                    <?php if (!empty($cahier_des_charges['idee_site'])): ?>
                                    <p class="card-text"><strong>Idée du site:</strong>
                                        <?php echo htmlspecialchars($cahier_des_charges['idee_site']); ?></p>
                                    <?php endif; ?>

                                    <h5 style="color: #ff810a; margin-bottom: 20px; margin-top: 20px">Menu</h5>

                                    <?php for ($i = 1; $i <= 3; $i++): ?>
                                    <?php if (!empty($cahier_des_charges['rubrique' . $i])): ?>
                                    <p class="card-title">Rubrique <?php echo $i; ?>:
                                        <?php echo htmlspecialchars($cahier_des_charges['rubrique' . $i]); ?></p>
                                    <ul class="list-group list-group-flush">
                                        <?php for ($j = ($i - 1) * 3 + 1; $j <= $i * 3; $j++): ?>
                                        <?php if (!empty($cahier_des_charges['sous_rubrique' . $j])): ?>
                                        <li class="list-group-item">
                                            <?php echo htmlspecialchars($cahier_des_charges['sous_rubrique' . $j]); ?>
                                        </li>
                                        <?php endif; ?>
                                        <?php endfor; ?>
                                    </ul>
                                    <?php endif; ?>
                                    <?php endfor; ?>

                                    <h5 style="color: #ff810a; margin-bottom: 20px; margin-top: 20px">SEO</h5>

                                    <?php if (!empty($cahier_des_charges['villes'])): ?>
                                    <p class="card-text"><strong>Villes:</strong>
                                        <?php echo htmlspecialchars($cahier_des_charges['villes']); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($cahier_des_charges['longues_traines'])): ?>
                                    <p class="card-text"><strong>Longues traines:</strong>
                                        <?php echo htmlspecialchars($cahier_des_charges['longues_traines']); ?></p>
                                    <?php endif; ?>

                                    <h5 style="color: #ff810a; margin-bottom: 20px; margin-top: 20px">concurrents &
                                        Partenaires</h5>
                                    <?php if (!empty($cahier_des_charges['concurrents'])): ?>
                                    <p class="card-text"><strong>Concurrents:</strong>
                                        <?php echo htmlspecialchars($cahier_des_charges['concurrents']); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($cahier_des_charges['partenaires'])): ?>
                                    <p class="card-text"><strong>Partenaires:</strong>
                                        <?php echo htmlspecialchars($cahier_des_charges['partenaires']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ DataTable with Buttons -->
                    <hr class="my-5" />
                    <!-- / Content -->
                    <!-- Edit User Modal -->

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