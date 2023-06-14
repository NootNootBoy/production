<tr>
    <td><?php echo htmlspecialchars($row['id']) ?></td>
    <td><?php echo htmlspecialchars($row['nom']) ?></td>
    <td><?php echo htmlspecialchars($row['societe']) ?></td>
    <td><?php echo htmlspecialchars($row['email']) ?></td>
    <td>
        <?php
                        $stmt2 = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
                        $stmt2->execute([$row['commercial_id']]);
                        $commercial = $stmt2->fetch(PDO::FETCH_ASSOC);
                        if ($commercial && isset($commercial['avatar'])) {
                            echo "<img src='{$commercial['avatar']}' alt='Avatar'>";
                        } else {
                            echo $row['commercial_id'];
                        }
                        ?>
    </td>
</tr>