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
            echo "<p>" . htmlspecialchars($commercial['nom']) . "</p>";
            echo "</div>";
        } else {
            echo $client['commercial_id'];
        }
        ?>
    </td>
</tr>