<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $conn = get_db_connection();
    $sql = "SELECT * FROM coordinators WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $coordinator = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coordinator && password_verify($password, $coordinator['password'])) {
        $_SESSION['coordinator_id'] = $coordinator['id'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Login</title>
</head>
<body>
    <h2>Coordinator Login</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>