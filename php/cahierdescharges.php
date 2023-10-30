<!DOCTYPE html>
<html lang="en">
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Projet</title>
</head>

<body>
    <form action="traitement_projet.php" method="post">
        <h2>Créer ou Sélectionner un Client</h2>

        <input type="radio" id="nouveau_client" name="type_client" value="nouveau" checked>
        <label for="nouveau_client">Nouveau Client</label><br>

        <input type="radio" id="client_existant" name="type_client" value="existant">
        <label for="client_existant">Client Existant</label><br>

        <!-- Champs pour un nouveau client -->
        <div id="nouveau_client_champs">
            <input type="text" name="nom" placeholder="Nom">
            <input type="text" name="prenom" placeholder="Prénom">
            <input type="text" name="societe" placeholder="Société">
            <input type="text" name="siret" placeholder="SIRET">
            <input type="email" name="email" placeholder="Email">
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

        <h2>Créer un Cahier des Charges</h2>

        <input type="text" name="nom_projet" placeholder="Nom du Projet" required>
        <textarea name="longues_traines" placeholder="Longues Traînes"></textarea>
        <input type="text" name="nom_domaine" placeholder="Nom de Domaine" required>
        <input type="text" name="code_transfert_domaine" placeholder="Code de Transfert de Domaine">
        <textarea name="rubriques" placeholder="Rubriques"></textarea>
        <textarea name="infos_complementaires" placeholder="Informations Complémentaires"></textarea>
        <input type="checkbox" name="charte_graphique_existante" value="1"> Charte Graphique Existante<br>
        <textarea name="idee_site" placeholder="Idée du Site"></textarea>
        <textarea name="concurrents" placeholder="Concurrents"></textarea>
        <textarea name="partenaires" placeholder="Partenaires"></textarea>
        <textarea name="villes" placeholder="Villes"></textarea>

        <input type="submit" value="Créer Projet">
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