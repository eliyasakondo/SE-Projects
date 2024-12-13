<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'tutor') {
    echo "No session found or unauthorized access. Redirecting to login.<br>";
    header('Location: ../login.php');
    exit();
}

$tutor_id = getTutorIdByUserId($_SESSION['user_id']);
$tutor = getTutorById($tutor_id);

function getTutorIdByUserId($user_id) {
    $conn = get_db_connection();
    $sql = "SELECT tutor_id FROM tutors WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTutorById($id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM tutors WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_en = $_POST['name_en'];
    $name_bn = $_POST['name_bn'];
    $father_name_en = $_POST['father_name_en'];
    $mother_name_en = $_POST['mother_name_en'];
    $mobile_number = $_POST['mobile_number'];
    $dob = $_POST['dob'];
    $birthplace = $_POST['birthplace'];
    $nationality = $_POST['nationality'];
    $nid_number = $_POST['nid_number'];
    $passport_number = $_POST['passport_number'];
    $passport_expiry_date = $_POST['passport_expiry_date'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $mailing_address = $_POST['mailing_address'];
    $permanent_village = $_POST['permanent_village'];
    $permanent_post_office = $_POST['permanent_post_office'];
    $permanent_police_station = $_POST['permanent_police_station'];
    $permanent_upazilla = $_POST['permanent_upazilla'];
    $permanent_district = $_POST['permanent_district'];
    $present_village = $_POST['present_village'];
    $present_post_office = $_POST['present_post_office'];
    $present_police_station = $_POST['present_police_station'];
    $present_upazilla = $_POST['present_upazilla'];
    $present_district = $_POST['present_district'];

    // Handle file uploads
    $photo = $_FILES['photo']['name'];
    $signature = $_FILES['signature']['name'];
    $cv = $_FILES['cv']['name'];

    // Move uploaded files to the appropriate directory
    move_uploaded_file($_FILES['photo']['tmp_name'], "../../uploads/$photo");
    move_uploaded_file($_FILES['signature']['tmp_name'], "../../uploads/$signature");
    move_uploaded_file($_FILES['cv']['tmp_name'], "../../uploads/$cv");

    $conn = get_db_connection();
    $sql = "UPDATE tutors SET 
            name_en = ?, name_bn = ?, father_name_en = ?, mother_name_en = ?, 
            mobile_number = ?, dob = ?, birthplace = ?, nationality = ?, 
            nid_number = ?, passport_number = ?, passport_expiry_date = ?, 
            gender = ?, marital_status = ?, mailing_address = ?, 
            permanent_village = ?, permanent_post_office = ?, permanent_police_station = ?, 
            permanent_upazilla = ?, permanent_district = ?, present_village = ?, 
            present_post_office = ?, present_police_station = ?, present_upazilla = ?, 
            present_district = ?, photo = ?, signature = ?, cv = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $name_en, $name_bn, $father_name_en, $mother_name_en, 
        $mobile_number, $dob, $birthplace, $nationality, 
        $nid_number, $passport_number, $passport_expiry_date, 
        $gender, $marital_status, $mailing_address, 
        $permanent_village, $permanent_post_office, $permanent_police_station, 
        $permanent_upazilla, $permanent_district, $present_village, 
        $present_post_office, $present_police_station, $present_upazilla, 
        $present_district, $photo, $signature, $cv, $tutor_id
    ]);

    echo "Profile updated successfully.<br>";
    header('Location: profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    <form action="edit_profile.php" method="post" enctype="multipart/form-data">
        <label for="name_en">Name (English):</label>
        <input type="text" id="name_en" name="name_en" value="<?php echo htmlspecialchars($tutor['name_en']); ?>" required><br>

        <label for="name_bn">Name (Bengali):</label>
        <input type="text" id="name_bn" name="name_bn" value="<?php echo htmlspecialchars($tutor['name_bn']); ?>" required><br>

        <label for="father_name_en">Father's Name:</label>
        <input type="text" id="father_name_en" name="father_name_en" value="<?php echo htmlspecialchars($tutor['father_name_en']); ?>" required><br>

        <label for="mother_name_en">Mother's Name:</label>
        <input type="text" id="mother_name_en" name="mother_name_en" value="<?php echo htmlspecialchars($tutor['mother_name_en']); ?>" required><br>

        <label for="mobile_number">Mobile Number:</label>
        <input type="text" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($tutor['mobile_number']); ?>" required><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($tutor['dob']); ?>" required><br>

        <label for="birthplace">Birthplace:</label>
        <input type="text" id="birthplace" name="birthplace" value="<?php echo htmlspecialchars($tutor['birthplace']); ?>" required><br>

        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($tutor['nationality']); ?>" required><br>

        <label for="nid_number">NID Number:</label>
        <input type="text" id="nid_number" name="nid_number" value="<?php echo htmlspecialchars($tutor['nid_number']); ?>" required><br>

        <label for="passport_number">Passport Number:</label>
        <input type="text" id="passport_number" name="passport_number" value="<?php echo htmlspecialchars($tutor['passport_number']); ?>" required><br>

        <label for="passport_expiry_date">Passport Expiry Date:</label>
        <input type="date" id="passport_expiry_date" name="passport_expiry_date" value="<?php echo htmlspecialchars($tutor['passport_expiry_date']); ?>" required><br>

        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($tutor['gender']); ?>" required><br>

        <label for="marital_status">Marital Status:</label>
        <input type="text" id="marital_status" name="marital_status" value="<?php echo htmlspecialchars($tutor['marital_status']); ?>" required><br>

        <label for="mailing_address">Mailing Address:</label>
        <input type="text" id="mailing_address" name="mailing_address" value="<?php echo htmlspecialchars($tutor['mailing_address']); ?>" required><br>

        <label for="permanent_village">Permanent Village:</label>
        <input type="text" id="permanent_village" name="permanent_village" value="<?php echo htmlspecialchars($tutor['permanent_village']); ?>" required><br>

        <label for="permanent_post_office">Permanent Post Office:</label>
        <input type="text" id="permanent_post_office" name="permanent_post_office" value="<?php echo htmlspecialchars($tutor['permanent_post_office']); ?>" required><br>

        <label for="permanent_police_station">Permanent Police Station:</label>
        <input type="text" id="permanent_police_station" name="permanent_police_station" value="<?php echo htmlspecialchars($tutor['permanent_police_station']); ?>" required><br>

        <label for="permanent_upazilla">Permanent Upazilla:</label>
        <input type="text" id="permanent_upazilla" name="permanent_upazilla" value="<?php echo htmlspecialchars($tutor['permanent_upazilla']); ?>" required><br>

        <label for="permanent_district">Permanent District:</label>
        <input type="text" id="permanent_district" name="permanent_district" value="<?php echo htmlspecialchars($tutor['permanent_district']); ?>" required><br>

        <label for="present_village">Present Village:</label>
        <input type="text" id="present_village" name="present_village" value="<?php echo htmlspecialchars($tutor['present_village']); ?>" required><br>

        <label for="present_post_office">Present Post Office:</label>
        <input type="text" id="present_post_office" name="present_post_office" value="<?php echo htmlspecialchars($tutor['present_post_office']); ?>" required><br>

        <label for="present_police_station">Present Police Station:</label>
        <input type="text" id="present_police_station" name="present_police_station" value="<?php echo htmlspecialchars($tutor['present_police_station']); ?>" required><br>

        <label for="present_upazilla">Present Upazilla:</label>
        <input type="text" id="present_upazilla" name="present_upazilla" value="<?php echo htmlspecialchars($tutor['present_upazilla']); ?>" required><br>

        <label for="present_district">Present District:</label>
        <input type="text" id="present_district" name="present_district" value="<?php echo htmlspecialchars($tutor['present_district']); ?>" required><br>

        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*"><br>

        <label for="signature">Signature:</label>
        <input type="file" id="signature" name="signature" accept="image/*"><br>

        <label for="cv">CV:</label>
        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx"><br>

        <button type="submit">Update Profile</button>
        <button type="button" onclick="window.location.href='profile.php'">Cancel</button>
    </form>
</body>
</html>