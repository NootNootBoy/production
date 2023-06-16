<?php
// Votre code pour se connecter à la base de données ici
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

$stmt = $pdo->prepare('SELECT * FROM options');
$stmt->execute();
$options = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT * FROM users WHERE rang = "commercial"');
$stmt->execute();
$commerciaux = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

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
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

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
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include 'components/menu.php'; ?>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include 'components/navbar.php'; ?>
                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Clients</h4>
                        <div class="card mb-4">
                            <h5 class="card-header">Ajouter un Client</h5>
                            <form action="add_client.php" method="post" class="card-body">
                                <h6>1. Informations Générales</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="nom">Nom</label>
                                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Dupont"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="prenom">Prénom</label>
                                        <input type="text" id="prenom" name="prenom" class="form-control"
                                            placeholder="Jean" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="societe">Société</label>
                                        <input type="text" id="societe" name="societe" class="form-control"
                                            placeholder="Dupont SA" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="siret">SIRET</label>
                                        <input type="text" id="siret" name="siret" class="form-control"
                                            placeholder="123 456 789 00012" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="jean.dupont@example.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="phone_number">Email</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-control"
                                            placeholder="065120...." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="temps_engagement">Temps d'engagement
                                            (mois)</label>
                                        <input type="number" id="temps_engagement" name="temps_engagement"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="date_signature">Date de signature</label>
                                        <input type="date" id="date_signature" name="date_signature"
                                            class="form-control" required>
                                    </div>

                                </div>

                                <hr class="my-4 mx-n4" />
                                <h6>2. Adresse</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="adresse">Adresse</label>
                                        <input type="text" id="adresse" name="adresse" class="form-control"
                                            placeholder="123 rue du Pont" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="ville">Ville</label>
                                        <input type="text" id="ville" name="ville" class="form-control"
                                            placeholder="Paris" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="code_postal">Code Postal</label>
                                        <input type="text" id="code_postal" name="code_postal" class="form-control"
                                            placeholder="75001" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="pays">Pays</label>
                                        <input type="text" id="pays" name="pays" class="form-control"
                                            placeholder="France" required>
                                    </div>
                                </div>

                                <hr class="my-4 mx-n4" />
                                <h6>3. Options et Commercial</h6>
                                <div class="row g-3">
                                    <?php foreach ($options as $option): ?>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="option<?php echo $option['id']; ?>" name="options[]"
                                            class="form-check-input" value="<?php echo $option['id']; ?>">
                                        <label class="form-check-label"
                                            for="option<?php echo $option['id']; ?>"><?php echo $option['nom']; ?></label>
                                    </div>
                                    <?php endforeach; ?>

                                    <div class="col-md-6">
                                        <label class="form-label" for="commercial_id">Commercial</label>
                                        <select id="commercial_id" name="commercial_id" class="select2 form-select">
                                            <?php foreach ($commerciaux as $commercial): ?>
                                            <option value="<?php echo $commercial['id']; ?>">
                                                <?php echo $commercial['prenom'] . ' ' . $commercial['nom']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <hr class="my-4 mx-n4" />
                                <div class="pt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Ajouter le
                                        Client</button>
                                    <button type="reset" class="btn btn-label-secondary">Annuler</button>
                                </div>
                            </form>
                        </div>
                        <!-- Modal to add new record -->
                        <div class="offcanvas offcanvas-end" id="add-new-record">
                            <!-- Your modal content here -->
                        </div>
                        <!--/ DataTable with Buttons -->
                        <hr class="my-5" />
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
        <script src="../assets/js/dashboards-analytics.js"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>