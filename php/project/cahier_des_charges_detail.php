<?php 

session_start();
require_once '../notifications/notifications.php';
include '../../php/db_connection.php';

$projet_id = $_GET['projet_id'];

$stmt = $pdo->prepare('SELECT * FROM cahier_des_charges WHERE projet_id = ?');
$stmt->execute([$projet_id]);
$cahier_des_charges = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h1>Cahier des charges pour le projet : " . htmlspecialchars($cahier_des_charges['nom_projet']) . "</h1>";


?>