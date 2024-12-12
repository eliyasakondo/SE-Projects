<?php
session_start(); // Start the session

// Set a session variable
$_SESSION['test'] = 'Session is working!';

// Display the session variable
echo "Session variable 'test' is set to: " . $_SESSION['test'] . "<br>";

// Display the session ID
echo "Session ID: " . session_id() . "<br>";

// Check if session files are being created
$sessionFiles = glob("C:\\xampp\\tmp\\sess_*");
echo "Session files in the directory:<br>";
foreach ($sessionFiles as $file) {
    echo basename($file) . "<br>";
}
?>