<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['coordinator_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tutor_id = $_POST['tutor_id'];
    $status = 'Forwarded to Dean';

    $conn = get_db_connection();
    $sql = "UPDATE tutors SET status = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $tutor_id]);

    header('Location: dashboard.php');
    exit();
}

$tutor_id = $_GET['tutor_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forward to Dean</title>
</head>
<body>
    <h2>Forward to Dean</h2>
    <form action="forward_to_dean.php" method="post">
        <input type="hidden" name="tutor_id" value="<?php echo htmlspecialchars($tutor_id); ?>">
        <button type="submit">Forward</button>
    </form>
    <a href="dashboard.php">Cancel</a>
</body>
</html>