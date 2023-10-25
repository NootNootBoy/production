<?php

session_start();
include '../notifications/notifications.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SESSION['rang'] !== 'administrateur' && $_SESSION['rang'] !== 'assistant' && $_SESSION['rang'] !== 'developpeur') {
    header('Location: /php/access_denied.html');
    exit;
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

$id_mission = $_GET['id_mission'];

// Récupérer les informations de la mission
$stmt = $pdo->prepare("SELECT * FROM missions WHERE id_mission = :id_mission");
$stmt->bindParam(':id_mission', $id_mission);
$stmt->execute();
$mission = $stmt->fetch();

// Récupérer les informations du client associé à cette mission via le projet
$stmt = $pdo->prepare("SELECT clients.* FROM clients INNER JOIN Projets ON clients.id = Projets.id_client WHERE Projets.id_projet = :id_projet");
$stmt->bindParam(':id_projet', $mission['id_projet']);
$stmt->execute();
$client = $stmt->fetch();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['update'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $societe = $_POST['societe'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Vous devrez probablement gérer cela différemment car il est hashé
    $id_analytics = $_POST['id_analytics'];
    $id_searchconsole = $_POST['id_searchconsole'];
    $domaine = $_POST['domaine'];
    $mailcontact = $_POST['mailcontact'];
    $mailpassword = $_POST['mailpassword'];
    $mailhost = $_POST['mailhost'];
    $aristatut = $_POST['aristatut'];
    $ari_activation_date = $_POST['ari_activation_date'];
    $ari_expiration_date = $_POST['ari_expiration_date'];
    $redirection_emails = $_POST['redirection_emails'];
    $generation = $_POST['generation'];
    $_SESSION['updated'] = true;

    $updates = [];

    if ($nom !== $client['nom']) $updates['nom'] = $nom;
    if ($prenom !== $client['prenom']) $updates['prenom'] = $prenom;
    if ($societe !== $client['societe']) $updates['societe'] = $societe;
    if ($username !== $client['username']) $updates['username'] = $username;
    if (isset($_POST['password']) && $_POST['password'] !== $client['password']) {
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $updates['password'] = $hashed_password;
    }
    if ($id_analytics !== $client['id_analytics']) $updates['id_analytics'] = $id_analytics;
    if ($id_searchconsole !== $client['id_searchconsole']) $updates['id_searchconsole'] = $id_searchconsole;
    if ($domaine !== $client['domaine']) $updates['domaine'] = $domaine;
    if ($mailcontact !== $client['mailcontact']) $updates['mailcontact'] = $mailcontact;
    if ($mailpassword !== $client['mailpassword']) $updates['mailpassword'] = $mailpassword;
    if ($mailhost !== $client['mailhost']) $updates['mailhost'] = $mailhost;
    if ($aristatut !== $client['aristatut']) $updates['aristatut'] = $aristatut;
    if ($ari_activation_date !== $client['ari_activation_date']) $updates['ari_activation_date'] = $ari_activation_date;
    if ($ari_expiration_date !== $client['ari_expiration_date']) $updates['ari_expiration_date'] = $ari_expiration_date;
    if ($redirection_emails !== $client['redirection_emails']) $updates['redirection_emails'] = $redirection_emails;
    if ($generation !== $client['generation']) $updates['generation'] = $generation;    

    foreach ($updates as $key => $value) {
        $stmt = $pdo->prepare("UPDATE clients SET $key = :value WHERE id = :id");
        $stmt->execute(['value' => $value, 'id' => $client['id']]);
    }

    header("Location: verification.php?id_mission=$id_mission");
    exit;
}

    // Si le bouton "Marquer comme terminée" a été cliqué
    if (isset($_POST['complete'])) {
    // Mettre à jour la mission comme vérifiée
    $stmt = $pdo->prepare("UPDATE missions SET verify_done = true WHERE id_mission = :id_mission");
    $stmt->execute(['id_mission' => $id_mission]);

    // Mettre à jour l'état de la mission comme "terminée"
    $stmt = $pdo->prepare("UPDATE missions SET etat = 'terminée' WHERE id_mission = :id_mission");
    $stmt->execute(['id_mission' => $id_mission]);

    header("Location: listing_all_missions.php");
    exit;
    }

    
}

?>

<!DOCTYPE html>

