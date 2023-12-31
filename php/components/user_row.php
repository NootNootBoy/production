<tr>
    <td><?php echo htmlspecialchars($user['id']) ?></td>
    <td><?php echo htmlspecialchars($user['nom']) ?></td>
    <td><?php echo htmlspecialchars($user['prenom']) ?></td>
    <td><?php echo htmlspecialchars($user['email']) ?></td>
    <td>
        <span class="badge 
        <?php 
            if ($user['rang'] == 'developpeur') {
                echo 'bg-label-primary';
            } elseif ($user['rang'] == 'commercial') {
                echo 'bg-label-info';
            } elseif ($user['rang'] == 'administrateur') {
                echo 'bg-label-danger';
            } elseif ($user['rang'] == 'assistant') {
                echo 'bg-label-success';
            }
        ?> me-1">
            <?php echo htmlspecialchars($user['rang']) ?>
        </span>
    </td>
    <td><?php echo htmlspecialchars($user['phone_number']) ?></td>
    <td><?php echo htmlspecialchars($user['agence_nom']) ?></td>
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
</tr>