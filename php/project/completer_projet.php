<?php



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

// Assurez-vous que les données sont envoyées par POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $id_projet = $_POST['id_projet'];
    $id_user_developpeur = $_POST['id_user_developpeur'];
    $id_user_assistant = $_POST['id_user_assistant'];

    // Connexion à la base de données
    // ... (Votre code de connexion ici)

    // Préparer la requête pour mettre à jour le projet
    $stmt = $pdo->prepare("UPDATE Projets SET id_user_developpeur = ?, id_user_assistant = ?, status = 'en cours' WHERE id_projet = ?");
    $stmt->execute([$id_user_developpeur, $id_user_assistant, $id_projet]);

    // Rediriger vers la page des projets en attente
    header('Location: listing_project.php');
    exit;
}
?>