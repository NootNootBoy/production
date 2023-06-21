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
    // Récupérer l'ID de la mission et l'action à partir du formulaire
    $id_mission = $_POST['id_mission'];
    $action = $_POST['action'];

    if ($action == 'Accepter') {
        // Si l'utilisateur a accepté la mission, mettre à jour l'état de la mission et créer les tâches
    
        // Mettre à jour l'état de la mission
        $stmt = $pdo->prepare("UPDATE Missions SET etat = 'acceptée' WHERE id_mission = :id_mission");
        $stmt->bindParam(':id_mission', $id_mission);
        $stmt->execute();
    
        // Récupérer toutes les tâches prédéfinies
        $stmt = $pdo->prepare("SELECT * FROM tachesPredefinies");
        $stmt->execute();
        $taches_predefinies = $stmt->fetchAll();
    
        // Pour chaque tâche prédéfinie, créer une nouvelle tâche pour la mission
        $stmt = $pdo->prepare("INSERT INTO taches (id_mission, id_tache_predefinie) VALUES (:id_mission, :id_tache_predefinie)");
        $stmt->bindParam(':id_mission', $id_mission);
        foreach ($taches_predefinies as $tache_predefinie) {
            $stmt->bindParam(':id_tache_predefinie', $tache_predefinie['id_tache_predefinie']);
            $stmt->execute();
        }
    
        echo "Mission acceptée et tâches créées avec succès";
    } else if ($action == 'Refuser') {
        // Si l'utilisateur a refusé la mission, mettre à jour l'état de la mission

        $stmt = $pdo->prepare("UPDATE missions SET etat = 'refusée' WHERE id_mission = :id_mission");
        $stmt->bindParam(':id_mission', $id_mission);
        $stmt->execute();

        echo "Mission refusée avec succès";
    } else {
        // Si l'action n'est ni "Accepter" ni "Refuser", afficher une erreur
        echo "Action non reconnue";
    }
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>