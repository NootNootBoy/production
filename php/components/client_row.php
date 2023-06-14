<tr>
    <td><?php echo htmlspecialchars($client['id']) ?></td>
    <td><?php echo htmlspecialchars($client['nom']) ?></td>
    <td><?php echo htmlspecialchars($client['societe']) ?></td>
    <td><?php echo htmlspecialchars($client['email']) ?></td>
    <td>
        <div class="position-relative">
            <?php
            $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
            $stmt2->execute([$client['commercial_id']]);
            $commercial = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($commercial && isset($commercial['avatar'])) {
                echo "<img src='{$commercial['avatar']}' alt='Avatar' class='img-fluid rounded-circle' style='width: 30px; height: 30px;'>";
                echo "<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary' style='z-index: 1; font-size: 12px; opacity: 0;'>" . htmlspecialchars($commercial['nom']) . "</span>";
            } else {
                echo $client['commercial_id'];
            }
            ?>
        </div>
    </td>
</tr>