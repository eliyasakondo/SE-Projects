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
                <label for="title">Title:</label>
                <input type="text" id="title" name="title[]">
        
                <label for="funding_agency">Awarding/Funding Agency:</label>
                <input type="text" id="funding_agency" name="funding_agency[]">
        
                <label for="period">Period:</label>
                <input type="text" id="period" name="period[]">
        
                <label for="grant">Grant (in Lakh BDT):</label>
                <input type="number" id="grant" name="grant[]">
        
                <label for="status">Status:</label>
                <select id="status" name="status[]">
                    <option value="">--Select--</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
        </div>
        <button type="button" id="add-research-project" class="btn btn-add-research-project">Add More Research Project</button>

        <h3>Publications</h3>

        <div id="publication-section">
            <div class="publication-entry show">
                <label for="publication_source">Publication Source:</label>
                <select id="publication_source" name="publication_source[]" required onchange="togglePublicationFields(this)">
                    <option value="">--Select--</option>
                    <option value="Journal">Journal</option>
                    <option value="Book">Book</option>
                </select>
        
                <div class="journal-fields" style="display: none;">
                    <label for="title">Title:<span>*</span></label>
                    <input type="text" id="title" name="title[]" required>
        
                    <label for="authors">Author(s):</label>
                    <input type="text" id="authors" name="authors[]">
                    <small>Use comma(,) to separate multiple authors(s)</small>
        
                    <label for="journal_name">Journal Name:</label>
                    <input type="text" id="journal_name" name="journal_name[]">
        
                    <label for="year">Year:<span>*</span></label>
                    <select id="year" name="year[]" required>
                        <option value="">--Select Year--</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
        
                    <label for="month">Month:<span>*</span></label>
                    <select id="month" name="month[]" required>
                        <option value="">--Select--</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <!-- Add other months as needed -->
                    </select>
        
                    <label for="pages">Pages:</label>
                    <input type="text" id="pages" name="pages[]">
        
                    <label for="publisher">Publisher:</label>
                    <input type="text" id="publisher" name="publisher[]">
        
                    <label for="volume">Volume:</label>
                    <input type="text" id="volume" name="volume[]">
        
                    <label for="author_type">Type of Author:</label>
                    <select id="author_type" name="author_type[]">
                        <option value="">--Select--</option>
                        <option value="Principle">Principle</option>
                        <option value="Corresponding">Corresponding</option>
                    </select>
        
                    <label for="issue">Issue:</label>
                    <input type="text" id="issue" name="issue[]">
        
                    <label for="keywords">Keyword(s):</label>
                    <input type="text" id="keywords" name="keywords[]">
                    <small>Use comma(,) to separate multiple keyword(s)</small>
        
                    <label for="impact_factor">Impact Factor/Cite Score (If any):</label>
                    <input type="text" id="impact_factor" name="impact_factor[]">
        
                    <label for="issn">ISSN:</label>
                    <input type="text" id="issn" name="issn[]">
        
                    <label for="doi">DOI:</label>
                    <input type="text" id="doi" name="doi[]">
        
                    <label for="indexed_by">Indexed By(s):</label>
                    <input type="text" id="indexed_by" name="indexed_by[]">
                    <small>Use comma(,) to Indexed multiple separate By(s)</small>
        
                    <label for="web_url">Web Url:</label>
                    <input type="url" id="web_url" name="web_url[]">
                </div>
        
                <div class="book-fields" style="display: none;">
                    <label for="book_title">Book Title:<span>*</span></label>
                    <input type="text" id="book_title" name="book_title[]" required>
        
                    <label for="book_authors">Author(s):</label>
                    <input type="text" id="book_authors" name="book_authors[]">
                    <small>Use comma(,) to separate multiple authors(s)</small>
        
                    <label for="book_year">Year:<span>*</span></label>
                    <select id="book_year" name="book_year[]" required>
                        <option value="">--Select Year--</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
        
                    <label for="book_month">Month:<span>*</span></label>
                    <select id="book_month" name="book_month[]" required>
                        <option value="">--Select--</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <!-- Add other months as needed -->
                    </select>
        
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city[]">
        
                    <label for="book_publisher">Book Publisher:</label>
                    <input type="text" id="book_publisher" name="book_publisher[]">
        
                    <label for="book_keywords">Keyword(s):</label>
                    <input type="text" id="book_keywords" name="book_keywords[]">
                    <small>Use comma(,) to separate multiple keyword(s)</small>
        
                    <label for="book_impact_factor">Impact Factor/Cite Score (If any):</label>
                    <input type="text" id="book_impact_factor" name="book_impact_factor[]">
        
                    <label for="indexed_by">Indexed By(s):</label>
                    <input type="text" id="indexed_by" name="indexed_by[]">
                    <small>Use comma(,) to Indexed multiple separate By(s)</small>
        
                    <label for="isbn">ISBN No:</label>
                    <input type="text" id="isbn" name="isbn[]">
        
                    <label for="book_web_url">Web Url:</label>
                    <input type="url" id="book_web_url" name="book_web_url[]">
                </div>
            </div>
        </div>  
        <button type="button" id="add-publication" class="btn btn-add-publication">Add More Publication</button>
        
        <h3>Reference Info</h3>
        <div id="reference-section">
            <div class="reference-entry show">
                <label for="reference_name">Name:<span>*</span></label>
                <input type="text" id="reference_name" name="reference_name[]" required>
        
                <label for="reference_designation">Designation:<span>*</span></label>
                <input type="text" id="reference_designation" name="reference_designation[]" required>
        
                <label for="reference_organization">Organization Name:<span>*</span></label>
                <input type="text" id="reference_organization" name="reference_organization[]" required>
        
                <label for="reference_mobile">Mobile:<span>*</span></label>
                <input type="text" id="reference_mobile" name="reference_mobile[]" required>
        
                <label for="reference_email">Email:<span>*</span></label>
                <input type="email" id="reference_email" name="reference_email[]" required>
            </div>
        </div>
        <button type="button" id="add-reference" class="btn btn-add-reference">Add More Reference</button>

        <div>
            <label for="terms_conditions">
            <input type="checkbox" id="terms_conditions" name="terms_conditions" required>
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
            <label for="title">Title:</label>
            <input type="text" id="title" name="title[]">

            <label for="funding_agency">Awarding/Funding Agency:</label>
            <input type="text" id="funding_agency" name="funding_agency[]">

            <label for="period">Period:</label>
            <input type="text" id="period" name="period[]">

            <label for="grant">Grant (in Lakh BDT):</label>
            <input type="number" id="grant" name="grant[]">

            <label for="status">Status:</label>
            <select id="status" name="status[]">
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

