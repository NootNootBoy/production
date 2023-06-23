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
                    href="/php/components/details_projet.php?id=<?php echo $projet['id_projet']; ?>"><i
                        class="bx bx-edit-alt me-1"></i> Voir la fiche</a>
                <a class="dropdown-item"
                    href="/php/components/details_projet.php?id=<?php echo $projet['id_projet']; ?>"><i
                        class="bx bx-trash me-1"></i> Archiver</a>
            </div>
        </div>
    </td>
</tr>