<?php
include('../conn/conn.php');
session_start();

if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'admin') {
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="icon" href="../style/logo.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../style/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #2c3e50;
        }



        .welcome-container {
            background: #ffffff;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: absolute;
            /* تحديد الموقع بالنسبة للشاشة */
            top: 50%;
            /* التمركز عموديًا */
            left: 50%;
            /* التمركز أفقيًا */
            transform: translate(-50%, -50%);
            /* نقل الحاوية إلى المنتصف */
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
            margin-bottom: 0.5rem;
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

                padding: 1.5rem;
            }

            .welcome-header {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <nav class=" navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="btn btn-light" id="toggle-sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <div class="d-flex align-items-center me-3">
                    <img src="../style/logo.png" alt="" style="width: 40px; height: 40px; border-radius: 50%;" />
                </div>
            </div>
            <a href="../general/logout.php" class="btn btn-danger btn-sm ms-auto">
                <i class="bi bi-door-open-fill me-1"></i>
                <span class="d-none d-md-inline">تسجيل الخروج</span>
            </a>

        </div>
    </nav>

    <!-- Sidebar -->
    
    <div class="sidebar" id="sidebar">
        <div class="user-profile">
            <img src="../style/logo.png" alt="" style="width: 70px; height: 70px; border-radius: 50%;" />
            <h5 class="mb-2" style="margin-top: 20px;"><?php echo $user_name; ?></h5>
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link" href="../general/profile.php">
                    <i class="bi bi-person"></i>
                    الملف الشخصي </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="private_admin.php">
                    <i class="bi bi-link-45deg ms-2"></i>
                    الروابط الخاصة
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="genecral_admin.php">
                    <i class="bi bi-link-45deg ms-2"></i>
                    الروابط العامة
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../general/logout.php">
                    <i class="bi bi-door-open-fill me-1"></i>
                    <span class="m-none d-sm-inline">تسجيل الخروج</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="welcome-container">
        <h1 class="welcome-header text-center">
            مرحباً بك <?php echo htmlspecialchars($user_name); ?>
        </h1>
        <div class="text-center">
            <p class="welcome-message">
                اضغط على <button class="btn btn-light" id="toggle-sidebar">
                    <i class="bi bi-list"></i>
                </button>  
            </p>
            <p class="welcome-message">
            في أعلى الصفحة للتنقل بين الصفحات 
            </p>

            <a href="../general/logout.php" class="btn btn-logout">
                تسجيل الخروج
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-sidebar');
            const mainContent = document.querySelector('.main-content');

            // إضافة overlay للخلفية
            const overlay = document.createElement('div');
            overlay.className = 'overlay';
            document.body.appendChild(overlay);

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });

            overlay.addEventListener('click', toggleSidebar);

            // إغلاق القائمة عند الضغط خارجها
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            });

            // منع إغلاق القائمة عند الضغط داخلها
            sidebar.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>

</html>