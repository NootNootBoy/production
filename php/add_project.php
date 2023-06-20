<?php
session_start();
include 'db_connection.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête SQL
    $stmt = $pdo->prepare("INSERT INTO projets (nom_projet, id_client, id_user_developpeur, id_user_assistant, nom_domaine)
    VALUES (:nom_projet, :id_client, :id_user_developpeur, :id_user_assistant, :nom_domaine)");

    // Lier les paramètres
    $stmt->bindParam(':nom_projet', $_POST['nom_projet']);
    $stmt->bindParam(':id_client', $_POST['id_client']);
    $stmt->bindParam(':id_user_developpeur', $_POST['id_user_developpeur']);
    $stmt->bindParam(':id_user_assistant', $_POST['id_user_assistant']);
    $stmt->bindParam(':nom_domaine', $_POST['nom_domaine']);

    // Exécuter la requête
    $stmt->execute();

    echo "Nouveau projet créé avec succès";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>