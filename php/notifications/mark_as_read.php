<?php
include '../../php/db_connection.php';
require_once 'notifications.php';
session_start();
$userId = $_SESSION['user_id']; // Remplacez 'user_id' par la clé appropriée si nécessaire

if(isset($_POST['notification_id'])){
  markNotificationAsRead($_POST['notification_id'], $userId); // Remplacez $userId par l'ID de l'utilisateur actuellement connecté
  echo 'Notification marked as read';
}
?>