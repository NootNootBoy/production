<tr>
    <td><?php echo htmlspecialchars($missionWait['id_mission']) ?></td>
    <td><?php echo htmlspecialchars($missionWait['nom_mission']) ?></td>
    <td><?php echo htmlspecialchars($missionWait['nom']); ?></td>
    <td>
        <div class="alert alert-warning" role="alert">
            <?php echo htmlspecialchars($missionWait['etat']) ?>
        </div>
    </td>

    <td>
        <form action='update_mission.php' method='post'>
            <input type='hidden' name='id_mission' value='<?php echo $missionWait['id_mission'] ?>'>
            <button type='submit' name='action' value='Accepter' class='btn btn-primary'>Démarrer </button>
            <button type='submit' name='action' value='Refuser' class='btn btn-danger'>Refuser</button>
        </form>
    </td>
</tr>