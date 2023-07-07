 <?php
$stmt = $pdo->prepare('
SELECT agences.nom AS agence_nom, SUM(CA.CA_prevision) AS CA_prevision, objectifs.objectif AS objectif
FROM users
LEFT JOIN CA ON users.id = CA.commercial_id OR users.id = CA.second_commercial_id
JOIN agences ON users.agence_id = agences.id
LEFT JOIN objectifs ON agences.id = objectifs.agence_id AND MONTH(objectifs.mois) = MONTH(CURRENT_DATE())
JOIN clients ON CA.client_id = clients.id
WHERE CA.CA_realise IS NULL AND clients.statut = "actif"
GROUP BY agences.nom
ORDER BY CA_prevision DESC
');

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Boucle pour afficher les données de chaque agence
$position = 1;
foreach ($result as $row) {
$agence_nom = $row['agence_nom'];
$CA_prevision = $row['CA_prevision'];
$objectif = $row['objectif']; // Ajout de l'objectif
$progress = ($objectif != 0) ? ($CA_prevision / $objectif) * 100 : 0; // Calcul du pourcentage par rapport à l'objectif, vérifiez si l'objectif n'est pas nul
$progressColor = '';

// Déterminer la couleur de la barre de progression en fonction des seuils
if ($CA_prevision < 30000) {
    $progressColor = 'bg-danger';
} elseif ($CA_prevision < 75000) {
    $progressColor = 'bg-warning';
} else {
    $progressColor = 'bg-success';
}
?>

 <tr>
     <td><?php echo $position; ?></td>
     <td><?php echo $agence_nom; ?></td>
     <td><?php echo number_format($CA_prevision, 0, '.', ' '); ?>€</td>
     <td><?php echo number_format($objectif, 0, '.', ' '); ?>€</td> <!-- Affichage de l'objectif -->
     <td>
         <div class="d-flex justify-content-between align-items-center gap-3">
             <div class="progress w-100" style="height: 10px">
                 <div class="progress-bar <?php echo $progressColor; ?>" role="progressbar"
                     style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0"
                     aria-valuemax="100"></div>
             </div>
             <small class="fw-semibold"><?php echo number_format($progress, 0, '.', ' '); ?>%</small>
         </div>
     </td>
 </tr>

 <?php
$position++;
}

                            ?>