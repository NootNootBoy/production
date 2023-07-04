<?php
session_start();
// if (isset($_SESSION['username'])) {
//     // L'utilisateur est déjà connecté, redirigez-le vers le tableau de bord
//     header('Location: dashboard.php');
//     exit;
// }
    include 'db_connection.php';
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $rang = $_POST['rang'];
    $agence_id = $_POST['agence_id']; // Change this line
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    
    // Si l'utilisateur a fourni un nouveau mot de passe, mettez-le à jour. Sinon, laissez le mot de passe inchangé.
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, password = ?, rang = ?, agence_id = ?, nom = ?, prenom = ? WHERE id = ?');
        $stmt->execute([$username, $email, $password, $rang, $agence_id, $nom, $prenom, $_SESSION['user_id']]); // And this line
    } else {
        $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, rang = ?, agence_id = ?, nom = ?, prenom = ? WHERE id = ?');
        $stmt->execute([$username, $email, $rang, $agence_id, $nom, $prenom, $_SESSION['user_id']]); // And this line
    }
    
    // Les informations de l'utilisateur ont été mises à jour avec succès
    $_SESSION['success_message'] = 'Les informations de votre profil ont été mises à jour avec succès.';
    header('Location: settings.php'); // Redirigez vers la page de profil
    exit;
    
?>