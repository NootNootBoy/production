<?php
session_start();

$host = '176.31.132.185';
$db   = 'ohetkg_dashboar_db';
$user = 'ohetkg_dashboar_db';
$pass = '3-t2_UfA1s*Q0Iu!';
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
$temps_engagement = $_POST['temps_engagement'];
$date_signature = $_POST['date_signature'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$pays = $_POST['pays'];
$commercial_id = $_POST['commercial_id'];

$stmt = $pdo->prepare('INSERT INTO clients (nom, prenom, societe, siret, email, temps_engagement, date_signature, adresse, ville, code_postal, pays, commercial_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$nom, $prenom, $societe, $siret, $email, $temps_engagement, $date_signature, $adresse, $ville, $code_postal, $pays, $commercial_id]);

$client_id = $pdo->lastInsertId();

$options = $_POST['options'];
foreach ($options as $option_id) {
  $stmt = $pdo->prepare('INSERT INTO client_options (client_id, option_id) VALUES (?, ?)');
  $stmt->execute([$client_id, $option_id]);
}

if ($stmt->rowCount() > 0) {
    // L'insertion a réussi
    $_SESSION['success_message'] = 'Le client a été ajouté avec succès.';
} else {
    // L'insertion a échoué
    $_SESSION['error_message'] = 'Une erreur est survenue lors de l\'ajout du client.';
}

header('Location: ../dashboard.php');
exit;
?>
