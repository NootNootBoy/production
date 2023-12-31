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

try {
    // Récupérer tous les clients
    $stmt = $pdo->prepare('SELECT * FROM clients');
    $stmt->execute();
    $clients = $stmt->fetchAll();

    // Récupérer toutes les options existantes
    $stmt = $pdo->prepare('SELECT option_id FROM CA_options');
    $stmt->execute();
    $existing_options = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($clients as $client) {
            // Récupérer les options pour ce client
            $stmt = $pdo->prepare('
                SELECT option_id
                FROM client_options
                WHERE client_id = ?
            ');
            $stmt->execute([$client['id']]);
            $options = $stmt->fetchAll(PDO::FETCH_COLUMN);

             // Parcourir les options existantes
            foreach ($existing_options as $existing_option_id) {
                // Vérifier si l'option existe toujours parmi les options cochées actuelles
                if (!in_array($existing_option_id, $options)) {
                    // Supprimer la ligne correspondante de la table CA_options
                    $stmt = $pdo->prepare('
                        DELETE FROM CA_options
                        WHERE client_id = ? AND option_id = ?
                    ');
                    $stmt->execute([$client['id'], $existing_option_id]);
                }
            }

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
                    // Vérifier si une ligne avec le même client_id, commercial_id et option_id existe déjà
                    $stmt = $pdo->prepare('
                        SELECT *
                        FROM CA_options
                        WHERE client_id = ? AND commercial_id = ? AND option_id = ?
                    ');
                    $stmt->execute([$client['id'], $commercial_id, $option_id]);
                    $existing_row = $stmt->fetch();
                
                    if ($existing_row) {
                        // Si une telle ligne existe, mettre à jour la colonne CA_options
                        $stmt = $pdo->prepare('
                            UPDATE CA_options
                            SET CA_options = ?
                            WHERE client_id = ? AND commercial_id = ? AND option_id = ?
                        ');
                        $stmt->execute([$option_price, $client['id'], $commercial_id, $option_id]);
                    } else {
                        // Sinon, insérer une nouvelle ligne
                        $stmt = $pdo->prepare('
                            INSERT INTO CA_options (client_id, commercial_id, option_id, CA_options, date_realisation)
                            VALUES (?, ?, ?, ?, ?)
                        ');
                        $stmt->execute([$client['id'], $commercial_id, $option_id, $option_price, $client['created_at']]);
                    }
                }
            }
        }
    // Redirection avec message de succès
    $_SESSION['success_message'] = "Le client a été ajouté avec succès.";
    header('Location: ../dashboard.php?optionsUpdated=true');
    exit();
} catch(PDOException $e) {
    // En cas d'erreur, rediriger avec message d'erreur
    $error_message = "La mise à jour a échoué.";
    header('Location: ../dashboard.php?error=true&errorMessage=' . urlencode($error_message));
    exit();
}

?>