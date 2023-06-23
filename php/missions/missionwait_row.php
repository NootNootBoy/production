<tr>
    <td><?php echo htmlspecialchars($mission['id_mission']) ?></td>
    <td><?php echo htmlspecialchars($mission['nom_mission']) ?></td>
    <td><?php echo htmlspecialchars($mission['etat']) ?></td>
    <td>
        <form action='update_mission.php' method='post'>
            <input type='hidden' name='id_mission' value='<?php echo $mission['id_mission'] ?>'>
            <button type='submit' name='action' value='Accepter' class='btn btn-primary'>Accepter</button>
            <button type='submit' name='action' value='Refuser' class='btn btn-danger'>Refuser</button>
        </form>
    </td>
</tr>