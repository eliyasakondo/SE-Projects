<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vc') {
    header('Location: ../login.php');
    exit();
}

$conn = get_db_connection();
$sql = "SELECT tutors.tutor_id, tutors.name_en, users.email, tutors.status 
        FROM tutors 
        JOIN users ON tutors.user_id = users.user_id 
        WHERE tutors.status IN ('forwarded_to_vc', 'selected')";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tutors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VC Dashboard</title>
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
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>VC Dashboard</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="view_tutors.php">View Tutors</a></li>
                <li><a href="manage_tutors.php">Manage Tutors</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Review Tutors</h2>
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
                        <?php if ($tutor['status'] == 'forwarded_to_vc'): ?>
                        <form action="process_tutor.php" method="post">
                            <input type="hidden" name="tutor_id" value="<?php echo $tutor['tutor_id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <input type="text" name="comments" placeholder="Enter comments">
                            <button type="submit">Approve</button>
                        </form>
                        <form action="process_tutor.php" method="post">
                            <input type="hidden" name="tutor_id" value="<?php echo $tutor['tutor_id']; ?>">
                            <input type="hidden" name="action" value="send_back">
                            <input type="text" name="comments" placeholder="Enter comments">
                            <button type="submit">Send Back to Pro VC</button>
                        </form>
                        <?php endif; ?>
                        <form action="process_tutor.php" method="post">
                            <input type="hidden" name="tutor_id" value="<?php echo $tutor['tutor_id']; ?>">
                            <input type="hidden" name="action" value="reject">
                            <input type="text" name="comments" placeholder="Enter comments">
                            <button type="submit">Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>