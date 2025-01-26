
<?php
include('../conn/conn.php');
session_start();

if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit;
}


$user_number = $_SESSION['user_number'];

$sql = "SELECT user_name FROM users WHERE user_number = '$user_number'";
$sql_query = mysqli_query($conn, $sql);

if ($sql_query) {
    $row = mysqli_fetch_assoc($sql_query);
    $user_name = $row['user_name'];
}
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
            --accent-color: #2c3e50;
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

        .welcome-message {
            color: var(--secondary-color);
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .status-badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .btn-logout {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-logout:hover {
            background-color: rgb(204, 22, 16);
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
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
            مرحباً بك <?php echo htmlspecialchars($user_name); ?>
        </h1>

        <div class="text-center">
            <div class="status-badge">
                تم تسجيل الحساب بنجاح
            </div>

            <p class="welcome-message">
                شكراً لتسجيلك معنا، حسابك قيد المراجعة الآن، وسيتم ترقيته بعد موافقة الإدارة.
            </p>

            <a href="../general/logout.php" class="btn btn-logout">
                تسجيل الخروج
            </a>
        </div>
    </div>
</body>

</html>