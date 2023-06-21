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

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['user_id'])) {
    die('User ID not set in session');
}



// Récupérer l'ID de l'utilisateur actuellement connecté
$id_user = $_SESSION['user_id'];

try {
    // Préparer la requête SQL pour récupérer les missions en attente
    $stmt = $pdo->prepare("SELECT * FROM missions WHERE id_user = :id_user AND etat = 'en attente'");

    // Lier les paramètres
    $stmt->bindParam(':id_user', $id_user);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats
    $missions = $stmt->fetchAll();

    // Afficher les missions
    foreach ($missions as $mission) {
        echo "<h2>" . $mission['nom_mission'] . "</h2>";
        echo "<form action='update_mission.php' method='post'>";
        echo "<input type='hidden' name='id_mission' value='" . $mission['id_mission'] . "'>";
        echo "<input type='submit' name='action' value='Accepter'>";
        echo "<input type='submit' name='action' value='Refuser'>";
        echo "</form>";
    }

     // Récupérer toutes les tâches de la mission
     $stmt = $pdo->prepare("SELECT * FROM Taches WHERE id_mission = :id_mission");
     $stmt->bindParam(':id_mission', $id_mission);
     $stmt->execute();
     $taches = $stmt->fetchAll();

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php 
      echo "<form action='update_taches.php' method='post'>";
      echo "<input type='hidden' name='id_mission' value='" . $id_mission . "'>";
      foreach ($taches as $tache) {
          echo "<div>";
          echo "<input type='checkbox' id='tache" . $tache['id_tache'] . "' name='tache" . $tache['id_tache'] . "' " . ($tache['etat'] == 'complétée' ? 'checked' : '') . ">";
          echo "<label for='tache" . $tache['id_tache'] . "'>" . $tache['nom_tache'] . "</label>";
          echo "</div>";
      }
      echo "<input type='submit' value='Mettre à jour les tâches'>";
      echo "</form>";
    ?>
</body>

</html>