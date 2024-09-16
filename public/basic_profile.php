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
    // Sanitize and validate input data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name_en = htmlspecialchars($_POST['name_en']);
    $name_bn = htmlspecialchars($_POST['name_bn']);
    $father_name_en = htmlspecialchars($_POST['father_name_en']);
    $mother_name_en = htmlspecialchars($_POST['mother_name_en']);
    $mobile_number = htmlspecialchars($_POST['mobile_number']);
    $dob = htmlspecialchars($_POST['dob']);
    $birthplace = htmlspecialchars($_POST['birthplace']);
    $nationality = htmlspecialchars($_POST['nationality']);
    $nid_number = htmlspecialchars($_POST['nid_number']);
    $passport_number = htmlspecialchars($_POST['passport_number']);
    $passport_expiry_date = htmlspecialchars($_POST['passport_expiry_date']);
    $gender = htmlspecialchars($_POST['gender']);
    $marital_status = htmlspecialchars($_POST['marital_status']);
    $mailing_address = htmlspecialchars($_POST['mailing_address']);
    $permanent_village = htmlspecialchars($_POST['permanent_village']);
    $permanent_post_office = htmlspecialchars($_POST['permanent_post_office']);
    $permanent_police_station = htmlspecialchars($_POST['permanent_police_station']);
    $permanent_upazilla = htmlspecialchars($_POST['permanent_upazilla']);
    $permanent_district = htmlspecialchars($_POST['permanent_district']);
    $present_village = htmlspecialchars($_POST['present_village']);
    $present_post_office = htmlspecialchars($_POST['present_post_office']);
    $present_police_station = htmlspecialchars($_POST['present_police_station']);
    $present_upazilla = htmlspecialchars($_POST['present_upazilla']);
    $present_district = htmlspecialchars($_POST['present_district']);

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

function handleFileUpload($fieldName, $index = null) {
    if ($index !== null) {
        $fieldName = $fieldName . '[' . $index . ']';
    }
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES[$fieldName]['name']);
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadFile)) {
            return $uploadFile;
        }
    }
    return null;
}
?>

<main>
    <h2>Register</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="email">Email:<span>*</span></label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:<span>*</span></label>
        <input type="password" id="password" name="password" required>
        
        <h3>Basic Information</h3>
        <div id="basic-info-section">
            <label for="name_en">Name (In English):<span>*</span></label>
            <input type="text" id="name_en" name="name_en" required>
        
            <label for="name_bn">Name (In Bangla):<span>*</span></label>
            <input type="text" id="name_bn" name="name_bn" required>
        
            <label for="father_name_en">Father Name (In English):<span>*</span></label>
            <input type="text" id="father_name_en" name="father_name_en" required>
        
            <label for="mother_name_en">Mother Name (In English):<span>*</span></label>
            <input type="text" id="mother_name_en" name="mother_name_en" required>
        
            <label for="mobile_number">Mobile Number:<span>*</span></label>
            <input type="text" id="mobile_number" name="mobile_number" placeholder="Example: 01XXXXXXXXX" required>
        
            <label for="dob">Date of Birth:<span>*</span></label>
            <input type="date" id="dob" name="dob" required>
        
            <label for="birthplace">Birthplace:<span>*</span></label>
            <input type="text" id="birthplace" name="birthplace" required>
        
            <label for="nationality">Nationality:<span>*</span></label>
            <select id="nationality" name="nationality" required>
                <option value="">--Select--</option>
                <option value="Bangladeshi">Bangladeshi</option>
                <option value="Others">Others</option>
            </select>
        
            <label for="nid_number">NID Number:<span>*</span></label>
            <input type="number" id="nid_number" name="nid_number" required>
        
            <label for="nid_copy">NID Copy:</label>
            <input type="file" id="nid_copy" name="nid_copy" accept="application/pdf">
        
            <label for="passport_number">Passport Number:<span>*</span></label>
            <input type="text" id="passport_number" name="passport_number" required>
        
            <label for="passport_expiry_date">Passport Expiry Date:<span>*</span></label>
            <input type="date" id="passport_expiry_date" name="passport_expiry_date" required>
        
            <label for="passport_copy">Passport Copy:</label>
            <input type="file" id="passport_copy" name="passport_copy" accept="application/pdf">
        
            <label for="gender">Gender:<span>*</span></label>
            <select id="gender" name="gender" required>
                <option value="">--Select--</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
            </select>
        
            <label for="marital_status">Marital Status:<span>*</span></label>
            <select id="marital_status" name="marital_status" required>
                <option value="">--Select--</option>
                <option value="Married">Married</option>
                <option value="Unmarried">Unmarried</option>
                <option value="Separated">Separated</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
            </select>
        
            <label for="mailing_address">Mailing Address:<span>*</span></label>
            <textarea id="mailing_address" name="mailing_address" rows="3" required></textarea>
        
            <h4>Permanent Address</h4> 
          
            <label for="permanent_village">Village/Street:<span>*</span></label>
            <input type="text" id="permanent_village" name="permanent_village" required>

            <label for="permanent_post_office">Post Office:<span>*</span></label>
            <input type="text" id="permanent_post_office" name="permanent_post_office" required>

            <label for="permanent_police_station">Police Station:<span>*</span></label>
            <input type="text" id="permanent_police_station" name="permanent_police_station" required>

            <label for="permanent_upazilla">Upazilla/City Corporation:<span>*</span></label>
            <input type="text" id="permanent_upazilla" name="permanent_upazilla" required>

            <label for="permanent_district">District:<span>*</span></label>
            <input type="text" id="permanent_district" name="permanent_district" required>
        
            <h4>Present Address</h4>

            <label for="present_village">Village/Street:<span>*</span></label>
            <input type="text" id="present_village" name="present_village" required>
            
            <label for="present_post_office">Post Office:<span>*</span></label>
            <input type="text" id="present_post_office" name="present_post_office" required>

            <label for="present_police_station">Police Station:<span>*</span></label>
            <input type="text" id="present_police_station" name="present_police_station" required>   
        
            <label for="present_upazilla">Upazilla/City Corporation:<span>*</span></label>
            <input type="text" id="present_upazilla" name="present_upazilla" required> 
           
            <label for="present_district">District:<span>*</span></label>
            <input type="text" id="present_district" name="present_district" required>

            <label for="photo">Profile Photo:<span>*</span></label>
            <input type="file" id="photo" name="photo" required>
                
            <label for="signature">Signature:<span>*</span></label>
            <input type="file" id="signature" name="signature" required>
                
            <label for="cv">CV:<span>*</span></label>
            <input type="file" id="cv" name="cv" required>
        </div>

        
        <div>
            <label for="terms_conditions" class="terms-conditions">
            <input type="checkbox" id="terms_conditions" name="terms_conditions" class="terms-conditions" required>
            I agree to the <a href="#">terms and conditions</a>.
        </div>
        <button type="submit" class="btn">Register</button>
      
    </form>
</main>


<?php
include_once '../includes/footer.php';
?>
