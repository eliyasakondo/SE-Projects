<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <?php if(isset($tutor_register)): ?>
    <link rel="stylesheet" href="<?php echo $tutor_register; ?>">
    <?php endif; ?>
    <script src="../assets/js/script.js" defer></script>
</head>
<body>
<header>
    <h1>Tutor Registration System</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    </nav>
</header>
