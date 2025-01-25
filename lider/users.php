<?php
include '../conn/conn.php';
session_start();

if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'lider') {
    header('Location: ../general/login.php');
    exit;
}

if (isset($_POST['delete_user'])) {
    $user_number = $_POST['user_number'];
    $sql = "DELETE FROM users WHERE user_number = $user_number";
    if (mysqli_query($conn, $sql)) {
        header("Location: users.php");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

?>