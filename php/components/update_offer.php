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

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $client_id = $_POST['client_id'];
    $offer_id = $_POST['offer_id'];

    // Mettre à jour l'offre du client
    $stmt = $pdo->prepare('UPDATE clients SET offre_id = ? WHERE id = ?');
    $stmt->execute([$offer_id, $client_id]);


    if ($stmt->rowCount() > 0) {
        $_SESSION['success_message'] = 'L"offre du client a été modifiée avec succès.';
        header('Location: /php/components/details_client.php?id=' . $client_id . '&offerUpdate=true');
    } else {
        // La mise à jour a échoué
        $error_message = "La mise à jour a échoué.";
        header('Location: /php/components/details_client.php?id=' . $client_id . '&error2=true&errorMessage=' . urlencode($error_message));
    }
    // // Rediriger l'utilisateur vers la page des détails du client
    // header('Location: details_client.php?id=' . $client_id);
}
?>