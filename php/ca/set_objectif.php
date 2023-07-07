<?php 
session_start();
include '../db_connection.php';
include '../notifications/notifications.php';

$objectif = $_POST['objectif'];
$username = $_SESSION['username'];

// Récupérer l'ID de l'agence de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT agence_id FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$agenceId = $user['agence_id'];

// Récupérer le mois actuel
$mois = date('Y-m');

$stmt = $pdo->prepare('
    INSERT INTO objectifs (agence_id, mois, objectif)
    VALUES (:agenceId, :mois, :objectif)
    ON DUPLICATE KEY UPDATE objectif = :objectif
');
$stmt->execute(['agenceId' => $agenceId, 'mois' => $mois, 'objectif' => $objectif]);

header('Location: ../dashboard.php'); // Rediriger l'utilisateur vers la page du tableau de bord
exit;
?>