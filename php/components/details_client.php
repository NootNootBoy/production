<?php
    // Connexion à la base de données.
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

    // Récupération de l'identifiant du client depuis l'URL.
    $client_id = isset($_GET['id']) ? $_GET['id'] : null;

    // Vérification si l'ID est valide.
    if ($client_id) {
        // Récupération des informations du client de la base de données.
        $query = "SELECT * FROM clients WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$client_id]);
        $client = $stmt->fetch();

        // Affichage des informations du client.
        if ($client) {
            echo "<h1>Fiche client: " . $client['nom'] . " " . $client['prenom'] . "</h1>";
            echo "<p>ID: " . $client['id'] . "</p>";
            // ... autres informations ...
        } else {
            echo "<p>Client non trouvé.</p>";
        }
    } else {
        echo "<p>ID de client invalide.</p>";
    }
?>