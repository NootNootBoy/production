<tr>
    <td><?php echo htmlspecialchars($missionWait['id_mission']) ?></td>
    <td><?php echo htmlspecialchars($missionWait['nom_mission']) ?></td>
    <td><?php echo htmlspecialchars($missionWait['nom']); ?></td>
    <td>
        <?php 
        if ($missionWait['etat'] === 'en cours') {
            echo "<span class='text-warning'>" . htmlspecialchars($missionWait['etat']) . "</span>";
        } elseif ($missionWait['etat'] === 'en attente') {
            echo "<span class='text-danger'>" . htmlspecialchars($missionWait['etat']) . "</span>";
        } elseif ($missionWait['etat'] === 'terminée') {
            echo "<span class='text-success'>" . htmlspecialchars($missionWait['etat']) . "</span>";
        } else {
            echo htmlspecialchars($missionWait['etat']);
        }
        ?>
    </td>

    <td>
        <form action='update_mission.php' method='post'>
            <input type='hidden' name='id_mission' value='<?php echo $missionWait['id_mission'] ?>'>
            <button type='submit' name='action' value='Accepter' class='btn btn-primary'>Démarrer </button>
            <button type='submit' name='action' value='Refuser' class='btn btn-danger'>Refuser</button>
        </form>
    </td>
</tr>