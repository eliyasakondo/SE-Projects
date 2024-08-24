<?php
// Hash passwords
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Verify passwords
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}
?>
