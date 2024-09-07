<?php
$pageTitle = 'Tutor Login';
include_once '../includes/header.php';
include_once '../includes/functions.php';
include_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT password FROM tutors WHERE email = ?";
    $result = query($sql, [$email]);
    
    if ($result && verify_password($password, $result[0]['password'])) {
        session_start();
        $_SESSION['email'] = $email;
        header('Location: profile.php');
    } else {
        echo "Invalid email or password!";
    }
}
?>
<main>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
</main>
<?php
include_once '../includes/footer.php';
?>
