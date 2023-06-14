<?php

session_start();


$host = '176.31.132.185';
$db   = 'ohetkg_dashboar_db';
$user = 'ohetkg_dashboar_db';
$pass = '3-t2_UfA1s*Q0Iu!';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // L'utilisateur est connecté
    
    $_SESSION['username'] = $username;
    header('Location: dashboard.php');
} else {
    // Échec de la connexion
    $_SESSION['error_message'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
    header('Location: ../index.php');
}
?>