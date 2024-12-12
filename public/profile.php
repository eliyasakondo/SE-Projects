<?php
session_start();
if (!isset($_SESSION['tutor_id'])) {
    echo "No session found. Redirecting to login.<br>";
   
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h2>Welcome to the Profile Page</h2>
    <p>Your session ID is: <?php echo $_SESSION['tutor_id']; ?></p>
</body>
</html>