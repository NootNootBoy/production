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

    // Récupérer toutes les tâches de la mission
    $stmt = $pdo->prepare("SELECT * FROM taches WHERE id_mission = :id_mission");
    $stmt->bindParam(':id_mission', $id_mission);
    $stmt->execute();
    $taches = $stmt->fetchAll();

    // Pour chaque tâche, mettre à jour son état en fonction de si sa case a été cochée ou non
    $stmt = $pdo->prepare("UPDATE taches SET etat = :etat WHERE id_tache = :id_tache");
    foreach ($taches as $tache) {
        $etat = isset($_POST['tache' . $tache['id_tache']]) ? 'complétée' : 'non complétée';
        $stmt->bindParam(':etat', $etat);
        $stmt->bindParam(':id_tache', $tache['id_tache']);
        $stmt->execute();
    }

    echo "Tâches mises à jour avec succès";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>