<html lang="fr" class="dark-style layout-menu-fixed" dir="ltr" data-theme="theme-default-dark"
    data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Mes missions</title>

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
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1>Récapitulatif de la mission</h1>
            <h2 class="mt-3"><?php echo $mission['nom_mission']; ?></h2>
            <p class="mt-2">Progression : <?php echo $mission['progression']; ?>%</p>
        </div>

        <form action="verification.php?id_mission=<?php echo $id_mission; ?>" method="post">
            <h3 class="mb-4">Informations du client</h3>
            <div class="row g-3">
                <!-- Nom -->
                <div class="col-md-6">
                    <label class="form-label" for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control" required
                        value="<?php echo htmlspecialchars($client['nom']); ?>">
                </div>

                <!-- Prénom -->
                <div class="col-md-6">
                    <label class="form-label" for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required
                        value="<?php echo htmlspecialchars($client['prenom']); ?>">
                </div>

                <!-- Société -->
                <div class="col-md-6">
                    <label class="form-label" for="societe">Société</label>
                    <input type="text" id="societe" name="societe" class="form-control" required
                        value="<?php echo htmlspecialchars($client['societe']); ?>">
                </div>

                <!-- Nom d'utilisateur -->
                <div class="col-md-6">
                    <label class="form-label" for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="MI-societéXXXX"
                        required value="<?php echo htmlspecialchars($client['username']); ?>">
                </div>

                <!-- Mot de passe -->
                <div class="col-md-6">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="********"
                        required value="<?php echo htmlspecialchars($client['password']); ?>">
                </div>

                <!-- ID Analytics -->
                <div class="col-md-6">
                    <label class="form-label" for="id_analytics">ID Analytics</label>
                    <input type="text" id="id_analytics" name="id_analytics" class="form-control" required
                        value="<?php echo htmlspecialchars($client['id_analytics']); ?>">
                </div>

                <!-- ID Search Console -->
                <div class="col-md-6">
                    <label class="form-label" for="id_searchconsole">ID Search Console</label>
                    <input type="text" id="id_searchconsole" name="id_searchconsole" class="form-control" required
                        value="<?php echo htmlspecialchars($client['id_searchconsole']); ?>">
                </div>

                <!-- Domaine -->
                <div class="col-md-6">
                    <label class="form-label" for="domaine">Domaine</label>
                    <input type="text" id="domaine" name="domaine" class="form-control" required
                        value="<?php echo htmlspecialchars($client['domaine']); ?>">
                </div>

                <!-- Mail de contact -->
                <div class="col-md-6">
                    <label class="form-label" for="mailcontact">Mail de contact</label>
                    <input type="email" id="mailcontact" name="mailcontact" class="form-control" required
                        value="<?php echo htmlspecialchars($client['mailcontact']); ?>">
                </div>

                <!-- Mot de passe du mail -->
                <div class="col-md-6">
                    <label class="form-label" for="mailpassword">Mot de passe du mail</label>
                    <input type="password" id="mailpassword" name="mailpassword" class="form-control" required
                        value="<?php echo htmlspecialchars($client['mailpassword']); ?>">
                </div>

                <!-- Hôte du mail -->
                <div class="col-md-6">
                    <label class="form-label" for="mailhost">Hôte du mail</label>
                    <input type="text" id="mailhost" name="mailhost" class="form-control" required
                        value="<?php echo htmlspecialchars($client['mailhost']); ?>">
                </div>

                <!-- Aristatut -->
                <div class="col-md-6">
                    <label class="form-label" for="aristatut">Aristatut (oui ou non)</label>
                    <input type="text" id="aristatut" name="aristatut" class="form-control" required
                        value="<?php echo htmlspecialchars($client['aristatut']); ?>">
                </div>

                <!-- Date d'activation ARI -->
                <div class="col-md-6">
                    <label class="form-label" for="ari_activation_date">Date d'activation ARI</label>
                    <input type="date" id="ari_activation_date" name="ari_activation_date" class="form-control"
                        value="<?php echo htmlspecialchars($client['ari_activation_date']); ?>">
                </div>

                <!-- Date d'expiration ARI -->
                <div class="col-md-6">
                    <label class="form-label" for="ari_expiration_date">Date d'expiration ARI</label>
                    <input type="date" id="ari_expiration_date" name="ari_expiration_date" class="form-control"
                        value="<?php echo htmlspecialchars($client['ari_expiration_date']); ?>">
                </div>

                <!-- Redirection des e-mails -->
                <div class="col-md-6">
                    <label class="form-label" for="redirection_emails">Redirection des e-mails</label>
                    <input type="text" id="redirection_emails" name="redirection_emails" class="form-control"
                        value="<?php echo htmlspecialchars($client['redirection_emails']); ?>">
                </div>

                <!-- Génération -->
                <div class="col-md-6">
                    <label class="form-label" for="generation">Génération</label>
                    <input type="text" id="generation" name="generation" class="form-control" required
                        value="<?php echo htmlspecialchars($client['generation']); ?>">
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <input type="submit" name="update" value="Mettre à jour" class="btn btn-primary">
                <input type="submit" name="complete" value="Marquer comme terminée" class="btn btn-success">
            </div>
        </form>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="updateToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Mise à jour effectuée avec succès !
            </div>
        </div>
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

    <?php 
    
    if (isset($_SESSION['updated']) && $_SESSION['updated']) {
        echo "<script>$(document).ready(function() { var toast = new bootstrap.Toast(document.getElementById('updateToast')); toast.show(); });</script>";
        unset($_SESSION['updated']); // Réinitialisez la variable de session pour ne pas afficher le Toast à chaque rafraîchissement
    }
    
    ?>

</body>

</html>