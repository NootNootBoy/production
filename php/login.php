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

$username = $_POST['email-username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // L'utilisateur est connecté
    
    $_SESSION['user_id'] = $user['id']; // Change 'id' to 'user_id'
    $_SESSION['username'] = $user['username'];
    $_SESSION['rang'] = $user['rang']; // Stockez le rang dans la session
    $_SESSION['avatar'] = $user['avatar']; // Stockez le rang dans la session
    header('Location: dashboard.php');
} else {
    // Échec de la connexion
    $_SESSION['error_message'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
    header('Location: ../index.php');
}
?>