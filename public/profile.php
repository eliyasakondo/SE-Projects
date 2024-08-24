<?php
include_once '../includes/header.php';
include_once '../includes/functions.php';
include_once '../includes/db.php';

session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update profile information
    $personal_info = $_POST['personal_info'];
    // Process other fields...
    
    $sql = "UPDATE tutors SET personal_info = ? WHERE email = ?";
    query($sql, [$personal_info, $email]);
    
    echo "Profile updated!";
}

$sql = "SELECT * FROM tutors WHERE email = ?";
$tutor = query($sql, [$email])[0];
?>
<main>
    <h2>Profile</h2>
    <form method="POST" action="">
        <label for="personal_info">Personal Information:</label>
        <textarea id="personal_info" name="personal_info"><?php echo htmlspecialchars($tutor['personal_info']); ?></textarea>
        
        <!-- Other fields... -->
        
        <button type="submit">Update</button>
    </form>
</main>
<?php
include_once '../includes/footer.php';
?>
