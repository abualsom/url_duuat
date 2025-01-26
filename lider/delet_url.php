<?php
include('../conn/conn.php');
session_start();
if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'lider') {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['id'])) {
    $delet_id = intval($_GET['id']); 
    $query = "DELETE FROM url_data WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $delet_id);

    if ($stmt->execute()) {
        header('Location: users_url.php');
        exit;
    } else {
        echo "حدث خطأ أثناء الحذف!";
    }

    $stmt->close();
} else {
    echo "المعرف غير موجود!";
}

$conn->close();
?>