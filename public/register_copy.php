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
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="father_name">Father's Name:</label>
        <input type="text" id="father_name" name="father_name" required>
        
        <label for="mother_name">Mother's Name:</label>
        <input type="text" id="mother_name" name="mother_name" required>
        
        <label for="nid">National ID:</label>
        <input type="text" id="nid" name="nid" required>
        
        <label for="passport">Passport Number:</label>
        <input type="text" id="passport" name="passport" required>
        
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
        
        <label for="photo">Profile Photo:</label>
        <input type="file" id="photo" name="photo" required>
        
        <label for="signature">Signature:</label>
        <input type="file" id="signature" name="signature" required>
        
        <label for="cv">CV:</label>
        <input type="file" id="cv" name="cv" required>
        
        <h3>Educational Qualification</h3>
        
        <div id="education-section">
            <div class="education-entry">
                <label for="degree">Degree:</label>
                <input type="text" id="degree" name="degree[]" required>
                
                <label for="university">University:</label>
                <input type="text" id="university" name="university[]" required>
                
                <label for="major">Major:</label>
                <input type="text" id="major" name="major[]" required>
                
                <label for="degree_duration">Duration (Years):</label>
                <input type="number" id="degree_duration" name="degree_duration[]" required>
                
                <label for="cgpa">CGPA:</label>
                <input type="text" id="cgpa" name="cgpa[]" required>
                
                <label for="cgpa_out_of">CGPA Out Of:</label>
                <select id="cgpa_out_of" name="cgpa_out_of[]" required>
                    <option value="5.00">5.00</option>
                    <option value="4.00">4.00</option>
                    <option value="3.00">3.00</option>
                </select>
            </div>
        </div>
        <button type="button" id="add-education">Add More Education</button>
        
        <h3>Experiences</h3>
        
        <div id="experience-section">
            <div class="experience-entry">
                <label for="organization">Organization:</label>
                <input type="text" id="organization" name="organization[]" required>
                
                <label for="job_responsibilities">Job Responsibilities:</label>
                <input type="text" id="job_responsibilities" name="job_responsibilities[]" required>
                
                <label for="joining_date">Joining Date:</label>
                <input type="date" id="joining_date" name="joining_date[]" required>
                
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date[]" required>
                
                <label for="till_today">Till Today:</label>
                <input type="checkbox" id="till_today" name="till_today[]" onchange="toggleEndDate(this)">
                
                <label for="attachment">Attachment (CV):</label>
                <input type="file" id="attachment" name="attachment[]" required>
            </div>
        </div>
        <button type="button" id="add-experience">Add More Experience</button>
        
        <button type="submit">Register</button>
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
        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree[]" required>
        
        <label for="university">University:</label>
        <input type="text" id="university" name="university[]" required>
        
        <label for="major">Major:</label>
        <input type="text" id="major" name="major[]" required>
        
        <label for="degree_duration">Duration (Years):</label>
        <input type="number" id="degree_duration" name="degree_duration[]" required>
        
        <label for="cgpa">CGPA:</label>
        <input type="text" id="cgpa" name="cgpa[]" required>
        
        <label for="cgpa_out_of">CGPA Out Of:</label>
        <select id="cgpa_out_of" name="cgpa_out_of[]" required>
            <option value="5.00">5.00</option>
            <option value="4.00">4.00</option>
            <option value="3.00">3.00</option>
        </select>
        <button type="button" class="remove-education">Remove</button>
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
        <label for="organization">Organization:</label>
        <input type="text" id="organization" name="organization[]" required>
        
        <label for="job_responsibilities">Job Responsibilities:</label>
        <input type="text" id="job_responsibilities" name="job_responsibilities[]" required>
        
        <label for="joining_date">Joining Date:</label>
        <input type="date" id="joining_date" name="joining_date[]" required>
        
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date[]" required>
        
        <label for="till_today">Till Today:</label>
        <input type="checkbox" id="till_today" name="till_today[]" onchange="toggleEndDate(this)">
        
        <label for="attachment">Attachment (CV):</label>
        <input type="file" id="attachment" name="attachment[]" required>
        <button type="button" class="remove-experience">Remove</button>
    `;
    experienceSection.appendChild(newEntry);
    setTimeout(() => newEntry.classList.add('show'), 10); // Add show class with a slight delay
    addRemoveButtonListener();
});

function toggleEndDate(checkbox) {
    var endDateInput = checkbox.parentElement.querySelector('input[name="end_date[]"]');
    if (checkbox.checked) {
        endDateInput.disabled = true;
    } else {
        endDateInput.disabled = false;
    }
}

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
    var entry = event.target.parentElement;
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

function removeExperienceEntry(event) {
    var entry = event.target.parentElement;
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

// Initialize remove button listeners for any existing entries
addRemoveButtonListener();
</script>