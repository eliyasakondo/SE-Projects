<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pageTitle = 'Tutor Registration';
$tutor_register = '../assets/css/tutor_register.css';
include_once '../includes/header.php';
include_once '../includes/functions.php';
include_once '../includes/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "seprojects";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
     // Ensure the uploads directory exists
     if (!is_dir('../uploads')) {
        mkdir('../uploads', 0777, true);
    }
   
    // Handle file uploads
    $nid_copy = handleFileUpload('nid_copy');
    $passport_copy = handleFileUpload('passport_copy');
    $photo = handleFileUpload('photo');
    $signature = handleFileUpload('signature');
    $cv = handleFileUpload('cv');
// Insert basic information into the tutor table
$sql = "INSERT INTO tutors (email, password, name_en, name_bn, father_name_en, mother_name_en, mobile_number, dob, birthplace, nationality, nid_number, nid_copy, passport_number, passport_expiry_date, passport_copy, gender, marital_status, mailing_address, permanent_village, permanent_post_office, permanent_police_station, permanent_upazilla, permanent_district, present_village, present_post_office, present_police_station, present_upazilla, present_district, photo, signature, cv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sssssssssssssssssssssssssssssss", $email, $password, $name_en, $name_bn, $father_name_en, $mother_name_en, $mobile_number, $dob, $birthplace, $nationality, $nid_number, $nid_copy, $passport_number, $passport_expiry_date, $passport_copy, $gender, $marital_status, $mailing_address, $permanent_village, $permanent_post_office, $permanent_police_station, $permanent_upazilla, $permanent_district, $present_village, $present_post_office, $present_police_station, $present_upazilla, $present_district, $photo, $signature, $cv);

if ($stmt->execute() === false) {
    die("Execute failed: " . $stmt->error);
}

// Get the last inserted tutor ID
$tutor_id = $stmt->insert_id;

// Redirect or display a success message
echo "Form submitted successfully!";
}