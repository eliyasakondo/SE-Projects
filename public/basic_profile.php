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

    // Process educational qualifications
    $education = [];
    if (isset($_POST['degree_type'])) {
        foreach ($_POST['degree_type'] as $index => $degree_type) {
            $education[] = [
                'degree_type' => htmlspecialchars($degree_type),
                'exam_name' => htmlspecialchars($_POST['exam_name'][$index]),
                'institute_name' => htmlspecialchars($_POST['institute_name'][$index]),
                'board_name' => htmlspecialchars($_POST['board_name'][$index]),
                'subject_group' => htmlspecialchars($_POST['subject_group'][$index]),
                'study_from' => htmlspecialchars($_POST['study_from'][$index]),
                'study_to' => htmlspecialchars($_POST['study_to'][$index]),
                'passing_year' => htmlspecialchars($_POST['passing_year'][$index]),
                'result_cgpa' => htmlspecialchars($_POST['result_cgpa'][$index]),
                'cgpa_out_of' => htmlspecialchars($_POST['cgpa_out_of'][$index]),
                'total_marks' => htmlspecialchars($_POST['total_marks'][$index]),
                'supervisor_name_address' => htmlspecialchars($_POST['supervisor_name_address'][$index]),
                'attachment_certificate' => handleFileUploadArray('attachment_certificate', $index)
            ];

            // Insert educational qualifications into the database
            $stmt = $conn->prepare("INSERT INTO tutor_education (tutor_id, degree_type, exam_name, institute_name, board_name, subject_group, study_from, study_to, passing_year, result_cgpa, cgpa_out_of, total_marks, supervisor_name_address, attachment_certificate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("isssssssssssss", $tutor_id, $education[$index]['degree_type'], $education[$index]['exam_name'], $education[$index]['institute_name'], $education[$index]['board_name'], $education[$index]['subject_group'], $education[$index]['study_from'], $education[$index]['study_to'], $education[$index]['passing_year'], $education[$index]['result_cgpa'], $education[$index]['cgpa_out_of'], $education[$index]['total_marks'], $education[$index]['supervisor_name_address'], $education[$index]['attachment_certificate']);
            if ($stmt->execute() === false) {
                die("Execute failed: " . $stmt->error);
            }
        }
    }

    
    // Process experiences
    $experiences = [];
    if (isset($_POST['organization_type'])) {
        foreach ($_POST['organization_type'] as $index => $organization_type) {
            $experiences[] = [
                'organization_type' => htmlspecialchars($organization_type),
                'organization_name' => htmlspecialchars($_POST['organization_name'][$index]),
                'experience_type' => htmlspecialchars($_POST['experience_type'][$index]),
                'designation' => htmlspecialchars($_POST['designation'][$index]),
                'start_date' => htmlspecialchars($_POST['start_date'][$index]),
                'end_date' => htmlspecialchars($_POST['end_date'][$index]),
                'basic_salary' => htmlspecialchars($_POST['basic_salary'][$index]),
                'pay_scale' => htmlspecialchars($_POST['pay_scale'][$index]),
                'details' => htmlspecialchars($_POST['details'][$index]),
                'experience_attachment' => handleFileUploadArray('experience_attachment', $index)
            ];

            // Insert experiences into the database
            $stmt = $conn->prepare("INSERT INTO tutor_experience (tutor_id, organization_type, organization_name, experience_type, designation, start_date, end_date, basic_salary, pay_scale, details, experience_attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssssssss", $tutor_id, $experiences[$index]['organization_type'], $experiences[$index]['organization_name'], $experiences[$index]['experience_type'], $experiences[$index]['designation'], $experiences[$index]['start_date'], $experiences[$index]['end_date'], $experiences[$index]['basic_salary'], $experiences[$index]['pay_scale'], $experiences[$index]['details'], $experiences[$index]['experience_attachment']);
            $stmt->execute();
        }
    }
    
    // Process language proficiency
    $languages = [];
    if (isset($_POST['language'])) {
        foreach ($_POST['language'] as $index => $language) {
            $languages[] = [
                'language' => htmlspecialchars($language),
                'proficiency_level' => htmlspecialchars($_POST['proficiency_level'][$index])
            ];

            // Insert language proficiency into the database
            $stmt = $conn->prepare("INSERT INTO tutor_language (tutor_id, language, proficiency_level) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $tutor_id, $languages[$index]['language'], $languages[$index]['proficiency_level']);
            $stmt->execute();
        }
    }

    // Process research projects
    $research_projects = [];
    if (isset($_POST['research_title'])) {
        foreach ($_POST['research_title'] as $index => $research_title) {
            $research_projects[] = [
                'research_title' => htmlspecialchars($research_title),
                'funding_agency' => htmlspecialchars($_POST['funding_agency'][$index]),
                'research_period' => htmlspecialchars($_POST['research_period'][$index]),
                'funding_amount' => htmlspecialchars($_POST['funding_amount'][$index]),
                'research_status' => htmlspecialchars($_POST['research_status'][$index])
            ];

            // Insert research projects into the database
            $stmt = $conn->prepare("INSERT INTO tutor_research_project (tutor_id, title, funding_agency, period, funding_amount, status) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("isssss", $tutor_id, $research_projects[$index]['research_title'], $research_projects[$index]['funding_agency'], $research_projects[$index]['research_period'], $research_projects[$index]['funding_amount'], $research_projects[$index]['research_status']);
            if ($stmt->execute() === false) {
                die("Execute failed: " . $stmt->error);
            }
        }
    }


   // $conn->close();

    // Redirect or display a success message
    echo "Form submitted successfully!";
}

//Single File Upload
function handleFileUpload($fieldName, $index = null) {
    if ($index !== null) {
        $fieldName = $fieldName . '[' . $index . ']';
    }
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES[$fieldName]['name']);
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadFile)) {
            return $uploadFile;
        } else {
            error_log("Failed to move uploaded file for $fieldName");
        }
    } else {
        error_log("File upload error for $fieldName: " . $_FILES[$fieldName]['error']);
    }
    return null;
}

