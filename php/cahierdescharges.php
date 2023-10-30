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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <form action="traitement_projet.php" method="post">
            <h2 class="mb-4">Créer ou Sélectionner un Client</h2>

            <div class="form-check mb-3">
                <input type="radio" id="nouveau_client" name="type_client" value="nouveau" checked
                    class="form-check-input">
                <label for="nouveau_client" class="form-check-label">Nouveau Client</label>
            </div>

            <div class="form-check mb-3">
                <input type="radio" id="client_existant" name="type_client" value="existant" class="form-check-input">
                <label for="client_existant" class="form-check-label">Client Existant</label>
            </div>

            <!-- Champs pour un nouveau client -->
            <div id="nouveau_client_champs">
                <input type="text" name="nom" placeholder="Nom" class="form-control mb-3">
                <input type="text" name="prenom" placeholder="Prénom" class="form-control mb-3">
                <input type="text" name="societe" placeholder="Société" class="form-control mb-3">
                <input type="text" name="siret" placeholder="SIRET" class="form-control mb-3">
                <input type="email" name="email" placeholder="Email" class="form-control mb-3">
                <input type="text" name="phone_number" placeholder="Numéro de téléphone" class="form-control mb-3">
            </div>

            <!-- Champs pour sélectionner un client existant -->
            <div id="client_existant_champs" style="display: none;">
                <select name="client_id" class="form-select mb-3">
                    <?php foreach ($clients as $client): ?>
                    <option value="<?php echo $client['id']; ?>">
                        <?php echo htmlspecialchars($client['nom']) . " " . htmlspecialchars($client['prenom']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h2 class="mb-4">Créer un Cahier des Charges</h2>

            <input type="text" name="nom_projet" placeholder="Nom du Projet" required class="form-control mb-3">
            <textarea name="longues_traines" placeholder="Longues Traînes" class="form-control mb-3"></textarea>
            <input type="text" name="nom_domaine" placeholder="Nom de Domaine" required class="form-control mb-3">
            <input type="text" name="code_transfert_domaine" placeholder="Code de Transfert de Domaine"
                class="form-control mb-3">
            <textarea name="rubriques" placeholder="Rubriques" class="form-control mb-3"></textarea>
            <textarea name="infos_complementaires" placeholder="Informations Complémentaires"
                class="form-control mb-3"></textarea>
            <div class="form-check mb-3">
                <input type="checkbox" name="charte_graphique_existante" value="1" class="form-check-input">
                <label class="form-check-label">Charte Graphique Existante</label>
            </div>
            <textarea name="idee_site" placeholder="Idée du Site" class="form-control mb-3"></textarea>
            <textarea name="concurrents" placeholder="Concurrents" class="form-control mb-3"></textarea>
            <textarea name="partenaires" placeholder="Partenaires" class="form-control mb-3"></textarea>
            <textarea name="villes" placeholder="Villes" class="form-control mb-3"></textarea>

            <button type="submit" class="btn btn-primary">Créer Projet</button>
        </form>
    </div>

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