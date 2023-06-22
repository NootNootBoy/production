<tr>
    <td><?php echo htmlspecialchars($projet['id_projet']) ?></td>
    <td><?php echo htmlspecialchars($projet['nom_projet']) ?></td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
        $stmt2->execute([$projet['id_client']]);
        $cliennt = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($cliennt && isset($cliennt['avatar'])) {
        ?>
        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                class="avatar avatar-xs pull-up" title="<?php echo htmlspecialchars($cliennt['nom']) ?>">
                <img src="<?php echo htmlspecialchars($cliennt['avatar']) ?>" alt="Avatar" class="rounded-circle" />
            </li>
        </ul>
        <?php
        } else {
            echo $cliennt['nom'];
        }
        ?>
    </td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
        $stmt2->execute([$projet['id_user_developpeur']]);
        $dev = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($dev && isset($dev['avatar'])) {
        ?>
        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                class="avatar avatar-xs pull-up" title="<?php echo htmlspecialchars($dev['nom']) ?>">
                <img src="<?php echo htmlspecialchars($dev['avatar']) ?>" alt="Avatar" class="rounded-circle" />
            </li>
        </ul>
        <?php
        } else {
            echo $dev['nom'];
        }
        ?>
    </td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
        $stmt2->execute([$projet['id_user_assistant']]);
        $assistant = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($assistant && isset($assistant['avatar'])) {
        ?>
        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                class="avatar avatar-xs pull-up" title="<?php echo htmlspecialchars($assistant['nom']) ?>">
                <img src="<?php echo htmlspecialchars($assistant['avatar']) ?>" alt="Avatar" class="rounded-circle" />
            </li>
        </ul>
        <?php
        } else {
            echo $assistant['nom'];
        }
        ?>
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