<?php

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

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

    $id_mission = $_GET['id'];
        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="col-xl-6">
        <div class="card mb-4">
            <h5 class="card-header">Checkboxes and Radios</h5>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md">
                        <small class="text-light fw-semibold">Tâches :</small>
                        <div class="form-check mt-3">
                            <?php
                                $stmt = $pdo->prepare("SELECT * FROM missions WHERE id_mission = :id_mission");
                                $stmt->bindParam(':id_mission', $id_mission);
                                $stmt->execute();
                                $mission = $stmt->fetch();

                                if ($mission) {
                                    echo "<h2>" . $mission['nom_mission'] . "</h2>";
                                    $temps_restant = 45 - $mission['jours_passes'];

                                    // Récupérer toutes les tâches de la mission
                                    $stmt = $pdo->prepare("SELECT taches.*, taches_predefinies.nom_tache FROM taches INNER JOIN taches_predefinies ON taches.id_tache_predefinie = taches_predefinies.id_tache_predefinie WHERE id_mission = :id_mission");
                                    $stmt->bindParam(':id_mission', $id_mission);
                                    $stmt->execute();
                                    $taches = $stmt->fetchAll();

                                    // Compter le nombre total de tâches et le nombre de tâches complétées
                                    $nombre_total_taches = count($taches);
                                    $nombre_taches_completees = 0;
                                    foreach ($taches as $tache) {
                                        if ($tache['est_complete'] == 1) {
                                            $nombre_taches_completees++;
                                        }
                                    }

                                    // Calculer le pourcentage de tâches complétées
                                    $pourcentage_taches_completees = ($nombre_taches_completees / $nombre_total_taches) * 100;
                                            
                                    // Afficher les tâches pour la mission
                                    echo "<form action='update_taches.php' method='post'>";
                                    echo "<input type='hidden' name='id_mission' value='" . $mission['id_mission'] . "'>";
                                    foreach ($taches as $tache) {
                                        echo "<div>";
                                        echo "<input type='checkbox' id='tache" . $tache['id_tache'] . "' name='tache" . $tache['id_tache'] . "' " . ($tache['est_complete'] == '1' ? 'checked' : '0') . ">";
                                        echo "<label for='tache" . $tache['id_tache'] . "'>" . $tache['nom_tache'] . "</label>";
                                        echo "</div>";
                                    }
                                    echo "<div style='width: 100%; background-color: #ddd;'>";

                                    echo "<div style='width: " . $pourcentage_taches_completees . "%; background-color: #4CAF50; height: 30px;'></div>";
                                    echo "Temps restant: " . $temps_restant . " jours<br>";
                                    echo "</div>";
                                    echo "<input type='submit' value='Mettre à jour les tâches'>";
                                    echo "</form>";
                                } 
                                else {
                                    echo "Mission non trouvée.";
                                }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>