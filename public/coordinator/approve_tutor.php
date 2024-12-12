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
    $comments = htmlspecialchars($_POST['comments']);
    $status = 'Approved';

    $conn = get_db_connection();
    $sql = "UPDATE tutors SET status = ?, comments = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $comments, $tutor_id]);

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
    <title>Approve Tutor</title>
</head>
<body>
    <h2>Approve Tutor</h2>
    <form action="approve_tutor.php" method="post">
        <input type="hidden" name="tutor_id" value="<?php echo htmlspecialchars($tutor_id); ?>">
        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" rows="4" cols="50"></textarea>
        <button type="submit">Approve</button>
    </form>
    <a href="dashboard.php">Cancel</a>
</body>
</html>