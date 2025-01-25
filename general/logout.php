<?php
session_start();
include('../conn/conn.php');
$role = $_SESSION['role'];
$sql_query = "SELECT * FROM users WHERE role = $role";


if (!isset($_SESSION['user_number'])) {
    header("Location: create_account.php");
    exit();
}
if (isset($_POST['yes'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
} elseif (isset($_POST['no'])) {

    if ($role == 'user') {
        header("Location: ../user/user_page.php");
        exit();
    } elseif ($role == 'admin') {
        header("Location: ../admin/admin_page.php");
        exit();
    } elseif ($role == 'lider') {
        header("Location: ../lider/lider_page.php");
        exit();
    }
}
$name = $_SESSION['user_number'];


$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الحساب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: rgb(219, 33, 33);
        }

        body {
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .welcome-container {
            background: #ffffff;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .welcome-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--accent-color);
        }

        .welcome-header {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .btn {
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            color: white;
        }

        .btn-yes {
            background-color: #6c757d;
        }

        .btn-yes:hover {
            background-color: #dc3545;
            transform: translateY(-1px);
            color: white;
        }

        .btn-no {
            background-color: #2c3e50;
        }

        .btn-no:hover {
            background-color: #28a745;
            transform: translateY(-1px);
            color: white;
        }

        @media (max-width: 576px) {
            .welcome-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .welcome-header {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <h1 class="welcome-header text-center">
            <?php echo htmlspecialchars($name); ?>
            هل حقاً تريد تسجيل الخروج؟
        </h1>

        <div class="text-center">
            <form action="" method="post">
                <button name="yes" class="btn btn-yes">نعم</button>
                <button name="no" class="btn btn-no">لا</button>
            </form>
        </div>
    </div>
</body>

</html>