<?php
require __DIR__ . '/config.php';

// Handle delete request
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = db()->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php?msg=deleted");
    exit;
}

$conn = db();
$result = $conn->query("SELECT * FROM contacts ORDER BY name ASC");
$contacts = $result->fetch_all(MYSQLI_ASSOC);
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Contact Manager</h1>
            <a href="add.php" class="btn btn-primary">+ Add Contact</a>
        </header>

        <?php if ($msg === 'added'): ?>
            <div class="alert alert-success">Contact added successfully!</div>
        <?php elseif ($msg === 'updated'): ?>
            <div class="alert alert-success">Contact updated successfully!</div>
        <?php elseif ($msg === 'deleted'): ?>
            <div class="alert alert-success">Contact deleted successfully!</div>
        <?php endif; ?>

        <?php if (count($contacts) === 0): ?>
            <p class="empty">No contacts found. Click <a href="add.php">Add Contact</a> to create one.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($contacts as $c): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($c['name']) ?></td>
                            <td><?= htmlspecialchars($c['email']) ?></td>
                            <td><?= htmlspecialchars($c['phone']) ?></td>
                            <td><?= htmlspecialchars($c['address']) ?></td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-edit">Edit</a>
                                <a href="index.php?delete=<?= $c['id'] ?>" class="btn btn-delete"
                                   onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>