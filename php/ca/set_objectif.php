<?php 
session_start();
include '../db_connection.php';
include '../notifications/notifications.php';

$objectif = $_POST['objectif'];

$stmt = $pdo->prepare('
    INSERT INTO objectifs (agence_id, mois, objectif)
    VALUES (:agenceId, CURDATE(), :objectif)
    ON DUPLICATE KEY UPDATE objectif = :objectif
');
$stmt->execute(['agenceId' => $agenceId, 'objectif' => $objectif]);

?>