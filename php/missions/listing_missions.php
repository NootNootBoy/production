<?php
session_start();

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['user_id'])) {
    die('User ID not set in session');
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

// Récupérer l'ID de l'utilisateur actuellement connecté
$id_user = $_SESSION['user_id'];

try {
    // Préparer la requête SQL pour récupérer les missions en attente
    $stmt = $pdo->prepare("SELECT * FROM Missions WHERE id_user = :id_user AND etat = 'en attente'");

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
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>