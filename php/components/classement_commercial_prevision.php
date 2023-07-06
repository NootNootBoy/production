<?php
                                    // Effectuer votre requête pour obtenir les chiffres d'affaires en prévision des commerciaux
                                    // et les trier par ordre décroissant
                                    $stmt = $pdo->prepare('
                                        SELECT users.username, users.avatar, SUM(CA.CA_prevision) AS CA_prevision
                                        FROM users
                                        LEFT JOIN CA ON users.id = CA.commercial_id OR users.id = CA.second_commercial_id
                                        JOIN clients ON CA.client_id = clients.id
                                        WHERE CA.CA_realise IS NULL AND users.rang = "commercial" AND clients.statut = "actif"
                                        GROUP BY users.username
                                        ORDER BY CA_prevision DESC
                                    ');
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Boucle pour afficher les données de chaque commercial
                                    $position = 1;
                                    foreach ($result as $row) {
                                        $username = $row['username'];
                                        $avatar = $row['avatar'];
                                        $CA_prevision = $row['CA_prevision'];
                                        $progress = ($CA_prevision / 135000) * 100;
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
                                            <td><?php echo number_format($CA_prevision, 0, '.', ' '); ?>€</td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center gap-3">
                                                    <div class="progress w-100" style="height: 10px">
                                                        <div class="progress-bar <?php echo $progressColor; ?>" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="fw-semibold"><?php echo number_format($progress, 0, '.', ' '); ?>%</small>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                        $position++;
                                    }
                                    ?>