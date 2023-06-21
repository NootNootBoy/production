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
try {
   
    // Préparer la requête SQL pour créer un nouveau projet
    $stmt = $pdo->prepare("INSERT INTO Projets (nom_projet, id_client, id_user_developpeur, id_user_assistant, nom_domaine)
    VALUES (:nom_projet, :id_client, :id_user_developpeur, :id_user_assistant, :nom_domaine)");

    // Lier les paramètres
    $stmt->bindParam(':nom_projet', $_POST['nom_projet']);
    $stmt->bindParam(':id_client', $_POST['id_client']);
    $stmt->bindParam(':id_user_developpeur', $_POST['id_user_developpeur']);
    $stmt->bindParam(':id_user_assistant', $_POST['id_user_assistant']);
    $stmt->bindParam(':nom_domaine', $_POST['nom_domaine']);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer l'ID du projet qui vient d'être créé
    $id_projet = $pdo->lastInsertId();

    // Préparer la requête SQL pour créer une nouvelle mission
    $stmt = $pdo->prepare("INSERT INTO missions (id_projet, id_user, nom_mission, etat)
    VALUES (:id_projet, :id_user, :nom_mission, 'en attente')");

    // Lier les paramètres
    $stmt->bindParam(':id_projet', $id_projet);
    $stmt->bindParam(':id_user', $_POST['id_user_developpeur']);
    $stmt->bindParam(':nom_mission', $_POST['nom_projet']);

    // Exécuter la requête
    $stmt->execute();

    echo "Nouveau projet et nouvelle mission créés avec succès";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>