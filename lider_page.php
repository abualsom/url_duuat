<?php
include('conn.php');
session_start();

if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'lider') {
    header('Location: login.php');
    exit;
}
$name = $_SESSION['user_number'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المدير العام</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Noto Kufi Arabic', serif;
        }

        :root {
            --sidebar-width: 280px;
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --hover-color: aqua;
            --text-color: white;
            --border-color: #ddd;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            right: -280px;
            top: 0;
            background: var(--primary-color);
            color: var(--text-color);
            z-index: 1000;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.show {
            right: 0;
        }

        .main-content {
            transition: all 0.3s;
        }

        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: var(--text-color);
        }

        .user-profile {
            background-color: var(--primary-color);
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--text-color);
            margin: 0 auto 15px;
        }

        .table th,
        .table td {
            border-left: 1px solid var(--border-color);
            text-align: center;
        }

        .table th:last-child,
        .table td:last-child {
            border-left: none;
        }

        th {
            background-color: var(--primary-color) !important;
            color: var(--text-color) !important;
        }

        th:last-child,
        td:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        th:first-child,
        td:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .btn-group button {
            margin: 0 5px;
        }

        .nav-link {
            color: #ddd;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--hover-color);
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: var(--text-color);
            background: var(--secondary-color);
        }

        .a_icon {
            margin: 5px;
        }

        #toggle-sidebar {
            position: fixed;
            right: 10px;
            top: 15px;
            z-index: 1100;
        }


        .serch:hover{
            background-color:antiquewhite;
            color:  rgba(145, 34, 34, 0.1);
            box-shadow: 0 2px 4px rgba(167, 188, 243, 0.1);
            transition: all 0.3s ease;
        }

       
            
        

        
        
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="btn btn-light" id="toggle-sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <div class="d-flex align-items-center me-3">
                    <div class="user-avatar me-2" style="width: 40px; height: 40px; font-size: 1.2rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h6 class="mb-0">اسم الأدمن</h6>
                </div>
            </div>
            <button class="btn btn-danger btn-sm ms-auto">
                <i class="bi bi-door-open-fill me-1"></i>
                تسجيل الخروج
            </button>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="user-profile">
            <div class="user-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <h5 class="mb-2">اسم الأدمن</h5>
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link" href="profile.php">
                <i class="bi bi-person-circle"> </i>

                    الملف الشخصي
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-people-fill ms-2"></i>
                    المستخدمين
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-link-45deg ms-2"></i>
                    كافة الروابط
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-link-45deg ms-2"></i>
                    إضافة الروابط الخاصة
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-link-45deg ms-2"></i>
                    إضافة الروابط العامة
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="bi bi-door-open-fill me-1"></i>
                    تسجيل الخروج
                </a>
            </li>
        </ul>
    </div>
    <form action="" method="post">
        <!-- Form Card -->
        <div class="container my-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="text-center mb-0" style="color: #2c3e50;">إضافة رابط جديد</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="needs-validation" novalidate>
                        <div class="row">
                            <!-- URL Name Field -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="url_name" class="form-label fw-bold" style="color: #2c3e50;">عنوان الرابط:</label>
                                    <input type="text" class="form-control" id="url_name" name="url_name" required>
                                </div>
                            </div>

                            <!-- URL Field -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="url" class="form-label fw-bold" style="color: #2c3e50;">الرابط:</label>
                                    <input type="url" class="form-control" id="url" name="url" required>
                                </div>
                            </div>

                            <!-- Admin Selection -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="url_admin" class="form-label fw-bold" style="color: #2c3e50;">المشرف:</label>
                                    <select class="form-select select2" id="url_admin" name="url_admin" required>
                                        <option value="" disabled selected>اختر مشرف</option>
                                        <?php
                                        if ($rows_1->num_rows > 0) {
                                            while ($row_1 = $rows_1->fetch_assoc()) {
                                                echo '<option value="' . $row_1['location_name'] . '">' . $row_1['location_name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>لم تقوموا بإضافة أي مشرف</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Notes Field -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="note" class="form-label fw-bold" style="color: #2c3e50;">ملاحظات:</label>
                                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button type="submit" name="submit" class="btn btn-lg px-5"
                                style="background-color: #2c3e50; color: white;">
                                إضافة البيانات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>

    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Navbar داخل بطاقة -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarScroll">
                            
                            <form class="d-flex" role="search">
                                <input class="serch form-control me-4" type="search" placeholder="بحث" aria-label="بحث">
                                <button class="btn btn-outline-success" type="submit">بحث</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="80">#</th>
                                    <th>عنوان الرابط</th>
                                    <th width="300">الإجراءات</th>
                                    <th>الملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>https://example.com</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="" class="a_icon btn btn-danger btn-sm" title="حذف">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <a href="lider_edit.php" class="a_icon btn btn-primary btn-sm" title="تعديل">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="" class="a_icon btn btn-success btn-sm" title="نسخ">
                                                <i class="bi bi-clipboard" id="copyButton" onclick="copyButtonText(this)"> </i>
                                            </a>
                                            <a href="" class="a_icon btn btn-info btn-sm" title="فتح">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>

                                        </div>
                                    </td>
                                    <td>ملاحظة تجريبية</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>