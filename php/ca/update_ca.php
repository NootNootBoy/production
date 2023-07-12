<?php
session_start();
include '../db_connection.php';
include '../notifications/notifications.php';
try{
// Récupérer tous les clients
$stmt = $pdo->query('SELECT * FROM clients');
$clients = $stmt->fetchAll();

foreach ($clients as $client) {
    // Récupérer le prix mensuel de l'offre du client
    $stmt = $pdo->prepare('SELECT prix_mensuel FROM offres WHERE id = ?');
    $stmt->execute([$client['offre_id']]);
    $offre = $stmt->fetch();

    // Calculer le C.A prévu
    $CA_prevision = $offre['prix_mensuel'] * $client['temps_engagement'];

    // Si un second commercial est impliqué, diviser le C.A par deux
    if (!empty($client['second_commercial_id'])) {
        $CA_prevision /= 2;
    }

    // Si le code d'assurance est fourni, stocker le C.A comme C.A réalisé
    $CA_realise = !empty($client['code_assurance']) ? $CA_prevision : null;

    // Mettre à jour le C.A dans la table CA
    $stmt = $pdo->prepare('UPDATE CA SET CA_prevision = ?, CA_realise = ? WHERE client_id = ?');
    $stmt->execute([$CA_prevision, $CA_realise, $client['id']]);
}
// Redirection avec message de succès
$_SESSION['success_message'] = "Le client a été ajouté avec succès.";
header('Location: ../dashboard.php?caUpdated=true');
exit();
} catch(PDOException $e) {
// En cas d'erreur, rediriger avec message d'erreur
$error_message = "La mise à jour a échoué.";
header('Location: ../dashboard.php?error=true&errorMessage=' . urlencode($error_message));
exit();
}
?>