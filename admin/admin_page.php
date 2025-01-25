<?php
include('../conn/conn.php');
session_start();

// التأكد من أن المستخدم هو "admin" فقط
if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../general/login.php');
    exit;
}

// استرجاع رقم المستخدم من الجلسة
$name = $_SESSION['user_number'];

// التحقق من وجود قيمة بحث
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// أولاً: نبحث عن رقم المستخدم في جدول users باستخدام قيمة من الجلسة
$sql_user = "SELECT user_number FROM users WHERE user_number = '$name'";

// تنفيذ الاستعلام لجلب رقم المستخدم
$result_user = $conn->query($sql_user);

// إذا كان هناك تطابق مع الرقم في جدول users
if ($result_user->num_rows > 0) {
    // استرجاع الرقم الذي تم العثور عليه في جدول users
    $user_data = $result_user->fetch_assoc();
    $user_number = $user_data['user_number'];
    
    // ثانياً: الآن نبحث في جدول url_data باستخدام الرقم الذي وجدناه في جدول users
    // هنا نبحث في جدول url_data مع تطابق admin_url مع user_number من جدول users
    $sql_url_data = "SELECT * FROM url_data WHERE 
                     (url_title LIKE '%$search%' OR 
                      url LIKE '%$search%' OR 
                      admin_url LIKE '%$search%' OR 
                      id LIKE '%$search%')
                      AND admin_url = '$user_number'"; 

    // تنفيذ الاستعلام
    $rows = $conn->query($sql_url_data);

    // معالجة البيانات إذا كان هناك نتائج
    if ($rows->num_rows > 0) {
        while ($row = $rows->fetch_assoc()) {
            echo "نتيجة البحث: " . $row['url_title'] . "<br>";
        }
    } else {
        echo "لا توجد نتائج مطابقة.";
    }
} else {
    // في حالة عدم العثور على المستخدم في جدول users
    echo "المستخدم غير موجود.";
}

$conn->close();
?>             





<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        rel="stylesheet" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap"
        rel="stylesheet" />
    <link rel="icon" href="heder-icon.png"
        type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <title>إضافة معلومات المشرفين</title>
</head>

<body>
    <nav class=" navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="btn btn-light" id="toggle-sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <div class="d-flex align-items-center me-3">
                    <img src="logo.png" alt="" style="width: 40px; height: 40px; border-radius: 50%;" />
                </div>
            </div>
            <a href="logout.php" class="btn btn-danger btn-sm ms-auto">
                <i class="bi bi-door-open-fill me-1"></i>
                <span class="d-none d-md-inline">تسجيل الخروج</span>
            </a>
        </div>
    </nav>
    <div class="sidebar" id="sidebar">
        <div class="user-profile">
            <img src="logo.png" alt="" style="width: 70px; height: 70px; border-radius: 50%;" />
            <h5 class="mb-2" style="margin-top: 20px;">اسم الأدمن</h5>
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link" href="profile.php">
                    <i class="bi bi-person"></i>
                    الملف الشخصي </a>
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
                    الروابط الخاصة
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-link-45deg ms-2"></i>
                    الروابط العامة
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="bi bi-door-open-fill me-1"></i>
                    <span class="m-none d-sm-inline">تسجيل الخروج</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="container">
        <form action="" method="get">
            <div class="container my-1">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <input class="form-control me-5" type="search" placeholder="أدخل كلمة البحث" aria-label="بحث">
                        <button class="btn btn-outline-success" style="color: #ae2754; border-color: #cf0c0c; margin-right: 10px; " type="submit">
                            بحث
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="overflow-auto w-100" style="height: 400px;">
            <table id="lessons-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="position: sticky; top: 0; z-index: 10;">#</th>
                        <th style="position: sticky; top: 0; z-index: 10;">عنوان الرابط</th>
                        <th style="position: sticky; top: 0; z-index: 10;">الرابط</th>
                        <th style="position: sticky; top: 0; z-index: 10;">الإجراءات</th> <!-- تم تبديل العناوين -->
                        <th style="position: sticky; top: 0; z-index: 10;">الملاحظات</th> <!-- تم تبديل العناوين -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($rows->num_rows > 0) {
                        while ($row = $rows->fetch_assoc()) {
                            echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['url_title'] . '</td>
                        <td>' . $row['url'] . '</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 align-items-center">
                                <a class="btn py-2 btn-primary" href="delet.php?id=' . $row['id'] . '" onclick="return confirmDelete();">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                                <a class="py-2 btn btn-success update" href="update.php?id=' . $row['id'] . '">
                                    <i class="bi bi-copy"></i>
                                </a>
                            </div>
                        </td> <!-- تم تبديل المحتوى -->
                        <td class="note_1"> ' . $row['note'] . '</td> <!-- تم تبديل المحتوى -->
                    </tr>
                    ';
                        }
                    } else {
                        echo '
                <tr>
                    <td colspan="6">لا توجد بيانات</td>
                </tr>
                ';
                    }
                    ?>
                </tbody>
            </table>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>


</body>

</html>