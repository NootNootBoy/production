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
    // Récupérer les options pour ce client
    $stmt = $pdo->prepare('
        SELECT option_id
        FROM client_options
        WHERE client_id = ?
    ');
    $stmt->execute([$client['id']]);
    $options = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($options as $option_id) {
        // Récupérer le prix de l'option
        $stmt = $pdo->prepare('SELECT prix FROM options WHERE id = ?');
        $stmt->execute([$option_id]);
        $option = $stmt->fetch();
        $option_price = $option['prix'];
    
        // Si un second commercial est impliqué, diviser le prix de l'option par deux
        if (!empty($client['second_commercial_id'])) {
            $option_price /= 2;
        }
    
        // Mettre à jour ou insérer une ligne dans la table CA_options pour chaque commercial
        $commercials = [$client['commercial_id']];
        if (!empty($client['second_commercial_id'])) {
            $commercials[] = $client['second_commercial_id'];
        }
        foreach ($commercials as $commercial_id) {
            $stmt = $pdo->prepare('
                INSERT INTO CA_options (client_id, commercial_id, option_id, CA_options, date_realisation)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE CA_options = ?
            ');
            $stmt->execute([$client['id'], $commercial_id, $option_id, $option_price, $client['created_at'], $option_price]);
        }
    }
}
?>