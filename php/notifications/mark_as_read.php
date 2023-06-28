<?php
require_once 'notifications.php';
if(isset($_POST['notification_id'])){
  markNotificationAsRead($_POST['notification_id'], $userId); // Remplacez $userId par l'ID de l'utilisateur actuellement connecté
  echo 'Notification marked as read';
}
?>