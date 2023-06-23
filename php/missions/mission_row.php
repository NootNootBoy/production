<tr>
    <td><?php echo htmlspecialchars($mission['id_mission']) ?></td>
    <td><?php echo htmlspecialchars($mission['nom_mission']) ?></td>
    <td><?php echo htmlspecialchars($mission['progression']) ?>%</td>
    <td><?php echo htmlspecialchars($mission['etat']) ?></td>
    <td><?php $dateAcceptation = new DateTime($mision['date_acceptation']); echo $dateAcceptation->format('d F Y'); ?>
    </td>
    <td>
        <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item"
                    href="/php/missions/task_for_project.php?id=<?php echo $mission['id_mission']; ?>"><i
                        class="bx bx-edit-alt me-1"></i> Voir les tâches</a>
                <a class="dropdown-item"
                    href="/php/components/details_projet.php?id=<?php echo $projet['id_projet']; ?>"><i
                        class="bx bx-trash me-1"></i> Archiver</a>
                <?php 
                if($mission['verify_done']){
                    echo "<a class='dropdown-item text-success' href='mission_completed.php?id_mission=" . $mission['id_mission'] . "'><i
                    class='bx bx-check-square me-1'></i> Marquer comme terminée</a>";
                }?>
            </div>
        </div>
    </td>
</tr>