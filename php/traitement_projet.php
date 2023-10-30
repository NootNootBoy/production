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
    $type_client = $_POST['type_client'];

    if ($type_client == 'nouveau') {
        // Création d'un nouveau client
        $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, societe, siret, email, phone_number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['societe'],
            $_POST['siret'],
            $_POST['email'],
            $_POST['phone_number']
        ]);
        $client_id = $pdo->lastInsertId();
    } else {
        // Sélection d'un client existant
        $client_id = $_POST['client_id'];
    }

    // Traitement du cahier des charges
    $stmt = $pdo->prepare("INSERT INTO cahier_des_charges (projet_id, longues_traines, nom_domaine, rubrique1, sous_rubrique1, sous_rubrique2, sous_rubrique3, rubrique2, sous_rubrique4, sous_rubrique5, sous_rubrique6, rubrique3, sous_rubrique7, sous_rubrique8, sous_rubrique9, infos_complementaires, charte_graphique_existante, idee_site, concurrents, partenaires, villes, nom_projet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        null, // projet_id sera défini plus tard
        $_POST['longues_traines'],
        $_POST['nom_domaine'],
        $_POST['rubrique1'],
        $_POST['sous_rubrique1'],
        $_POST['sous_rubrique2'],
        $_POST['sous_rubrique3'],
        $_POST['rubrique2'],
        $_POST['sous_rubrique4'],
        $_POST['sous_rubrique5'],
        $_POST['sous_rubrique6'],
        $_POST['rubrique3'],
        $_POST['sous_rubrique7'],
        $_POST['sous_rubrique8'],
        $_POST['sous_rubrique9'],
        $_POST['infos_complementaires'],
        $_POST['charte_graphique_existante'] ?? 0,
        $_POST['idee_site'],
        $_POST['concurrents'],
        $_POST['partenaires'],
        $_POST['villes'],
        $_POST['nom_projet']
    ]);
    $cahier_des_charges_id = $pdo->lastInsertId();

    // Supposons que vous ayez déjà des identifiants pour le développeur et l'assistant
    $id_user_developpeur = 16; // Remplacer par l'ID réel du développeur
    $id_user_assistant = 17; // Remplacer par l'ID réel de l'assistant

    // Création d'un projet et association du cahier des charges et du client
    $stmt = $pdo->prepare("INSERT INTO Projets (nom_projet, id_client, id_user_developpeur, id_user_assistant, nom_domaine, desc_projet, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nom_projet'],
        $client_id,
        null, // Assistant en NULL
        null, // Développeur en NULL
        $_POST['nom_domaine'],
        '', // Vous pouvez ajouter un champ dans le formulaire pour cela
        'en attente' // Statut initial du projet
    ]);
    $projet_id = $pdo->lastInsertId();

    // Associer le cahier des charges au projet
    $stmt = $pdo->prepare("UPDATE cahier_des_charges SET projet_id = ? WHERE id = ?");
    $stmt->execute([$projet_id, $cahier_des_charges_id]);

    // Redirection ou traitement supplémentaire
    header("Location: /php/project/listing_project.php");
    exit;

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>