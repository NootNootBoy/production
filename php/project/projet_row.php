<tr>
    <td><?php echo htmlspecialchars($projet['id']) ?></td>
    <td><?php echo htmlspecialchars($projet['nom']) ?></td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT nom FROM clients WHERE id = ?");
        $stmt2->execute([$projet['client_id']]);
        $client = $stmt2->fetch(PDO::FETCH_ASSOC);
        echo htmlspecialchars($client['nom']);
        ?>
    </td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
        $stmt2->execute([$projet['id_user_developpeur ']]);
        $developpeur = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($developpeur && isset($developpeur['avatar'])) {
        ?>
        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                class="avatar avatar-xs pull-up" title="<?php echo htmlspecialchars($developpeur['nom']) ?>">
                <img src="<?php echo htmlspecialchars($developpeur['avatar']) ?>" alt="Avatar" class="rounded-circle" />
            </li>
        </ul>
        <?php
        } else {
        echo $developpeur['nom'];
        }
        ?>
    </td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT nom FROM users WHERE id = ?");
        $stmt2->execute([$projet['id_user_assistant ']]);
        $assistant = $stmt2->fetch(PDO::FETCH_ASSOC);
        echo htmlspecialchars($assistant['nom']);
        ?>
    </td>
    <td>
        <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/php/components/details_projet.php?id=<?php echo $projet['id']; ?>"><i
                        class="bx bx-edit-alt me-1"></i> Voir la mission</a>
                <a class="dropdown-item" href="/php/components/details_projet.php?id=<?php echo $projet['id']; ?>"><i
                        class="bx bx-trash me-1"></i> Voir l'état du site</a>
            </div>
        </div>
    </td>
</tr>