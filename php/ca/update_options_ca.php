<?php
// Connexion à la base de données
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

// Récupérer tous les clients
$stmt = $pdo->prepare('SELECT * FROM clients');
$stmt->execute();
$clients = $stmt->fetchAll();

foreach ($clients as $client) {
    // Calculer le C.A des options pour ce client
    $stmt = $pdo->prepare('
        SELECT SUM(options.prix) AS CA_options
        FROM client_options
        JOIN options ON client_options.option_id = options.id
        WHERE client_options.client_id = ?
    ');
    $stmt->execute([$client['id']]);
    $result = $stmt->fetch();
    $CA_options = $result['CA_options'];

    // Si un second commercial est impliqué, diviser le C.A des options par deux
    if (!empty($client['second_commercial_id'])) {
        $CA_options /= 2;
    }

    // Mettre à jour ou insérer une ligne dans la table C.A pour chaque commercial
    $commercials = [$client['commercial_id']];
    if (!empty($client['second_commercial_id'])) {
        $commercials[] = $client['second_commercial_id'];
    }
    foreach ($commercials as $commercial_id) {
        $stmt = $pdo->prepare('
            INSERT INTO CA_options (client_id, commercial_id, offre_id, CA_options, date_realisation)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE CA_options = ?
        ');
        $stmt->execute([$client['id'], $commercial_id, $client['offre_id'], $CA_options, $client['created_at'], $CA_options]);
    }    
}
?>