<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sss') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tutor_id = $_POST['tutor_id'];
    $action = $_POST['action'];
    $comments = $_POST['comments'] ?? '';

    $conn = get_db_connection();

    if ($action == 'forward_provc') {
        $status = 'forwarded_to_provc';
    } elseif ($action == 'send_back_dean') {
        $status = 'forwarded_to_dean';
    } elseif ($action == 'call_candidate') {
        $status = 'called';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    $sql = "UPDATE tutors SET status = ?, comments = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $comments, $tutor_id]);

    if ($action == 'call_candidate') {
        $_SESSION['message'] = "Candidate has been successfully called.";
    }

    header('Location: dashboard.php');
    exit();
}
?>