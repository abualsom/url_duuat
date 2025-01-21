<?php
include('conn.php');
session_start();

if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'lider') {
    header('Location: login.php');
    exit;
}
$name = $_SESSION['user_number'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url'];
    $note = $_POST['note'];
    $location = $_POST['location'];

    $sql = "UPDATE url SET url = '$url', note = '$note', location = '$location' WHERE url = '$url'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: lider_page.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

?>