//Multiple File Upload
function handleFileUploadArray($fieldName, $index) {
    if (isset($_FILES[$fieldName]) && isset($_FILES[$fieldName]['name'][$index]) && $_FILES[$fieldName]['error'][$index] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES[$fieldName]['name'][$index]);
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$index], $uploadFile)) {
            return $uploadFile;
        } else {
            error_log("Failed to move uploaded file for $fieldName[$index]");
        }
    } else {
        error_log("File upload error for $fieldName[$index]: " . $_FILES[$fieldName]['error'][$index]);
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

        <h3>Educational Qualification</h3>
        
        <div id="education-section">
            <div class="education-entry show">
                <h4>Add Education Info</h4>
                <label for="degree_type">Degree Type:<span>*</span></label>
                <select id="degree_type" name="degree_type[]" required>
                    <option value="">--Select--</option>
                    <option value="SSC/equivalent">SSC/equivalent</option>
                    <option value="HSC/equivalent">HSC/equivalent</option>
                    <option value="Bachelors">Bachelors</option>
                    <option value="Masters">Masters</option>
                    <option value="M.Phil.">M.Phil.</option>
                    <option value="Ph.D./equivalent">Ph.D./equivalent</option>
                    <option value="Diploma">Diploma</option>
                    <option value="PGD">PGD</option>
                    <option value="Others">Others</option>
                </select>
                
                <label for="exam_name">Exam Name (in English):<span>*</span></label>
                <input type="text" id="exam_name" name="exam_name[]" required>
                
                <label for="institute_name">Institute Name (in English):<span>*</span></label>
                <input type="text" id="institute_name" name="institute_name[]" required>
                
                <label for="board_name">Board Name (in English):</label>
                <input type="text" id="board_name" name="board_name[]">
                
                <label for="subject_group">Subject/Group Name (in English):<span>*</span></label>
                <input type="text" id="subject_group" name="subject_group[]" required>
                
                <label for="study_from">Study From:<span>*</span></label>
                <input type="date" id="study_from" name="study_from[]" required>
                
                <label for="study_to">Study To:<span>*</span></label>
                <input type="date" id="study_to" name="study_to[]" required>
                
                <label for="passing_year">Passing Year:<span>*</span></label>
                <select id="passing_year" name="passing_year[]" required>
                    <option value="">--Select--</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                </select>
                
                <label for="result_cgpa">Result/CGPA:<span>*</span></label>
                <input type="number" id="result_cgpa" name="result_cgpa[]" required>
                
                <label for="cgpa_out_of">Out of:<span>*</span></label>
                <select id="cgpa_out_of" name="cgpa_out_of[]" required>
                    <option value="">--Select--</option>
                    <option value="5.00">5.00</option>
                    <option value="4.00">4.00</option>
                    <option value="3.00">3.00</option>
                </select>
                
                <label for="total_marks">Total Marks:</label>
                <input type="number" id="total_marks" name="total_marks[]">
                
                <label for="supervisor_name_address">Name and Address of Supervisor:</label>
                <textarea id="supervisor_name_address" name="supervisor_name_address[]" rows="3" ></textarea>
                
                <label for="attachment_certificate">Attachment (Certificate in pdf):<span>*</span></label>
                <input type="file" id="attachment_certificate" name="attachment_certificate[]" required>
            </div>
        </div>
        <button type="button" id="add-education" class="btn btn-add-education">Add More Education</button>

        <h3>Experiences</h3>

        <div id="experience-section">
            <div class="experience-entry show">
                <label for="organization_type">Organization Type:<span>*</span></label>
                <select id="organization_type" name="organization_type[]" required>
                    <option value="">--Select--</option>
                    <option value="University">University</option>
                    <option value="Research organization">Research organization</option>
                    <option value="Govt. job">Govt. job</option>
                    <option value="Private job">Private job</option>
                    <option value="Autonomous">Autonomous</option>
                    <option value="Others">Others</option>
                </select>
        
                <label for="organization_name">Organization Name:<span>*</span></label>
                <input type="text" id="organization_name" name="organization_name[]" required>
        
                <label for="experience_type">Experience Type:<span>*</span></label>
                <select id="experience_type" name="experience_type[]" required>
                    <option value="">--Select--</option>
                    <option value="Teaching">Teaching</option>
                    <option value="Research">Research</option>
                    <option value="Others">Others</option>
                </select>
        
                <label for="designation">Designation:<span>*</span></label>
                <input type="text" id="designation" name="designation[]" required>
        
                <label for="start_date">Start Date:<span>*</span></label>
                <input type="date" id="start_date" name="start_date[]" required>
        
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date[]">
        
                <label for="basic_salary">Basic Salary:<span>*</span></label>
                <input type="number" id="basic_salary" name="basic_salary[]" required>
        
                <label for="pay_scale">Pay Scale:</label>
                <input type="text" id="pay_scale" name="pay_scale[]">
        
                <label for="details">Details:<span>*</span></label>
                <textarea id="details" name="details[]" rows="3" required></textarea>
        
                <label for="experience_attachment">Attachment (Experience Certificate in pdf):<span>*</span></label>
                <input type="file" id="experience_attachment" name="experience_attachment[]" accept="application/pdf" required>
            </div>
        </div>
        <button type="button" id="add-experience" class="btn btn-add-experience">Add More Experience</button>
         
        <h3>Language Proficiency</h3>

        <div id="language-section">
            <div class="language-entry show">
                <label for="language">Language:<span>*</span></label>
                <input type="text" id="language" name="language[]" required>
        
                <label for="proficiency_level">Proficiency Level:<span>*</span></label>
                <select id="proficiency_level" name="proficiency_level[]" required>
                    <option value="">--Select--</option>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Professional">Professional</option>
                    <option value="Fluent">Fluent</option>
                    <option value="Native/Bi-lingual">Native/Bi-lingual</option>
                </select>
            </div>
        </div>
        <button type="button" id="add-language" class="btn btn-add-language">Add Language Proficiency</button>
        
        <h3>Research Project Info</h3>
        
        <div id="research-project-section">
            <div class="research-project-entry show">
                <label for="research_title">Title:</label>
                <input type="text" class="research_title" name="research_title[]">
        
                <label for="funding_agency">Awarding/Funding Agency:</label>
                <input type="text" id="funding_agency" name="funding_agency[]">
        
                <label for="research_period">Period:</label>
                <input type="text" id="research_period" name="research_period[]">
        
                <label for="funding_amount">Funding Amount (in Lakh BDT):</label>
                <input type="number" id="funding_amount" name="funding_amount[]">
        
                <label for="research_status">Status:</label>
                <select id="research_status" name="research_status[]">
                    <option value="">--Select--</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
        </div>
        <button type="button" id="add-research-project" class="btn btn-add-research-project">Add More Research Project</button>

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
<script>
document.getElementById('add-education').addEventListener('click', function() {
    var educationSection = document.getElementById('education-section');
    var newEntry = document.createElement('div');
    newEntry.classList.add('education-entry');
    newEntry.innerHTML = `
        <div>
            <h4>Add Education Info</h4>
            <label for="degree_type">Degree Type:<span>*</span></label>
            <select id="degree_type" name="degree_type[]" required>
                <option value="">--Select--</option>
                <option value="SSC/equivalent">SSC/equivalent</option>
                <option value="HSC/equivalent">HSC/equivalent</option>
                <option value="Bachelors">Bachelors</option>
                <option value="Masters">Masters</option>
                <option value="M.Phil.">M.Phil.</option>
                <option value="Ph.D./equivalent">Ph.D./equivalent</option>
                <option value="Diploma">Diploma</option>
                <option value="PGD">PGD</option>
                <option value="Others">Others</option>
            </select>
            
            <label for="exam_name">Exam Name (in English):<span>*</span></label>
            <input type="text" id="exam_name" name="exam_name[]" required>
            
            <label for="institute_name">Institute Name (in English):<span>*</span></label>
            <input type="text" id="institute_name" name="institute_name[]" required>
            
            <label for="board_name">Board Name (in English):</label>
            <input type="text" id="board_name" name="board_name[]">
            
            <label for="subject_group">Subject/Group Name (in English):<span>*</span></label>
            <input type="text" id="subject_group" name="subject_group[]" required>
            
            <label for="study_from">Study From:<span>*</span></label>
            <input type="date" id="study_from" name="study_from[]" required>
            
            <label for="study_to">Study To:<span>*</span></label>
            <input type="date" id="study_to" name="study_to[]" required>
            
            <label for="passing_year">Passing Year:<span>*</span></label>
            <select id="passing_year" name="passing_year[]" required>
                <option value="">--Select--</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2020">2020</option>
            </select>
            
            <label for="result_cgpa">Result/CGPA:<span>*</span></label>
            <input type="number" id="result_cgpa" name="result_cgpa[]" required>
            
            <label for="cgpa_out_of">Out of:<span>*</span></label>
            <select id="cgpa_out_of" name="cgpa_out_of[]" required>
                <option value="">--Select--</option>
                <option value="5.00">5.00</option>
                <option value="4.00">4.00</option>
                <option value="3.00">3.00</option>
            </select>
            
            <label for="total_marks">Total Marks:</label>
            <input type="number" id="total_marks" name="total_marks[]">
            
            <label for="supervisor_name_address">Name and Address of Supervisor:</label>
            <textarea id="supervisor_name_address" name="supervisor_name_address[]" rows="3"></textarea>
            
            <label for="attachment_certificate">Attachment (Certificate in pdf):<span>*</span></label>
            <input type="file" id="attachment_certificate" name="attachment_certificate[]" required>
            
            <button type="button" class="remove-education">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    educationSection.appendChild(newEntry);
    setTimeout(() => newEntry.classList.add('show'), 10); // Add show class with a slight delay
    addRemoveButtonListener();
});

document.getElementById('add-experience').addEventListener('click', function() {
    var experienceSection = document.getElementById('experience-section');
    var newEntry = document.createElement('div');
    newEntry.classList.add('experience-entry');
    newEntry.innerHTML = `
        <div>
            <h4>Add Experience Info</h4>
            <label for="organization_type">Organization Type:<span>*</span></label>
            <select id="organization_type" name="organization_type[]" required>
                <option value="">--Select--</option>
                <option value="University">University</option>
                <option value="Research organization">Research organization</option>
                <option value="Govt. job">Govt. job</option>
                <option value="Private job">Private job</option>
                <option value="Autonomous">Autonomous</option>
                <option value="Others">Others</option>
            </select>

            <label for="organization_name">Organization Name:<span>*</span></label>
            <input type="text" id="organization_name" name="organization_name[]" required>

            <label for="experience_type">Experience Type:<span>*</span></label>
            <select id="experience_type" name="experience_type[]" required>
                <option value="">--Select--</option>
                <option value="Teaching">Teaching</option>
                <option value="Research">Research</option>
                <option value="Others">Others</option>
            </select>

            <label for="designation">Designation:<span>*</span></label>
            <input type="text" id="designation" name="designation[]" required>

            <label for="start_date">Start Date:<span>*</span></label>
            <input type="date" id="start_date" name="start_date[]" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date[]">

            <label for="basic_salary">Basic Salary:<span>*</span></label>
            <input type="number" id="basic_salary" name="basic_salary[]" required>

            <label for="pay_scale">Pay Scale:</label>
            <input type="text" id="pay_scale" name="pay_scale[]">

            <label for="details">Details:<span>*</span></label>
            <textarea id="details" name="details[]" rows="3" required></textarea>

            <label for="experience_attachment">Attachment (Experience Certificate in pdf):<span>*</span></label>
            <input type="file" id="experience_attachment" name="experience_attachment[]" accept="application/pdf" required>

            <button type="button" class="remove-experience">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    experienceSection.appendChild(newEntry);
    setTimeout(() => newEntry.classList.add('show'), 10); // Add show class with a slight delay
    addRemoveButtonListener();
});

document.getElementById('add-language').addEventListener('click', function() {
    var languageSection = document.getElementById('language-section');
    var newEntry = document.createElement('div');
    newEntry.classList.add('language-entry');
    newEntry.innerHTML = `
        <div>
            <h4>Add Language Proficiency</h4>
            <label for="language">Language:<span>*</span></label>
            <input type="text" id="language" name="language[]" required>

            <label for="proficiency_level">Proficiency Level:<span>*</span></label>
            <select id="proficiency_level" name="proficiency_level[]" required>
                <option value="">--Select--</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Professional">Professional</option>
                <option value="Fluent">Fluent</option>
                <option value="Native/Bi-lingual">Native/Bi-lingual</option>
            </select>

            <button type="button" class="remove-language">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    languageSection.appendChild(newEntry);
    setTimeout(() => newEntry.classList.add('show'), 10); // Add show class with a slight delay
    addRemoveButtonListener();
});

document.getElementById('add-research-project').addEventListener('click', function() {
    var researchProjectSection = document.getElementById('research-project-section');
    var newEntry = document.createElement('div');
    newEntry.classList.add('research-project-entry');
    newEntry.innerHTML = `
        <div>
            <h4>Add Research Project Info</h4>
            <label for="research_title">Title:</label>
            <input type="text" class="research_title" name="research_title[]">
        
            <label for="funding_agency">Awarding/Funding Agency:</label>
            <input type="text" id="funding_agency" name="funding_agency[]">
        
            <label for="research_period">Period:</label>
            <input type="text" id="research_period" name="research_period[]">
        
            <label for="funding_amount">Funding Amount (in Lakh BDT):</label>
            <input type="number" id="funding_amount" name="funding_amount[]">
        
            <label for="research_status">Status:</label>
            <select id="research_status" name="research_status[]">
                <option value="">--Select--</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
            </select>

            <button type="button" class="remove-research-project">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    researchProjectSection.appendChild(newEntry);
    setTimeout(() => newEntry.classList.add('show'), 10); // Add show class with a slight delay
    addRemoveButtonListener();
});

function addRemoveButtonListener() {
    var removeEducationButtons = document.querySelectorAll('.remove-education');
    removeEducationButtons.forEach(function(button) {
        button.removeEventListener('click', removeEducationEntry);
        button.addEventListener('click', removeEducationEntry);
    });

    var removeExperienceButtons = document.querySelectorAll('.remove-experience');
    removeExperienceButtons.forEach(function(button) {
        button.removeEventListener('click', removeExperienceEntry);
        button.addEventListener('click', removeExperienceEntry);
    });

    var removeLanguageButtons = document.querySelectorAll('.remove-language');
    removeLanguageButtons.forEach(function(button) {
        button.removeEventListener('click', removeLanguageEntry);
        button.addEventListener('click', removeLanguageEntry);
    });

    var removeResearchProjectButtons = document.querySelectorAll('.remove-research-project');
    removeResearchProjectButtons.forEach(function(button) {
        button.removeEventListener('click', removeResearchProjectEntry);
        button.addEventListener('click', removeResearchProjectEntry);
    });

}

function removeEducationEntry(event) {
    var entry = event.target.closest('.education-entry');
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

function removeExperienceEntry(event) {
    var entry = event.target.closest('.experience-entry');
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

function removeLanguageEntry(event) {
    var entry = event.target.closest('.language-entry');
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

function removeResearchProjectEntry(event) {
    var entry = event.target.closest('.research-project-entry');
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

// Initialize remove button listeners for any existing entries
addRemoveButtonListener();
</script>