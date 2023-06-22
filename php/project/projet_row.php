<tr>
    <td><?php echo htmlspecialchars($projet['id_projet']) ?></td>
    <td><?php echo htmlspecialchars($projet['nom_projet']) ?></td>
    <td><?php echo htmlspecialchars($projet['id_client']) ?></td>
    <td><?php echo htmlspecialchars($projet['id_user_developpeur']) ?></td>
    <td><?php echo htmlspecialchars($projet['id_user_assistant']) ?></td>
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