document.getElementById('add-publication').addEventListener('click', function() {
    var publicationSection = document.getElementById('publication-section');
    var newEntry = document.createElement('div');
    newEntry.classList.add('publication-entry');
    newEntry.innerHTML = `
        <div>
            <h4>Add Publication Info</h4>
            <label for="publication_source">Publication Source:<span>*</span></label>
            <select id="publication_source" name="publication_source[]" required onchange="togglePublicationFields(this)">
                <option value="">--Select--</option>
                <option value="Journal">Journal</option>
                <option value="Book">Book</option>
            </select>

            <div class="journal-fields" style="display: none;">
                <label for="title">Title:<span>*</span></label>
                <input type="text" id="title" name="title[]" required>

                <label for="authors">Author(s): 
                    <small>Use comma(,) to separate multiple authors(s)</small>
                </label>
                <input type="text" id="authors" name="authors[]">
                

                <label for="journal_name">Journal Name:</label>
                <input type="text" id="journal_name" name="journal_name[]">

                <label for="year">Year:<span>*</span></label>
                <select id="year" name="year[]" required>
                    <option value="">--Select Year--</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                </select>

                <label for="month">Month:<span>*</span></label>
                <select id="month" name="month[]" required>
                    <option value="">--Select--</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                    <!-- Add other months as needed -->
                </select>

                <label for="pages">Pages:</label>
                <input type="text" id="pages" name="pages[]">

                <label for="publisher">Publisher:</label>
                <input type="text" id="publisher" name="publisher[]">

                <label for="volume">Volume:</label>
                <input type="text" id="volume" name="volume[]">

                <label for="author_type">Type of Author:</label>
                <select id="author_type" name="author_type[]">
                    <option value="">--Select--</option>
                    <option value="Principle">Principle</option>
                    <option value="Corresponding">Corresponding</option>
                </select>

                <label for="issue">Issue:</label>
                <input type="text" id="issue" name="issue[]">

                <label for="keywords">Keyword(s):<small>Use comma(,) to separate multiple keyword(s)</small></label>
                <input type="text" id="keywords" name="keywords[]">
                

                <label for="impact_factor">Impact Factor/Cite Score (If any):</label>
                <input type="text" id="impact_factor" name="impact_factor[]">

                <label for="issn">ISSN:</label>
                <input type="text" id="issn" name="issn[]">

                <label for="doi">DOI:</label>
                <input type="text" id="doi" name="doi[]">

                <label for="indexed_by">Indexed By(s):<small>Use comma(,) to Indexed multiple separate By(s)</small></label>
                <input type="text" id="indexed_by" name="indexed_by[]">
                

                <label for="web_url">Web Url:</label>
                <input type="url" id="web_url" name="web_url[]">
            </div>

            <div class="book-fields" style="display: none;">
                <label for="book_title">Book Title:<span>*</span></label>
                <input type="text" id="book_title" name="book_title[]" required>

                <label for="book_authors">Author(s):<small>Use comma(,) to separate multiple authors(s)</small></label>
                <input type="text" id="book_authors" name="book_authors[]">
                

                <label for="book_year">Year:<span>*</span></label>
                <select id="book_year" name="book_year[]" required>
                    <option value="">--Select Year--</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                </select>

                <label for="book_month">Month:<span>*</span></label>
                <select id="book_month" name="book_month[]" required>
                    <option value="">--Select--</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                    <!-- Add other months as needed -->
                </select>

                <label for="city">City:</label>
                <input type="text" id="city" name="city[]">

                <label for="book_publisher">Book Publisher:</label>
                <input type="text" id="book_publisher" name="book_publisher[]">

                <label for="book_keywords">Keyword(s): <small>Use comma(,) to separate multiple keyword(s)</small></label>
                <input type="text" id="book_keywords" name="book_keywords[]">
               

                <label for="book_impact_factor">Impact Factor/Cite Score (If any):</label>
                <input type="text" id="book_impact_factor" name="book_impact_factor[]">

                <label for="indexed_by">Indexed By(s): <small>Use comma(,) to Indexed multiple separate By(s)</small></label>
                <input type="text" id="indexed_by" name="indexed_by[]">
               

                <label for="isbn">ISBN No:</label>
                <input type="text" id="isbn" name="isbn[]">

                <label for="book_web_url">Web Url:</label>
                <input type="url" id="book_web_url" name="book_web_url[]">
            </div>

            <button type="button" class="remove-publication">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    publicationSection.appendChild(newEntry);
    setTimeout(() => newEntry.classList.add('show'), 10); // Add show class with a slight delay
    addRemoveButtonListener();
});

function togglePublicationFields(selectElement) {
    var journalFields = selectElement.closest('.publication-entry').querySelector('.journal-fields');
    var bookFields = selectElement.closest('.publication-entry').querySelector('.book-fields');

    if (selectElement.value === 'Journal') {
        journalFields.style.display = 'block';
        bookFields.style.display = 'none';
    } else if (selectElement.value === 'Book') {
        journalFields.style.display = 'none';
        bookFields.style.display = 'block';
    } else {
        journalFields.style.display = 'none';
        bookFields.style.display = 'none';
    }
}

document.getElementById('add-reference').addEventListener('click', function() {
    var referenceSection = document.getElementById('reference-section');
    var newEntry = document.createElement('div');
    newEntry.classList.add('reference-entry');
    newEntry.innerHTML = `
        <div>
            <h4>Add Reference Info</h4>
            <label for="reference_name">Name:<span>*</span></label>
            <input type="text" id="reference_name" name="reference_name[]" required>

            <label for="reference_designation">Designation:<span>*</span></label>
            <input type="text" id="reference_designation" name="reference_designation[]" required>

            <label for="reference_organization">Organization Name:<span>*</span></label>
            <input type="text" id="reference_organization" name="reference_organization[]" required>

            <label for="reference_mobile">Mobile:<span>*</span></label>
            <input type="text" id="reference_mobile" name="reference_mobile[]" required>

            <label for="reference_email">Email:<span>*</span></label>
            <input type="email" id="reference_email" name="reference_email[]" required>

            <button type="button" class="remove-reference">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    referenceSection.appendChild(newEntry);
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

    var removePublicationButtons = document.querySelectorAll('.remove-publication');
    removePublicationButtons.forEach(function(button) {
        button.removeEventListener('click', removePublicationEntry);
        button.addEventListener('click', removePublicationEntry);
    });

    var removeReferenceButtons = document.querySelectorAll('.remove-reference');
    removeReferenceButtons.forEach(function(button) {
    button.removeEventListener('click', removeReferenceEntry);
    button.addEventListener('click', removeReferenceEntry);
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

function removePublicationEntry(event) {
    var entry = event.target.closest('.publication-entry');
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

function removeReferenceEntry(event) {
    var entry = event.target.closest('.reference-entry');
    entry.classList.remove('show');
    setTimeout(() => entry.remove(), 300); // Remove element after transition
}

// Initialize remove button listeners for any existing entries
addRemoveButtonListener();
</script>