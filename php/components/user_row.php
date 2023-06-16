<tr>
    <td><?php echo htmlspecialchars($user['id']) ?></td>
    <td><?php echo htmlspecialchars($user['nom']) ?></td>
    <td><?php echo htmlspecialchars($user['prenom']) ?></td>
    <td><?php echo htmlspecialchars($user['email']) ?></td>
    <td><?php echo htmlspecialchars($user['rang']) ?></td>
    <td><?php echo htmlspecialchars($user['agence']) ?></td>
    <td><span class="badge bg-label-primary me-1"><?php echo htmlspecialchars($user['statut']) ?></span></td>
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