<?php
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

?>
