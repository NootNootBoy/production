<?php

session_start();
require_once '../notifications/notifications.php';

// Assurez-vous que les données sont envoyées par POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $id_projet = $_POST['id_projet'];
    $id_user_developpeur = $_POST['id_user_developpeur'];
    $id_user_assistant = $_POST['id_user_assistant'];

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
    
        // Récupérer le nom du projet
    $stmt = $pdo->prepare("SELECT nom_projet FROM Projets WHERE id_projet = ?");
    $stmt->execute([$id_projet]);
    $projet = $stmt->fetch();
    $nom_projet = $projet['nom_projet'];

    // Préparer la requête pour mettre à jour le projet
    $stmt = $pdo->prepare("UPDATE Projets SET id_user_developpeur = ?, id_user_assistant = ?, status = 'en cours' WHERE id_projet = ?");
    $stmt->execute([$id_user_developpeur, $id_user_assistant, $id_projet]);


    $nom_mission = $nom_projet . " mission";

// Créer une nouvelle mission
$stmt = $pdo->prepare("INSERT INTO missions (id_projet, id_user, nom_mission, etat)
VALUES (:id_projet, :id_user, :nom_mission, 'en attente')");
$stmt->bindParam(':id_projet', $id_projet);
$stmt->bindParam(':id_user', $id_user_developpeur);
$stmt->bindParam(':nom_mission', $nom_mission);
$stmt->execute();

    // Envoyer une notification
    $title = "Mission ajoutée";
    $description = "Une nouvelle mission a été ajoutée pour le projet.";
    $icon = "bx-project"; // Remplacez par l'URL de votre icône
    $user_id = $_POST['id_user_developpeur']; // ID de l'utilisateur développeur
    $rang = "administrateur"; // Pas de rang spécifique pour cette notification
    send_notification($pdo, $title, $description, $icon, $user_id, $rang);

    // Préparer le message de succès pour SweetAlert
    $_SESSION['success_message'] = 'Le projet a été complété et la mission ajoutée avec succès.';
    header('Location: listing_project.php?userAdded=true');
    }
    
?>