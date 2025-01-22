<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provc') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tutor_id = $_POST['tutor_id'];
    $action = $_POST['action'];
    $comments = $_POST['comments'] ?? '';

    $conn = get_db_connection();

    if ($action == 'forward_vc') {
        $status = 'forwarded_to_vc';
    } elseif ($action == 'send_back') {
        $status = 'forwarded_to_sss';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    $sql = "UPDATE tutors SET status = ?, comments = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $comments, $tutor_id]);

    header('Location: dashboard.php');
    exit();
}
?>