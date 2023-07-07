<?php 
session_start();
include '../db_connection.php';
include '../notifications/notifications.php';

$objectif = $_POST['objectif'];

// Récupérer l'ID de l'agence de l'utilisateur
$stmt = $pdo->prepare('SELECT agence_id FROM users WHERE id = ?');
$stmt->execute([$_SESSION['userId']]);
$user = $stmt->fetch();
$agenceId = $user['agence_id'];

// Récupérer le mois actuel
$mois = date('Y-m-01'); // Premier jour du mois actuel

$stmt = $pdo->prepare('
    INSERT INTO objectifs (agence_id, mois, objectif)
    VALUES (:agenceId, :mois, :objectif)
    ON DUPLICATE KEY UPDATE objectif = :objectif
');
$stmt->execute(['agenceId' => $agenceId, 'mois' => $mois, 'objectif' => $objectif]);

header('Location: ../dashboard.php');
exit;
?>