<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vc') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tutor_id = $_POST['tutor_id'];
    $action = $_POST['action'];
    $comments = $_POST['comments'] ?? '';

    $conn = get_db_connection();

    if ($action == 'approve') {
        $status = 'selected';
    } elseif ($action == 'send_back') {
        $status = 'forwarded_to_provc';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    $sql = "UPDATE tutors SET status = ?, comments = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $comments, $tutor_id]);

    // If approved, also notify SSS
    if ($action == 'approve') {
        // Notify SSS (this could be an email, a message in the system, etc.)
        // For simplicity, we'll just log it here
        error_log("Tutor ID $tutor_id approved by VC and forwarded to SSS");
    }

    header('Location: dashboard.php');
    exit();
}
?>