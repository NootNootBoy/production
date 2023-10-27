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

require_once '../../php/notifications/notifications.php';


try {
    // Récupérer l'ID de la mission à partir du formulaire
    $id_mission = $_POST['id_mission'];
    $id_user = $_POST['id_user'];

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

    // Lorsque toutes les tâches sont complétées
    if ($progression == 100) {
        $stmt = $pdo->prepare("UPDATE missions SET verify_done = TRUE WHERE id_mission = :id_mission");
        $stmt->bindParam(':id_mission', $id_mission);
        $stmt->execute();

            // Envoyer une notification
        $title = "Mission complétée";
        $description = "La mission avec l'ID " . $id_mission . " a été complétée.";
        $icon = "bx-task"; // Remplacez par l'URL de votre icône
        $user_id = $id_user; // Remplacez par l'ID de l'utilisateur actuellement connecté
        $rang = null; // Pas de rang spécifique pour cette notification

        send_notification($pdo, $title, $description, $icon, $user_id, $rang);
    }

    $_SESSION['success_message'] = 'Les tâches ont été mises à jour avec succès.';
    
    // Vérifiez si l'utilisateur est connecté et récupérez son rôle
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_rang'])) {
        $user_id = $_SESSION['user_id'];
        $user_rang = $_SESSION['user_rang'];

        // Vous pouvez maintenant utiliser $user_role pour des conditions ou des redirections
        // Par exemple :
        if ($user_rang == 'developpeur') {
            header('Location: listing_missions.php?userAdded=true');
        } elseif ($user_rang == 'administrateur') {
            header('Location: listing_all_missions.php?userAdded=true');
        }
    } else {
        header('Location: listing_missions.php');
    }

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>