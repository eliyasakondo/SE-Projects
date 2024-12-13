<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coordinator') {
    header('Location: ../login.php');
    exit();
}

$conn = get_db_connection();
$sql = "SELECT tutors.tutor_id, tutors.name_en, users.email, tutors.status 
        FROM tutors 
        JOIN users ON tutors.user_id = users.user_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tutors = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $tutor_id = $_POST['tutor_id'];
    $comments = $_POST['comments'] ?? '';

    if ($action == 'forward') {
        $status = 'forwarded';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    $sql = "UPDATE tutors SET status = ?, comments = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $comments, $tutor_id]);

    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions form {
            display: inline;
        }
    </style>
</head>
<body>
    <h2>Coordinator Dashboard</h2>
    <h3>Manage Tutors</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($tutors as $tutor): ?>
        <tr>
            <td><?php echo htmlspecialchars($tutor['tutor_id']); ?></td>
            <td><?php echo htmlspecialchars($tutor['name_en']); ?></td>
            <td><?php echo htmlspecialchars($tutor['email']); ?></td>
            <td><?php echo htmlspecialchars($tutor['status']); ?></td>
            <td>
                <div class="actions">
                    <a href="view_tutor.php?tutor_id=<?php echo $tutor['tutor_id']; ?>">View</a>
                    <?php if ($tutor['status'] == 'pending'): ?>
                    <form action="dashboard.php" method="post">
                        <input type="hidden" name="tutor_id" value="<?php echo $tutor['tutor_id']; ?>">
                        <input type="hidden" name="action" value="forward">
                        <button type="submit">Forward to Dean</button>
                    </form>
                    <form action="dashboard.php" method="post">
                        <input type="hidden" name="tutor_id" value="<?php echo $tutor['tutor_id']; ?>">
                        <input type="hidden" name="action" value="reject">
                        <input type="text" name="comments" placeholder="Enter comments">
                        <button type="submit">Reject</button>
                    </form>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>