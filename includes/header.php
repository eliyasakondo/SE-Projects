<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <?php if(isset($tutor_register)): ?>
    <link rel="stylesheet" href="<?php echo $tutor_register; ?>">
    <?php endif; ?>
      <!-- Other head elements Font Awsome Icon -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
