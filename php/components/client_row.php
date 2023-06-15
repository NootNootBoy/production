<tr>
    <td><?php echo htmlspecialchars($client['id']) ?></td>
    <td><?php echo htmlspecialchars($client['nom']) ?></td>
    <td><?php echo htmlspecialchars($client['societe']) ?></td>
    <td><?php echo htmlspecialchars($client['email']) ?></td>
    <td>
        <?php
        $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
        $stmt2->execute([$client['commercial_id']]);
        $commercial = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($commercial && isset($commercial['avatar'])) {
            echo "<div>";
            echo "<img src='{$commercial['avatar']}' alt='Avatar' class='img-fluid rounded-circle' style='width: 30px; height: 30px;' title='" . htmlspecialchars($commercial['nom']) . "'>";
            echo "</div>";
        } else {
            echo $client['commercial_id'];
        }
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