<?php
include('conn.php');
if (isset($_GET['id'])) {
    $delet_id = intval($_GET['id']); 
    $query = "DELETE FROM users WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $delet_id);

    if ($stmt->execute()) {
        header('Location: users.php');
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