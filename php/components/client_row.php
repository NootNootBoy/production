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
            // Assuming the engagement period is 12 months
            $engagementPeriodInMonths = 12;
        
            // Calculate the end date of the engagement
            $dateFinEngagement = clone $dateSignature;
            $dateFinEngagement->add(new DateInterval('P' . $engagementPeriodInMonths . 'M'));
        
            // Calculate the difference between the current date and the end date of engagement
            $dateActuelle = new DateTime();
            $interval = $dateActuelle->diff($dateFinEngagement);
            $monthsRemaining = $interval->format('%m');
            $daysRemaining = $interval->format('%d');
            
            // Display the months and days remaining
            echo "<td>" . htmlspecialchars($monthsRemaining . " mois " . $daysRemaining . " jours restant") . "</td>";
        ?>
    <td>
        <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
            </div>
        </div>
    </td>
    </td>
</tr>