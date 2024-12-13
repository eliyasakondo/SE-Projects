<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Hashed Password</title>
</head>
<body>
    <h2>Generate Hashed Password</h2>
    <form action="generate_password.php" method="post">
        <label for="password">Password:</label>
        <input type="text" id="password" name="password" required><br>
        <button type="submit">Generate</button>
    </form>
    <?php if (isset($hashed_password)): ?>
        <h3>Hashed Password:</h3>
        <p><?php echo htmlspecialchars($hashed_password); ?></p>
    <?php endif; ?>
</body>
</html>