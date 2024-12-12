<?php
$pageTitle = 'Home';
include_once '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    
</head>
<body>
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Welcome to the Tutor Registration System</h1>
                <p>Register, login, and manage tutor applications with ease.</p>
                <a href="register.php" class="btn">Get Started</a>
            </div>
        </section>

        <!-- Features Section with Cards -->
        <section class="features">
            <div class="container">
                <h2>Features</h2>
                <div class="card-container">
                    <div class="card">
                        <h3>Easy Registration</h3>
                        <p>Sign up quickly and start managing your tutor profile.</p>
                    </div>
                    <div class="card">
                        <h3>Secure Login</h3>
                        <p>Access your account securely with our robust authentication system.</p>
                    </div>
                    <div class="card">
                        <h3>Profile Management</h3>
                        <p>Update your profile and manage your applications effortlessly.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="about">
            <div class="container">
                <h2>About Us</h2>
                <p>We provide a comprehensive platform for tutors to register, login, and manage their applications. Our system is designed to be user-friendly and secure, ensuring a seamless experience for all users.</p>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact">
            <div class="container">
                <h2>Contact Us</h2>
                <p>If you have any questions or need assistance, feel free to reach out to us.</p>
                <form action="contact.php" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                    
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>