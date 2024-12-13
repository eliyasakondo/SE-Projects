<?php
session_start();
include '../../includes/functions.php';
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dean') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tutor_id = $_POST['tutor_id'];
    $action = $_POST['action'];
    $comments = $_POST['comments'] ?? '';

    $conn = get_db_connection();

    if ($action == 'approve') {
        $status = 'approved';
    } elseif ($action == 'send_back') {
        $status = 'pending';
    }

    $sql = "UPDATE tutors SET status = ?, comments = ? WHERE tutor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $comments, $tutor_id]);

    header('Location: view_tutors.php');
    exit();
}
?>