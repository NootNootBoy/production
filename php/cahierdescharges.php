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

// Récupérer les clients de la base de données
try {
    $stmt = $pdo->prepare("SELECT id, nom, prenom FROM clients");
    $stmt->execute();
    $clients = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="traitement_client.php" method="post">
        <h2>Créer ou Sélectionner un Client</h2>

        <input type="radio" id="nouveau_client" name="type_client" value="nouveau" checked>
        <label for="nouveau_client">Nouveau Client</label><br>

        <input type="radio" id="client_existant" name="type_client" value="existant">
        <label for="client_existant">Client Existant</label><br>

        <!-- Champs pour un nouveau client -->
        <div id="nouveau_client_champs">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="societe" placeholder="Société" required>
            <input type="text" name="siret" placeholder="SIRET" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone_number" placeholder="Numéro de téléphone">
        </div>

        <!-- Champs pour sélectionner un client existant -->
        <div id="client_existant_champs" style="display: none;">
            <select name="client_id">
                <?php foreach ($clients as $client): ?>
                <option value="<?php echo $client['id']; ?>">
                    <?php echo htmlspecialchars($client['nom']) . " " . htmlspecialchars($client['prenom']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="submit" value="Continuer">
    </form>

    <script>
    // Script pour afficher/masquer les champs en fonction du choix de l'utilisateur
    document.getElementById('nouveau_client').addEventListener('change', function() {
        document.getElementById('nouveau_client_champs').style.display = 'block';
        document.getElementById('client_existant_champs').style.display = 'none';
    });

    document.getElementById('client_existant').addEventListener('change', function() {
        document.getElementById('nouveau_client_champs').style.display = 'none';
        document.getElementById('client_existant_champs').style.display = 'block';
    });
    </script>

</body>

</html>