<?php
session_start();

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

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$societe = $_POST['societe'];
$siret = $_POST['siret'];
$email = $_POST['email'];
$phoneNumber = $_POST['phone_number'];
$temps_engagement = $_POST['temps_engagement'];
$date_signature = $_POST['date_signature'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$pays = $_POST['pays'];
$commercial_id = $_POST['commercial_id'];
$offre_id = $_POST['offre_id'];

// Vérification de la validité du numéro de téléphone (exemple pour un numéro français)
if (!preg_match('/^(\+33|0)[1-9](\d{2}){4}$/', $phoneNumber)) {
    $error_message = "Numéro de téléphone invalide.";
    header('Location: Listing_clients.php?error=true&errorMessage=' . urlencode($error_message));
    exit();
}

// Vérification de la validité de l'adresse e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_message = "Adresse e-mail invalide.";
    header('Location: Listing_clients.php?error=true&errorMessage=' . urlencode($error_message));
    exit();
}


$stmt = $pdo->prepare('INSERT INTO clients (nom, prenom, societe, siret, email, phone_number, temps_engagement, date_signature, adresse, ville, code_postal, pays, commercial_id, offre_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$nom, $prenom, $societe, $siret, $email, $phoneNumber, $temps_engagement, $date_signature, $adresse, $ville, $code_postal, $pays, $commercial_id, $offre_id]);

$client_id = $pdo->lastInsertId();

$options = $_POST['options'];
foreach ($options as $option_id) {
  $stmt = $pdo->prepare('INSERT INTO client_options (client_id, option_id) VALUES (?, ?)');
  $stmt->execute([$client_id, $option_id]);
}

$associe_nom = $_POST['associe_nom'];
$associe_prenom = $_POST['associe_prenom'];
$associe_email = $_POST['associe_email'];
$associe_telephone = $_POST['associe_telephone'];

// Vérifiez si les champs de l'associé sont remplis
if (!empty($associe_nom) && !empty($associe_prenom) && !empty($associe_email) && !empty($associe_telephone)) {
    // Insérez les informations de l'associé dans la table 'associes'
    $stmt = $pdo->prepare('INSERT INTO associes (nom, prenom, email, telephone, client_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$associe_nom, $associe_prenom, $associe_email, $associe_telephone, $client_id]);
}

if ($stmt->rowCount() > 0) {
    $_SESSION['success_message'] = 'Le client a été ajouté avec succès.';
    header('Location: Listing_clients.php?userAdded=true');
} else {
    // L'insertion a échoué
    $error_message = "L'insertion a échoué.";
    header('Location: Listing_clients.php?error=true&errorMessage=' . urlencode($error_message));
}


exit;
?>