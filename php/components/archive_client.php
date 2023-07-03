<?php
// Connexion à la base de données.
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

// Récupération de l'identifiant du client depuis l'URL.
$client_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($client_id) {
  // Mise à jour du statut du client dans la base de données.
  $stmt = $pdo->prepare("UPDATE clients SET statut = 'archived' WHERE id = ?");
  $stmt->execute([$client_id]);
  
} else {
  echo "ID de client invalide.";
}
?>