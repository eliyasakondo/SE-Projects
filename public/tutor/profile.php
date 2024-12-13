<?php
session_start();
error_log("Accessing tutor profile");
echo "Accessing tutor profile<br>";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'tutor') {
    error_log("Unauthorized access or session expired");
    echo "Unauthorized access or session expired<br>";
    header('Location: ../login.php');
    exit();
}

error_log("Tutor profile accessed by user_id: " . $_SESSION['user_id']);
echo "Tutor profile accessed by user_id: " . $_SESSION['user_id'] . "<br>";

include '../../includes/db.php'; // Ensure this path is correct
include '../../includes/functions.php'; // Ensure this path is correct

$tutor_id = getTutorIdByUserId($_SESSION['user_id']);
$tutor = getTutorById($tutor_id);
$education = getTutorEducation($tutor_id);
$experience = getTutorExperience($tutor_id);
$languages = getTutorLanguages($tutor_id);
$researchProjects = getTutorResearchProjects($tutor_id);
$publications = getTutorPublications($tutor_id);
$references = getTutorReferences($tutor_id);

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

function getTutorEducation($tutor_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM tutor_education WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $tutor_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTutorExperience($tutor_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM tutor_experience WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $tutor_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTutorLanguages($tutor_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM tutor_language WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $tutor_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTutorResearchProjects($tutor_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM tutor_research_project WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $tutor_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTutorPublications($tutor_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM tutor_publication WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $tutor_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTutorReferences($tutor_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM tutor_reference WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $tutor_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h2>Welcome to the Profile Page</h2>
    <p>Your session ID is: <?php echo $_SESSION['user_id']; ?></p>
    <h3>Tutor Details:</h3>
    <ul>
        <li><strong>ID:</strong> <?php echo htmlspecialchars($tutor['tutor_id']); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($tutor['email']); ?></li>
        <li><strong>Name (English):</strong> <?php echo htmlspecialchars($tutor['name_en']); ?></li>
        <li><strong>Name (Bengali):</strong> <?php echo htmlspecialchars($tutor['name_bn']); ?></li>
        <li><strong>Father's Name:</strong> <?php echo htmlspecialchars($tutor['father_name_en']); ?></li>
        <li><strong>Mother's Name:</strong> <?php echo htmlspecialchars($tutor['mother_name_en']); ?></li>
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
    </ul>

    <h3>Educational Qualifications:</h3>
    <ul>
        <?php if (empty($education)) : ?>
            <li>No educational qualifications found.</li>
        <?php else : ?>
            <?php foreach ($education as $edu): ?>
                <li><strong>Degree Type:</strong> <?php echo htmlspecialchars($edu['degree_type']); ?></li>
                <li><strong>Exam Name:</strong> <?php echo htmlspecialchars($edu['exam_name']); ?></li>
                <li><strong>Institute Name:</strong> <?php echo htmlspecialchars($edu['institute_name']); ?></li>
                <li><strong>Board Name:</strong> <?php echo htmlspecialchars($edu['board_name']); ?></li>
                <li><strong>Subject Group:</strong> <?php echo htmlspecialchars($edu['subject_group']); ?></li>
                <li><strong>Study From:</strong> <?php echo htmlspecialchars($edu['study_from']); ?></li>
                <li><strong>Study To:</strong> <?php echo htmlspecialchars($edu['study_to']); ?></li>
                <li><strong>Passing Year:</strong> <?php echo htmlspecialchars($edu['passing_year']); ?></li>
                <li><strong>Result/CGPA:</strong> <?php echo htmlspecialchars($edu['result_cgpa']); ?></li>
                <li><strong>CGPA Out Of:</strong> <?php echo htmlspecialchars($edu['cgpa_out_of']); ?></li>
                <li><strong>Total Marks:</strong> <?php echo htmlspecialchars($edu['total_marks']); ?></li>
                <li><strong>Supervisor Name and Address:</strong> <?php echo htmlspecialchars($edu['supervisor_name_address']); ?></li>
                <li><strong>Attachment:</strong> <a href="<?php echo htmlspecialchars($edu['attachment_certificate']); ?>" target="_blank">Download Certificate</a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Experiences:</h3>
    <ul>
        <?php if (empty($experience)) : ?>
            <li>No experiences found.</li>
        <?php else : ?>
            <?php foreach ($experience as $exp): ?>
                <li><strong>Organization Type:</strong> <?php echo htmlspecialchars($exp['organization_type']); ?></li>
                <li><strong>Organization Name:</strong> <?php echo htmlspecialchars($exp['organization_name']); ?></li>
                <li><strong>Experience Type:</strong> <?php echo htmlspecialchars($exp['experience_type']); ?></li>
                <li><strong>Designation:</strong> <?php echo htmlspecialchars($exp['designation']); ?></li>
                <li><strong>Start Date:</strong> <?php echo htmlspecialchars($exp['start_date']); ?></li>
                <li><strong>End Date:</strong> <?php echo htmlspecialchars($exp['end_date']); ?></li>
                <li><strong>Basic Salary:</strong> <?php echo htmlspecialchars($exp['basic_salary']); ?></li>
                <li><strong>Pay Scale:</strong> <?php echo htmlspecialchars($exp['pay_scale']); ?></li>
                <li><strong>Details:</strong> <?php echo htmlspecialchars($exp['details']); ?></li>
                <li><strong>Attachment:</strong> <a href="<?php echo htmlspecialchars($exp['experience_attachment']); ?>" target="_blank">Download Certificate</a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Language Proficiency:</h3>
    <ul>
        <?php if (empty($languages)) : ?>
            <li>No languages found.</li>
        <?php else : ?>
            <?php foreach ($languages as $lang): ?>
                <li><strong>Language:</strong> <?php echo htmlspecialchars($lang['language']); ?></li>
                <li><strong>Proficiency Level:</strong> <?php echo htmlspecialchars($lang['proficiency_level']); ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Research Projects:</h3>
    <ul>
        <?php if (empty($researchProjects)) : ?>
            <li>No research projects found.</li>
        <?php else : ?>
            <?php foreach ($researchProjects as $project): ?>
                <li><strong>Title:</strong> <?php echo htmlspecialchars($project['research_title']); ?></li>
                <li><strong>Funding Agency:</strong> <?php echo htmlspecialchars($project['funding_agency']); ?></li>
                <li><strong>Period:</strong> <?php echo htmlspecialchars($project['research_period']); ?></li>
                <li><strong>Funding Amount:</strong> <?php echo htmlspecialchars($project['funding_amount']); ?></li>
                <li><strong>Status:</strong> <?php echo htmlspecialchars($project['research_status']); ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Publications:</h3>
    <ul>
        <?php if (empty($publications)) : ?>
            <li>No publications found.</li>
        <?php else : ?>
            <?php foreach ($publications as $pub): ?>
                <li><strong>Publication Source:</strong> <?php echo htmlspecialchars($pub['publication_source']); ?></li>
                <?php if ($pub['publication_source'] === 'Journal'): ?>
                    <li><strong>Journal Title:</strong> <?php echo htmlspecialchars($pub['journal_title']); ?></li>
                    <li><strong>Authors:</strong> <?php echo htmlspecialchars($pub['journal_authors']); ?></li>
                    <li><strong>Journal Name:</strong> <?php echo htmlspecialchars($pub['journal_name']); ?></li>
                    <li><strong>Year:</strong> <?php echo htmlspecialchars($pub['journal_year']); ?></li>
                    <li><strong>Month:</strong> <?php echo htmlspecialchars($pub['journal_month']); ?></li>
                    <li><strong>Pages:</strong> <?php echo htmlspecialchars($pub['journal_pages']); ?></li>
                    <li><strong>Publisher:</strong> <?php echo htmlspecialchars($pub['journal_publisher']); ?></li>
                    <li><strong>Volume:</strong> <?php echo htmlspecialchars($pub['journal_volume']); ?></li>
                    <li><strong>Type of Author:</strong> <?php echo htmlspecialchars($pub['journal_author_type']); ?></li>
                    <li><strong>Issue:</strong> <?php echo htmlspecialchars($pub['journal_issue']); ?></li>
                    <li><strong>Keywords:</strong> <?php echo htmlspecialchars($pub['journal_keywords']); ?></li>
                    <li><strong>Impact Factor:</strong> <?php echo htmlspecialchars($pub['journal_impact_factor']); ?></li>
                    <li><strong>ISSN:</strong> <?php echo htmlspecialchars($pub['journal_issn']); ?></li>
                    <li><strong>DOI:</strong> <?php echo htmlspecialchars($pub['journal_doi']); ?></li>
                    <li><strong>Indexed By:</strong> <?php echo htmlspecialchars($pub['journal_indexed_by']); ?></li>
                    <li><strong>Web URL:</strong> <a href="<?php echo htmlspecialchars($pub['journal_web_url']); ?>" target="_blank">View Journal</a></li>
                <?php elseif ($pub['publication_source'] === 'Book'): ?>
                    <li><strong>Book Title:</strong> <?php echo htmlspecialchars($pub['book_title']); ?></li>
                    <li><strong>Authors:</strong> <?php echo htmlspecialchars($pub['book_authors']); ?></li>
                    <li><strong>Year:</strong> <?php echo htmlspecialchars($pub['book_year']); ?></li>
                    <li><strong>Month:</strong> <?php echo htmlspecialchars($pub['book_month']); ?></li>
                    <li><strong>City:</strong> <?php echo htmlspecialchars($pub['book_city']); ?></li>
                    <li><strong>Publisher:</strong> <?php echo htmlspecialchars($pub['book_publisher']); ?></li>
                    <li><strong>Keywords:</strong> <?php echo htmlspecialchars($pub['book_keywords']); ?></li>
                    <li><strong>Impact Factor:</strong> <?php echo htmlspecialchars($pub['book_impact_factor']); ?></li>
                    <li><strong>Indexed By:</strong> <?php echo htmlspecialchars($pub['book_indexed_by']); ?></li>
                    <li><strong>ISBN:</strong> <?php echo htmlspecialchars($pub['book_isbn']); ?></li>
                    <li><strong>Web URL:</strong> <a href="<?php echo htmlspecialchars($pub['book_web_url']); ?>" target="_blank">View Book</a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>References:</h3>
<ul>
    <?php if (empty($references)) : ?>
        <li>No references found.</li>
    <?php else : ?>
        <?php foreach ($references as $ref): ?>
            <li><strong>Name:</strong> <?php echo htmlspecialchars($ref['reference_name']); ?></li>
            <li><strong>Designation:</strong> <?php echo htmlspecialchars($ref['reference_designation']); ?></li>
            <li><strong>Organization:</strong> <?php echo htmlspecialchars($ref['reference_organization']); ?></li>
            <li><strong>Mobile:</strong> <?php echo htmlspecialchars($ref['reference_mobile']); ?></li>
            <li><strong>Email:</strong> <?php echo htmlspecialchars($ref['reference_email']); ?></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>

<a href="edit_profile.php">Edit Profile</a>
<a href="logout.php">Logout</a>
</body>
</html>