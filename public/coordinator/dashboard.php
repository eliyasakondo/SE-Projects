<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coordinator') {
    header('Location: ../login.php');
    exit();
}

$conn = get_db_connection();
$sql = "SELECT * FROM tutors";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tutors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>
</head>
<body>
    <h2>Coordinator Dashboard</h2>
    <a href="../logout.php">Logout</a>
    <h3>List of Tutor Registrations</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tutors as $tutor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tutor['tutor_id']); ?></td>
                    <td><?php echo htmlspecialchars($tutor['name_en']); ?></td>
                    <td><?php echo htmlspecialchars($tutor['email']); ?></td>
                    <td><?php echo htmlspecialchars($tutor['status']); ?></td>
                    <td>
                        <a href="view_tutor.php?tutor_id=<?php echo $tutor['tutor_id']; ?>">View</a>
                        <a href="approve_tutor.php?tutor_id=<?php echo $tutor['tutor_id']; ?>">Approve</a>
                        <a href="reject_tutor.php?tutor_id=<?php echo $tutor['tutor_id']; ?>">Reject</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>