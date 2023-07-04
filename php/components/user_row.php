<td><?php echo isset($user['id']) ? htmlspecialchars($user['id']) : '' ?></td>
<td><?php echo isset($user['nom']) ? htmlspecialchars($user['nom']) : '' ?></td>
<td><?php echo isset($user['prenom']) ? htmlspecialchars($user['prenom']) : '' ?></td>
<td><?php echo isset($user['email']) ? htmlspecialchars($user['email']) : '' ?></td>
<td>
    <span class="badge 
        <?php 
            if (isset($user['rang']) && $user['rang'] == 'developpeur') {
                echo 'bg-label-primary';
            } elseif (isset($user['rang']) && $user['rang'] == 'commercial') {
                echo 'bg-label-info';
            } elseif (isset($user['rang']) && $user['rang'] == 'administrateur') {
                echo 'bg-label-danger';
            } elseif (isset($user['rang']) && $user['rang'] == 'assistant') {
                echo 'bg-label-success';
            }
        ?> me-1">
        <?php echo isset($user['rang']) ? htmlspecialchars($user['rang']) : '' ?>
    </span>
</td>
<td><?php echo isset($user['phone_number']) ? htmlspecialchars($user['phone_number']) : '' ?></td>
<td><?php echo isset($user['agence']) ? htmlspecialchars($user['agence']) : '' ?></td>
</td>
</tr>