<?php
include_once '../includes/header.php';
include_once '../includes/functions.php';
include_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = hash_password($_POST['password']);
    
    $sql = "INSERT INTO tutors (email, password) VALUES (?, ?)";
    query($sql, [$email, $password]);
    
    echo "Registration successful!";
}
?>
<main>
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Register</button>
    </form>
</main>
<?php
include_once '../includes/footer.php';
?>
