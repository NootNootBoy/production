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

// Vous devez avoir l'ID du client à modifier.
$client_id = $_POST['client_id'];

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$societe = $_POST['societe'];
$siret = $_POST['siret'];
$email = $_POST['email'];
$phoneNumber = $_POST['phone_number'];
$temps_engagement = $_POST['temps_engagement'];
$date_signature = $_POST['date_signature'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$pays = $_POST['pays'];
$commercial_id = $_POST['commercial_id'];
$code_assurance = $_POST['code_assurance'];

$stmt = $pdo->prepare('UPDATE clients SET nom = ?, prenom = ?, societe = ?, siret = ?, email = ?, phone_number = ?, temps_engagement = ?, date_signature = ?, adresse = ?, ville = ?, code_postal = ?, pays = ?, code_assurance = ?, commercial_id = ? WHERE id = ?');
$stmt->execute([$nom, $prenom, $societe, $siret, $email, $phoneNumber, $temps_engagement, $date_signature, $adresse, $ville, $code_postal, $pays, $code_assurance, $commercial_id, $client_id]);

// Mettre à jour les options ici si nécessaire...

if (isset($_POST['options'])) {
    // Supprimer les associations existantes
    $stmt = $pdo->prepare('DELETE FROM client_options WHERE client_id = ?');
    $stmt->execute([$client_id]);

    // Ajouter les nouvelles associations
    $stmt = $pdo->prepare('INSERT INTO client_options (client_id, option_id) VALUES (?, ?)');
    foreach ($_POST['options'] as $option_id) {
        $stmt->execute([$client_id, $option_id]);
    }
}

if (!preg_match('/^(\+33|0)[1-9](\d{2}){4}$/', $phoneNumber)) {
    $error_message = "Numéro de téléphone invalide.";
    header('Location: Listing_clients.php?error=true&errorMessage=' . urlencode($error_message));
    exit();
}

// Vérification de la validité de l'adresse e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_message = "Adresse e-mail invalide.";
    header('Location: Listing_clients.php?error=true&errorMessage=' . urlencode($error_message));
    exit();
}

if ($stmt->rowCount() > 0) {
    $_SESSION['success_message'] = 'La fiche client a été modifiée avec succès.';
    header('Location: /php/components/details_client.php?id=' . $client_id . '&clientUpdate=true');
} else {
    // La mise à jour a échoué
    $error_message = "La mise à jour a échoué.";
    header('Location: /php/components/details_client.php?id=' . $client_id . '&error=true&errorMessage=' . urlencode($error_message));
}

exit;
?>