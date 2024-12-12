<?php
include_once 'db.php'; // Ensure this line is present to include the database connection

// Hash passwords
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Verify passwords
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Generate year options for a select dropdown
function generateYearOptions($startYear = 1950, $endYear = null) {
    $endYear = $endYear ?: date('Y');
    $options = '';
    for ($endYear; $endYear >= $startYear; $endYear--) {
        $options .= "<option value=\"$endYear\">$endYear</option>";
    }
    return $options;
}

// Authenticate tutor
function authenticateTutor($email, $password) {
    $conn = get_db_connection(); // Ensure you have access to the database connection
    if (!$conn) {
        echo "Database connection failed.<br>";
        return false;
    }
    $sql = "SELECT * FROM tutors WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "SQL statement preparation failed: " . $conn->errorInfo()[2];
        return false;
    }
    $stmt->bindValue(1, $email, PDO::PARAM_STR); // Use bindValue for PDO
    $stmt->execute();
    $tutor = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging output
    if ($tutor) {
        echo "Tutor found: " . htmlspecialchars(print_r($tutor, true)) . "<br>";
        if (password_verify($password, $tutor['password'])) {
            return $tutor; // Return the tutor if password matches
        } else {
            echo "Password does not match.<br>";
        }
    } else {
        echo "No tutor found with that email.<br>";
    }
    return false; // Return false if authentication fails
}
?>