<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dean') {
    header('Location: ../login.php');
    exit();
}

$tutor_id = $_GET['tutor_id'];
$conn = get_db_connection();
$sql = "SELECT tutors.*, users.email FROM tutors JOIN users ON tutors.user_id = users.user_id WHERE tutors.tutor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $tutor_id, PDO::PARAM_INT);
$stmt->execute();
$tutor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tutor) {
    echo "Tutor not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tutor</title>
</head>
<body>
    <h2>View Tutor</h2>
    <ul>
        <li><strong>ID:</strong> <?php echo htmlspecialchars($tutor['tutor_id']); ?></li>
        <li><strong>Name (English):</strong> <?php echo htmlspecialchars($tutor['name_en']); ?></li>
        <li><strong>Name (Bengali):</strong> <?php echo htmlspecialchars($tutor['name_bn']); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($tutor['email']); ?></li>
        <li><strong>Mobile Number:</strong> <?php echo htmlspecialchars($tutor['mobile_number']); ?></li>
        <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($tutor['dob']); ?></li>
        <li><strong>Birthplace:</strong> <?php echo htmlspecialchars($tutor['birthplace']); ?></li>
        <li><strong>Nationality:</strong> <?php echo htmlspecialchars($tutor['nationality']); ?></li>
        <li><strong>NID Number:</strong> <?php echo htmlspecialchars($tutor['nid_number']); ?></li>
        <li><strong>Passport Number:</strong> <?php echo htmlspecialchars($tutor['passport_number']); ?></li>
        <li><strong>Passport Expiry Date:</strong> <?php echo htmlspecialchars($tutor['passport_expiry_date']); ?></li>
        <li><strong>Gender:</strong> <?php echo htmlspecialchars($tutor['gender']); ?></li>
        <li><strong>Marital Status:</strong> <?php echo htmlspecialchars($tutor['marital_status']); ?></li>
        <li><strong>Mailing Address:</strong> <?php echo htmlspecialchars($tutor['mailing_address']); ?></li>
        <li><strong>Permanent Village:</strong> <?php echo htmlspecialchars($tutor['permanent_village']); ?></li>
        <li><strong>Permanent Post Office:</strong> <?php echo htmlspecialchars($tutor['permanent_post_office']); ?></li>
        <li><strong>Permanent Police Station:</strong> <?php echo htmlspecialchars($tutor['permanent_police_station']); ?></li>
        <li><strong>Permanent Upazilla:</strong> <?php echo htmlspecialchars($tutor['permanent_upazilla']); ?></li>
        <li><strong>Permanent District:</strong> <?php echo htmlspecialchars($tutor['permanent_district']); ?></li>
        <li><strong>Present Village:</strong> <?php echo htmlspecialchars($tutor['present_village']); ?></li>
        <li><strong>Present Post Office:</strong> <?php echo htmlspecialchars($tutor['present_post_office']); ?></li>
        <li><strong>Present Police Station:</strong> <?php echo htmlspecialchars($tutor['present_police_station']); ?></li>
        <li><strong>Present Upazilla:</strong> <?php echo htmlspecialchars($tutor['present_upazilla']); ?></li>
        <li><strong>Present District:</strong> <?php echo htmlspecialchars($tutor['present_district']); ?></li>
        <li><strong>Photo:</strong> <img src="<?php echo htmlspecialchars($tutor['photo']); ?>" alt="Tutor Photo" width="100"></li>
        <li><strong>Signature:</strong> <img src="<?php echo htmlspecialchars($tutor['signature']); ?>" alt="Tutor Signature" width="100"></li>
        <li><strong>CV:</strong> <a href="<?php echo htmlspecialchars($tutor['cv']); ?>" target="_blank">Download CV</a></li>
        <li><strong>Status:</strong> <?php echo htmlspecialchars($tutor['status']); ?></li>
        <li><strong>Comments:</strong> <?php echo htmlspecialchars($tutor['comments'] ?? ''); ?></li>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>