<tr>
    <td><?php echo htmlspecialchars($client['id']) ?></td>
    <td><?php echo htmlspecialchars($client['societe']) ?></td>
    <td><?php echo htmlspecialchars($client['nom']) ?></td>
    <td><?php echo htmlspecialchars($client['phone_number']) ?></td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
        $stmt2->execute([$client['commercial_id']]);
        $commercial = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($commercial && isset($commercial['avatar'])) {
        ?>
        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                class="avatar avatar-xs pull-up" title="<?php echo htmlspecialchars($commercial['nom']) ?>">
                <img src="<?php echo htmlspecialchars($commercial['avatar']) ?>" alt="Avatar" class="rounded-circle" />
            </li>
        </ul>
        <?php
        } else {
            echo $commercial['nom'];
        }
        ?>
    </td>
    <?php 
            $dateSignature = new DateTime($client['date_signature']);
            $engagementPeriodInMonths = intval($client['temps_engagement']);

            // Calcul de la date de fin d'engagement
            $dateFinEngagement = clone $dateSignature;
            $dateFinEngagement->add(new DateInterval('P' . $engagementPeriodInMonths . 'M'));

            // Calcul de la différence entre la date actuelle et la date de fin d'engagement
            $dateActuelle = new DateTime();
            $interval = $dateActuelle->diff($dateFinEngagement);
            
            // Conversion des années restantes en mois et ajout aux mois restants
            $totalMonthsRemaining = ($interval->format('%y') * 12) + $interval->format('%m');
            $daysRemaining = $interval->format('%d');
            $textClass = 'text-success';
            if ($totalMonthsRemaining < 3) {
                $textClass = 'text-danger';
            } elseif ($totalMonthsRemaining >= 3 && $totalMonthsRemaining <= 6) {
                $textClass = 'text-warning';
            }
            
            // Affichage du temps restant en mois et jours avec la classe de texte appropriée
            echo "<td class=\"$textClass\">" . htmlspecialchars($totalMonthsRemaining . " mois " . $daysRemaining . " jours restants") . "</td>";
        ?>
    <td>
        <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
    <td><a href="details_client.php?id=<?php echo $client['id']; ?>">Voir la fiche client</a></td>
    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
    </div>
    </div>
    </td>
    </td>
</tr>