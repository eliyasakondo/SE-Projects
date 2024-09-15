<?php
$pageTitle = 'Tutor Registration';
$tutor_register = '../assets/css/tutor_register.css';
include_once '../includes/header.php';
include_once '../includes/functions.php';
include_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = hash_password($_POST['password']);
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $nid = $_POST['nid'];
    $passport = $_POST['passport'];
    $dob = $_POST['dob'];
    
    // Handle file uploads
    $photo = $_FILES['photo'];
    $signature = $_FILES['signature'];
    $cv = $_FILES['cv'];

    // Validate and move uploaded files
    $photo_path = 'uploads/' . basename($photo['name']);
    $signature_path = 'uploads/' . basename($signature['name']);
    $cv_path = 'uploads/' . basename($cv['name']);
    
    move_uploaded_file($photo['tmp_name'], $photo_path);
    move_uploaded_file($signature['tmp_name'], $signature_path);
    move_uploaded_file($cv['tmp_name'], $cv_path);

    // Insert into tutors table
    $sql = "INSERT INTO tutors (email, password, photo, signature, cv) VALUES (?, ?, ?, ?, ?)";
    query($sql, [$email, $password, $photo_path, $signature_path, $cv_path]);
    
    // Get the last inserted tutor ID
    $tutor_id = get_last_insert_id();
    
    // Debugging: Check the value of tutor_id
    if (!$tutor_id) {
        die('Error: Unable to retrieve last insert ID.');
    }
    
    // Insert into educational_qualifications table
    $degrees = $_POST['degree'];
    $universities = $_POST['university'];
    $majors = $_POST['major'];
    $degree_durations = $_POST['degree_duration'];
    $cgpas = $_POST['cgpa'];
    $cgpa_out_ofs = $_POST['cgpa_out_of'];
    
    foreach ($degrees as $index => $degree) {
        $university = $universities[$index];
        $major = $majors[$index];
        $degree_duration = $degree_durations[$index];
        $cgpa = $cgpas[$index];
        $cgpa_out_of = $cgpa_out_ofs[$index];
        
        $sql = "INSERT INTO educational_qualifications (tutor_id, degree, university, major, degree_duration, cgpa, cgpa_out_of) VALUES (?, ?, ?, ?, ?, ?, ?)";
        query($sql, [$tutor_id, $degree, $university, $major, $degree_duration, $cgpa, $cgpa_out_of]);
    }
    
    // Insert into experiences table
    $organizations = $_POST['organization'];
    $job_responsibilities = $_POST['job_responsibilities'];
    $joining_dates = $_POST['joining_date'];
    $end_dates = $_POST['end_date'];
    $till_todays = isset($_POST['till_today']) ? $_POST['till_today'] : [];
    $attachments = $_FILES['attachment'];
    
    foreach ($organizations as $index => $organization) {
        $job_responsibility = $job_responsibilities[$index];
        $joining_date = $joining_dates[$index];
        $end_date = isset($till_todays[$index]) ? null : $end_dates[$index];
        $till_today = isset($till_todays[$index]) ? 1 : 0;
        
        // Handle file upload for attachment
        $attachment = $attachments['name'][$index];
        $attachment_tmp = $attachments['tmp_name'][$index];
        $attachment_path = 'uploads/' . basename($attachment);
        move_uploaded_file($attachment_tmp, $attachment_path);
        
        $sql = "INSERT INTO experiences (tutor_id, organization, job_responsibilities, joining_date, end_date, till_today, attachment) VALUES (?, ?, ?, ?, ?, ?, ?)";
        query($sql, [$tutor_id, $organization, $job_responsibility, $joining_date, $end_date, $till_today, $attachment_path]);
    }
    
    echo "Registration successful! Your application is under review.";
}
?>
<main>
    <h2>Register</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="email">Email:<span>*</span></label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:<span>*</span></label>
        <input type="password" id="password" name="password" required>
        
        <label for="name">Name:<span>*</span></label>
        <input type="text" id="name" name="name" required>
        
        <label for="father_name">Father's Name:<span>*</span></label>
        <input type="text" id="father_name" name="father_name" required>
        
        <label for="mother_name">Mother's Name:<span>*</span></label>
        <input type="text" id="mother_name" name="mother_name" required>
        
        <label for="nid">National ID:<span>*</span></label>
        <input type="text" id="nid" name="nid" required>
        
        <label for="passport">Passport Number:<span>*</span></label>
        <input type="text" id="passport" name="passport" required>
        
        <label for="dob">Date of Birth:<span>*</span></label>
        <input type="date" id="dob" name="dob" required>
        
        <label for="photo">Profile Photo:<span>*</span></label>
        <input type="file" id="photo" name="photo" required>
        
        <label for="signature">Signature:<span>*</span></label>
        <input type="file" id="signature" name="signature" required>
        
        <label for="cv">CV:<span>*</span></label>
        <input type="file" id="cv" name="cv" required>
        
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

        <label for="attachment">Attachment (Experience Certificate in pdf):<span>*</span></label>
        <input type="file" id="attachment" name="attachment[]" accept="application/pdf" required>
    </div>
</div>

            <button type="button" id="add-experience" class="btn btn-add-experience">Add More Experience</button>
        
       
       

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

            <label for="attachment">Attachment (Experience Certificate in pdf):<span>*</span></label>
            <input type="file" id="attachment" name="attachment[]" accept="application/pdf" required>

            <button type="button" class="remove-experience">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    experienceSection.appendChild(newEntry);
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

// Initialize remove button listeners for any existing entries
addRemoveButtonListener();
</script>