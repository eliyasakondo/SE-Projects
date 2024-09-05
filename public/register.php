<?php
/*
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
*/
?>
<?php
include_once '../includes/header.php';
include_once '../includes/functions.php';
body {
    font-family: 'Roboto', Arial, sans-serif;
    color: #000000;
    background-color: #FFFFFF;
}

h2, h3 {
    font-family: 'Poppins', Arial, sans-serif;
    color: #264653;
}

label {
    font-family: 'Poppins', Arial, sans-serif;
    color: #264653;
}

input, select, textarea {
    font-family: 'Roboto', Arial, sans-serif;
    border: 1px solid #2a9d8f;
    padding: 8px;
    margin-bottom: 10px;
    width: 100%;
}

button {
    font-family: 'Poppins', Arial, sans-serif;
    background-color: #2a9d8f;
    color: #FFFFFF;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #f4a261;
}

main {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fefae0;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
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
    $degree = $_POST['degree'];
    $university = $_POST['university'];
    $major = $_POST['major'];
    $degree_duration = $_POST['degree_duration'];
    $cgpa = $_POST['cgpa'];
    $cgpa_out_of = $_POST['cgpa_out_of'];
    $organization = $_POST['organization'];
    $job_responsibilities = $_POST['job_responsibilities'];
    $service_duration = $_POST['service_duration'];
    
    // Insert into tutors table
    $sql = "INSERT INTO tutors (email, password) VALUES (?, ?)";
    query($sql, [$email, $password]);
    
    // Get the last inserted tutor ID
    $tutor_id = get_last_insert_id();
    
    // Insert into applications table
    $sql = "INSERT INTO applications (tutor_id, name, father_name, mother_name, nid, passport, dob, degree, university, major, degree_duration, cgpa, cgpa_out_of, organization, job_responsibilities, service_duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    query($sql, [$tutor_id, $name, $father_name, $mother_name, $nid, $passport, $dob, $degree, $university, $major, $degree_duration, $cgpa, $cgpa_out_of, $organization, $job_responsibilities, $service_duration]);
    
    echo "Registration successful! Your application is under review.";
}
?>
<main>
    <h2>Register</h2>
    <form method="POST" action="">
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
        
        <h3>Educational Qualification</h3>
        
        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" required>
        
        <label for="university">University:</label>
        <input type="text" id="university" name="university" required>
        
        <label for="major">Major:</label>
        <input type="text" id="major" name="major" required>
        
        <label for="degree_duration">Duration (Years):</label>
        <input type="number" id="degree_duration" name="degree_duration" required>
        
        <label for="cgpa">CGPA:</label>
        <input type="text" id="cgpa" name="cgpa" required>
        
        <label for="cgpa_out_of">CGPA Out Of:</label>
        <select id="cgpa_out_of" name="cgpa_out_of" required>
            <option value="5.00">5.00</option>
            <option value="4.00">4.00</option>
            <option value="3.00">3.00</option>
        </select>
        
        <h3>Experiences</h3>
        
        <label for="organization">Organization:</label>
        <input type="text" id="organization" name="organization" required>
        
        <label for="job_responsibilities">Job Responsibilities:</label>
        <input type="text" id="job_responsibilities" name="job_responsibilities" required>
        
        <label for="service_duration">Duration:</label>
        <input type="date" id="service_duration" name="service_duration" required>
        
        <button type="submit">Register</button>
    </form>
</main>
<?php
include_once '../includes/footer.php';

?>
