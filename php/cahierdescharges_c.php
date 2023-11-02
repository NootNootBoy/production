<?php

session_start();
include './notifications/notifications.php';

// Connexion à la base de données
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

// Récupérer les offres de la base de données
try {
    $stmt = $pdo->prepare("SELECT id, nom FROM offres");
    $stmt->execute();
    $offres = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Récupérer les clients de la base de données
try {
    $stmt = $pdo->prepare("SELECT id, nom, prenom FROM clients");
    $stmt->execute();
    $clients = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Création de Projet</title>
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
</head>

<body>
    <!-- Layout wrapper -->
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
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <form action="traitement_projet.php" method="post" enctype="multipart/form-data">
                            <h2 class="mb-4">1) Créer ou Sélectionner un Client</h2>

                            <div class="form-check mb-3">
                                <input type="radio" id="nouveau_client" name="type_client" value="nouveau" checked
                                    class="form-check-input">
                                <label for="nouveau_client" class="form-check-label">Nouveau Client</label>
                            </div>

                            <div class="form-check mb-3">
                                <input type="radio" id="client_existant" name="type_client" value="existant"
                                    class="form-check-input">
                                <label for="client_existant" class="form-check-label">Client Existant</label>
                            </div>

                            <!-- Champs pour un nouveau client -->
                            <div id="nouveau_client_champs">
                                <input type="text" name="nom" placeholder="Nom" class="form-control mb-3">
                                <input type="text" name="prenom" placeholder="Prénom" class="form-control mb-3">
                                <input type="text" name="societe" placeholder="Société" class="form-control mb-3">
                                <input type="text" name="siret" placeholder="SIRET" class="form-control mb-3">
                                <input type="email" name="email" placeholder="Email" class="form-control mb-3">
                                <input type="text" name="phone_number" placeholder="Numéro de téléphone"
                                    class="form-control mb-3">
                                <div class="mb-3">
                                    <label for="commercial_id" class="form-label">Commercial</label>
                                    <select name="commercial_id" id="commercial_id" class="form-select">
                                        <?php 
                                        $stmt = $pdo->prepare("SELECT * FROM users WHERE rang = 'commercial' OR rang = 'administrateur'");
                                        $stmt->execute();
                                        $commerciaux = $stmt->fetchAll();
                                        foreach ($commerciaux as $commercial): ?>
                                        <option value="<?php echo $commercial['id']; ?>">
                                            <?php echo $commercial['prenom'] . ' ' . $commercial['nom']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Champs pour sélectionner un client existant -->
                            <div id="client_existant_champs" style="display: none;">
                                <select name="client_id" class="form-select mb-3">
                                    <?php foreach ($clients as $client): ?>
                                    <option value="<?php echo $client['id']; ?>">
                                        <?php echo htmlspecialchars($client['nom']) . " " . htmlspecialchars($client['prenom']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <h2 class="mb-4">2) Sélectionner une Offre</h2>
                            <select name="offre_id" class="form-select mb-3" id="select_offre">
                                <option value="">Sélectionner une offre...</option>
                                <?php foreach ($offres as $offre): ?>
                                <option value="<?php echo $offre['id']; ?>">
                                    <?php echo htmlspecialchars($offre['nom']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>


                            <h2 class="mb-4">3) Créer un Cahier des Charges</h2>

                            <input type="text" name="nom_projet" placeholder="Nom du Projet" required
                                class="form-control mb-3">
                            <textarea name="longues_traines" placeholder="Longues Traînes (séparer par des virgules)"
                                class="form-control mb-3"></textarea>
                            <input type="text" name="nom_domaine" placeholder="Potentiel nom de domaine" required
                                class="form-control mb-3">
                            <div class="tree-view">
                                <ul class="mb-3">
                                    <li>
                                        <input type="text" name="rubrique1" placeholder="Rubrique 1"
                                            class="form-control mb-2">
                                        <ul>
                                            <li><input type="text" name="sous_rubrique1" placeholder="Sous-rubrique 1"
                                                    class="form-control mb-2"></li>
                                            <li><input type="text" name="sous_rubrique2" placeholder="Sous-rubrique 2"
                                                    class="form-control mb-2"></li>
                                            <li><input type="text" name="sous_rubrique3" placeholder="Sous-rubrique 3"
                                                    class="form-control mb-2"></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <input type="text" name="rubrique2" placeholder="Rubrique 2"
                                            class="form-control mb-2">
                                        <ul>
                                            <li><input type="text" name="sous_rubrique4" placeholder="Sous-rubrique 4"
                                                    class="form-control mb-2"></li>
                                            <li><input type="text" name="sous_rubrique5" placeholder="Sous-rubrique 5"
                                                    class="form-control mb-2"></li>
                                            <li><input type="text" name="sous_rubrique6" placeholder="Sous-rubrique 6"
                                                    class="form-control mb-2"></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <input type="text" name="rubrique3" placeholder="Rubrique 3"
                                            class="form-control mb-2">
                                        <ul>
                                            <li><input type="text" name="sous_rubrique7" placeholder="Sous-rubrique 7"
                                                    class="form-control mb-2"></li>
                                            <li><input type="text" name="sous_rubrique8" placeholder="Sous-rubrique 8"
                                                    class="form-control mb-2"></li>
                                            <li><input type="text" name="sous_rubrique9" placeholder="Sous-rubrique 9"
                                                    class="form-control mb-2"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <textarea name="infos_complementaires" placeholder="Informations Complémentaires"
                                class="form-control mb-3"></textarea>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="charte_graphique_existante" value="1"
                                    class="form-check-input">
                                <label class="form-check-label">Charte Graphique Existante</label>
                            </div>
                            <textarea name="idee_site" placeholder="Idée du Site" class="form-control mb-3"></textarea>
                            <textarea name="concurrents" placeholder="Concurrents" class="form-control mb-3"></textarea>
                            <textarea name="partenaires" placeholder="Partenaires" class="form-control mb-3"></textarea>
                            <textarea name="villes" placeholder="Villes" class="form-control mb-3"></textarea>
                            <h5>Images annexes</h5>
                            <input type="file" name="image1" id="image1" class="form-control mb-3">
                            <input type="file" name="image2" id="image2" class="form-control mb-3">
                            <button type="submit" class="btn btn-primary">Créer Projet</button>
                        </form>
                        <!-- / Layout page -->
                    </div>
                    <!-- Overlay -->
                    <div class="layout-overlay layout-menu-toggle"></div>
                    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
                    <div class="drag-target"></div>
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

            <script>
            // Script pour afficher/masquer les champs en fonction du choix de l'utilisateur
            document.getElementById('nouveau_client').addEventListener('change', function() {
                document.getElementById('nouveau_client_champs').style.display = 'block';
                document.getElementById('client_existant_champs').style.display = 'none';
            });

            document.getElementById('client_existant').addEventListener('change', function() {
                document.getElementById('nouveau_client_champs').style.display = 'none';
                document.getElementById('client_existant_champs').style.display = 'block';
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Masquer toutes les sous-rubriques au chargement de la page
                masquerToutesSousRubriques();
            });

            function masquerToutesSousRubriques() {
                var sousRubriques = document.querySelectorAll('.tree-view ul ul');
                sousRubriques.forEach(function(sousRubrique) {
                    sousRubrique.style.display = 'none';
                });
            }

            document.getElementById('select_offre').addEventListener('change', function() {
                var offreId = this.value;

                // Masquer toutes les sous-rubriques par défaut
                masquerToutesSousRubriques();

                // Afficher les sous-rubriques en fonction de l'offre sélectionnée
                switch (offreId) {
                    case '1': // ID de l'offre Ambition
                        afficherSousRubriques(1);
                        break;
                    case '2': // ID de l'offre Performance
                        afficherSousRubriques(2);
                        break;
                    case '3': // ID de l'offre Excellence
                        afficherSousRubriques(3);
                        break;
                }

                // Désactiver l'option par défaut
                document.querySelector('#select_offre option[value=""]').disabled = true;
            });

            function afficherSousRubriques(nombreRubriques) {
                for (var i = 1; i <= nombreRubriques; i++) {
                    var sousRubriques = document.querySelector('.tree-view ul li:nth-child(' + i + ') ul');
                    if (sousRubriques) {
                        sousRubriques.style.display = 'block';
                    }
                }
            }
            </script>
</body>

</html>