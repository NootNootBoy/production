<?php
// Effectuer votre requête pour obtenir les chiffres d'affaires en prévision des commerciaux
// et les trier par ordre décroissant
$stmt = $pdo->prepare('
    SELECT users.username, users.avatar, SUM(CA_options.CA_options) AS CA_options
    FROM users
    LEFT JOIN CA_options ON users.id = CA_options.commercial_id OR users.id = CA_options.second_commercial_id
    JOIN clients ON CA_options.client_id = clients.id
    WHERE clients.statut = "actif"
    AND MONTH(CA_options.date_realisation) = MONTH(CURRENT_DATE())
    AND YEAR(CA_options.date_realisation) = YEAR(CURRENT_DATE())
    GROUP BY users.username
    ORDER BY CA_options DESC
');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Boucle pour afficher les données de chaque commercial
$position = 1;
foreach ($result as $row) {
    $username = $row['username'];
    $avatar = $row['avatar'];
    $CA_options = $row['CA_options'];
    $progress = ($CA_options / 2500) * 100;
    $progressColor = '';

    // Déterminer la couleur de la barre de progression en fonction des seuils
    if ($CA_options < 6500) {
        $progressColor = 'bg-danger';
    } elseif ($CA_options < 14500) {
        $progressColor = 'bg-warning';
    } else {
        $progressColor = 'bg-success';
    }

    $icon = '';
    if ($position == 1) {
        $icon = '<i class="bx bxs-medal bx-tada gold"></i>';
    } elseif ($position == 2) {
        $icon = '<i class="bx bxs-medal bx-tada silver"></i>';
    } elseif ($position == 3) {
        $icon = '<i class="bx bxs-medal bx-tada bronze"></i>';
    }

    ?>

<tr>
    <td><?php echo $position . ' ' . $icon; ?></td>
    <td>
        <div class="d-flex align-items-center">
            <?php if (!empty($avatar)) { ?>
            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" width="30px" class="rounded-circle m-2" />
            <?php } else { ?>
            <img src="/assets/img/avatars/1.png" alt="Avatar" width="30px" class="rounded-circle m-2" />
            <?php } ?>
            <span><?php echo $username; ?></span>
        </div>
    </td>
    <td><?php echo number_format($CA_options, 0, '.', ' '); ?>€</td>
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