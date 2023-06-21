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
    $stmt = $pdo->prepare("UPDATE taches SET est_complete = :est_complete WHERE id_tache = :id_tache");
    foreach ($taches as $tache) {
        $est_complete = isset($_POST['tache' . $tache['id_tache']]) ? 1 : 0;
        $stmt->bindParam(':est_complete', $est_complete, PDO::PARAM_INT);
        $stmt->bindParam(':id_tache', $tache['id_tache'], PDO::PARAM_INT);
        $stmt->execute();
    }

    // Compter le nombre total de tâches et le nombre de tâches complétées
    $nombre_total_taches = count($taches);
    $nombre_taches_completees = 0;
    foreach ($taches as $tache) {
        $est_complete = isset($_POST['tache' . $tache['id_tache']]) ? 1 : 0;
        $stmt->bindParam(':est_complete', $est_complete, PDO::PARAM_INT);
        $stmt->bindParam(':id_tache', $tache['id_tache'], PDO::PARAM_INT);
        $stmt->execute();
        if ($est_complete == 1) {
            $nombre_taches_completees++;
        }
    }

    // Calculer le pourcentage de tâches complétées
    $progression = ($nombre_taches_completees / $nombre_total_taches) * 100;


    // Mettre à jour la progression dans la base de données
    $stmt = $pdo->prepare("UPDATE missions SET progression = :progression WHERE id_mission = :id_mission");
    $stmt->bindParam(':progression', $progression, PDO::PARAM_INT);
    $stmt->bindParam(':id_mission', $id_mission, PDO::PARAM_INT);
    $stmt->execute();

    if($progression === 100){
        $stmt = $pdo->prepare("UPDATE missions SET etat = 'terminé' WHERE id_mission = :id_mission");
        $stmt->bindParam(':id_mission', $id_mission, PDO::PARAM_INT);
        $stmt->execute();
    }

    echo "Tâches mises à jour avec succès";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>