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
    // Préparer la requête SQL pour récupérer tous les clients
    $stmt = $pdo->prepare("SELECT * FROM clients");
    $stmt->execute();
    $clients = $stmt->fetchAll();

    // Préparer la requête SQL pour récupérer tous les développeurs
    $stmt = $pdo->prepare("SELECT * FROM users WHERE rang = 'developpeur'");
    $stmt->execute();
    $developpeurs = $stmt->fetchAll();

    // Préparer la requête SQL pour récupérer tous les assistants
    $stmt = $pdo->prepare("SELECT * FROM users WHERE rang = 'assistant'");
    $stmt->execute();
    $assistants = $stmt->fetchAll();

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>

<head>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    form {
        margin: 0 auto;
        width: 300px;
        padding: 1em;
        border: 1px solid #CCC;
        border-radius: 1em;
    }

    form div+div {
        margin-top: 1em;
    }

    input,
    select {
        font: 1em sans-serif;
        width: 300px;
        box-sizing: border-box;
        border: 1px solid #999;
    }

    input[type="submit"] {
        width: auto;
        padding: 0.5em;
    }
    </style>
</head>

<body>
    <form action="add_project.php" method="post">
        <div>
            <label for="nom_projet">Nom du projet:</label>
            <input type="text" id="nom_projet" name="nom_projet">
        </div>
        <div>
            <label for="id_client">Client:</label>
            <select id="id_client" name="id_client">
                <?php foreach ($clients as $client): ?>
                <option value="<?= $client['id'] ?>"><?= $client['nom'] ?> - <?= $client['societe'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="id_user_developpeur">Développeur:</label>
            <select id="id_user_developpeur" name="id_user_developpeur">
                <?php foreach ($developpeurs as $developpeur): ?>
                <option value="<?= $developpeur['id'] ?>"><?= $developpeur['username'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="id_user_assistant">Assistant:</label>
            <select id="id_user_assistant" name="id_user_assistant">
                <?php foreach ($assistants as $assistant): ?>
                <option value="<?= $assistant['id'] ?>"><?= $assistant['username'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="nom_domaine">Nom de domaine:</label>
            <input type="text" id="nom_domaine" name="nom_domaine">
        </div>
        <div>
            <input type="submit" value="Créer un projet">
        </div>
    </form>
</body>

</html>