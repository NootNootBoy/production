<?php
session_start();
if (isset($_SESSION['username'])) {
    // L'utilisateur est déjà connecté, redirigez-le vers le tableau de bord
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = '176.31.132.185';
    $db = 'ohetkg_dashboar_db';
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
    $email = $_POST['email']; // Assurez-vous que vous avez un champ 'email' dans votre formulaire
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérifiez si le nom d'utilisateur existe déjà
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user) {
        // Le nom d'utilisateur existe déjà
        $_SESSION['error_message'] = 'Le nom d\'utilisateur est déjà pris.';
        header('Location: auth-register-basic.php'); // Redirigez vers inscription.php
        exit;
    }

    // Vérifiez si l'email existe déjà
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user) {
        // L'email existe déjà
        $_SESSION['error_message'] = 'L\'email est déjà utilisé.';
        header('Location: auth-register-basic.php'); // Redirigez vers inscription.php
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $password]);

    // L'inscription a réussi
    $_SESSION['success_message'] = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
    header('Location: ../index.php');
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="signup-container">
        <h2>Inscription</h2>
        <form action="inscription.php" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="S'inscrire">
        </form>
    </div>
</body>
</html>
