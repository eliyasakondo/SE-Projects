<?php
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
    echo "Session started<br>";
}

include_once '../includes/functions.php'; // Only include functions.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Form submitted<br>";
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Debugging: Check if email and password are received
    echo "Email: $email<br>";
    echo "Password: $password<br>";

    // Authenticate tutor
    $tutor = authenticateTutor($email, $password);
    if ($tutor) {
        echo "Authentication successful<br>";
        $_SESSION['tutor_id'] = $tutor['tutor_id']; // Use the correct key for tutor ID
        echo "Session set<br>";
        echo "Session ID: " . session_id() . "<br>"; // Debugging line
        echo "Tutor ID: " . $_SESSION['tutor_id'] . "<br>"; // Debugging line
        echo "Redirecting to profile<br>";
        header('Location: tutor/profile.php');
        exit();
    } else {
        $error = "Invalid email or password.";
        echo $error . "<br>";
    }
} else {
    echo "Form not submitted<br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>