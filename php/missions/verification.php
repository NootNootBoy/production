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

    $updates = [];

    if ($nom !== $client['nom']) $updates['nom'] = $nom;
    if ($prenom !== $client['prenom']) $updates['prenom'] = $prenom;
    if ($societe !== $client['societe']) $updates['societe'] = $societe;
    if ($username !== $client['username']) $updates['username'] = $username;
    if ($password !== $client['password']) $updates['password'] = $password; // Assurez-vous de traiter le mot de passe correctement, comme mentionné précédemment
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

    // Mettre à jour la mission comme vérifiée
    $stmt = $pdo->prepare("UPDATE missions SET verify_done = true WHERE id_mission = :id_mission");
    $stmt->execute(['id_mission' => $id_mission]);

    header("Location: verification.php?id_mission=$id_mission");
    exit;
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
    <h1>Récapitulatif de la mission</h1>
    <h2><?php echo $mission['nom_mission']; ?></h2>
    <p>Progression : <?php echo $mission['progression']; ?>%</p>

    <form action="verification.php?id_mission=<?php echo $id_mission; ?>" method="post">
        <h1>Informations du client</h1>

        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $client['nom']; ?>"><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $client['prenom']; ?>"><br>

        <label for="societe">Société:</label>
        <input type="text" id="societe" name="societe" value="<?php echo $client['societe']; ?>"><br>

        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" value="<?php echo $client['username']; ?>"><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" value="<?php echo $client['password']; ?>"><br>

        <label for="id_analytics">ID Analytics:</label>
        <input type="text" id="id_analytics" name="id_analytics" value="<?php echo $client['id_analytics']; ?>"><br>

        <label for="id_searchconsole">ID Search Console:</label>
        <input type="text" id="id_searchconsole" name="id_searchconsole"
            value="<?php echo $client['id_searchconsole']; ?>"><br>

        <label for="domaine">Domaine:</label>
        <input type="text" id="domaine" name="domaine" value="<?php echo $client['domaine']; ?>"><br>

        <label for="mailcontact">Mail de contact:</label>
        <input type="email" id="mailcontact" name="mailcontact" value="<?php echo $client['mailcontact']; ?>"><br>

        <label for="mailpassword">Mot de passe du mail:</label>
        <input type="password" id="mailpassword" name="mailpassword" value="<?php echo $client['mailpassword']; ?>"><br>

        <label for="mailhost">Hôte du mail:</label>
        <input type="text" id="mailhost" name="mailhost" value="<?php echo $client['mailhost']; ?>"><br>

        <label for="aristatut">Aristatut (oui ou non):</label>
        <input type="text" id="aristatut" name="aristatut" value="<?php echo $client['aristatut']; ?>"><br>

        <label for="ari_activation_date">Date d'activation ARI:</label>
        <input type="date" id="ari_activation_date" name="ari_activation_date"
            value="<?php echo $client['ari_activation_date']; ?>"><br>

        <label for="ari_expiration_date">Date d'expiration ARI:</label>
        <input type="date" id="ari_expiration_date" name="ari_expiration_date"
            value="<?php echo $client['ari_expiration_date']; ?>"><br>

        <label for="redirection_emails">Redirection des e-mails:</label>
        <input type="text" id="redirection_emails" name="redirection_emails"
            value="<?php echo $client['redirection_emails']; ?>"><br>

        <label for="generation">Génération:</label>
        <input type="text" id="generation" name="generation" value="<?php echo $client['generation']; ?>"><br>

        <input type="submit" value="Mettre à jour">
    </form>


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