<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Default Title'; ?></title>
    <link rel="stylesheet" href="/path/to/your/styles.css">
</head>
<body>
    <header>
        <h1>Application Header</h1>
        <nav>
            <ul>
                <li><a href="/path/to/dashboard.php">Dashboard</a></li>
                <li><a href="/path/to/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Your Application</p>
    </footer>
</body>
</html>