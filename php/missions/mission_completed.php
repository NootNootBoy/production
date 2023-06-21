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
    // Récupérer l'ID de la mission à partir du formulaire
    $id_mission = $_POST['id_mission'];

    // Mettre à jour l'état de la mission à "terminée"
    $stmt = $pdo->prepare("UPDATE missions SET etat = 'terminée' WHERE id_mission = :id_mission");
    $stmt->bindParam(':id_mission', $id_mission);
    $stmt->execute();

    echo "Mission marquée comme terminée avec succès";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>