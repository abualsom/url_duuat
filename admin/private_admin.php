<?php
include('../conn/conn.php');
session_start();

if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$name = $_SESSION['user_number'];

$search = '';

$sql_user = "SELECT user_number FROM users WHERE user_number = '$name'";
$result_user = mysqli_query($conn, $sql_user);

if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
    $user_number = $user_data['user_number'];

    $sql_url_data = "SELECT * FROM url_data WHERE 
                     (url_title LIKE '%$search%' OR 
                      url LIKE '%$search%' OR 
                      admin_url LIKE '%$search%' OR 
                      id LIKE '%$search%')
                      AND admin_url = '$user_number'";

    $rows = $conn->query($sql_url_data);
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
                    <img src="../style/logo.png" alt="" style="width: 40px; height: 40px; border-radius: 50%;" />
                </div>
            </div>
            <a href="../general/logout.php" class="btn btn-danger btn-sm ms-auto">
                <i class="bi bi-door-open-fill me-1"></i>
                <span class="d-none d-md-inline">تسجيل الخروج</span>
            </a>
        </div>
    </nav>
    <div class="sidebar" id="sidebar">
        <div class="user-profile">
            <img src="../style/logo.png" alt="" style="width: 70px; height: 70px; border-radius: 50%;" />
            <h5 class="mb-2" style="margin-top: 20px;"><?php echo $name; ?></h5>
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

    <div class="container">
        <form action="" method="get">
            <div class="container my-1">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <input class="form-control me-5" name="search" type="search" placeholder="أدخل كلمة البحث" aria-label="بحث">
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
                        <td>
            <div class="d-flex justify-content-center gap-2 align-items-center">
                
                <a class="btn py-2 btn-warning update" href="' . $row['url'] . '" target="_blank">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>
                <a class="btn py-2 btn-success update" href="#" onclick="copyToClipboard(\'' . $row['url'] . '\'); return false;">
                    <i class="bi bi-clipboard2-check"></i>
                </a>
               
            </div>
        </td>
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

            function copyToClipboard(url) {
                // استخدام API لنسخ النص إلى الحافظة
                navigator.clipboard.writeText(url).then(function() {
                    alert("تم نسخ الرابط إلى الحافظة!");
                }).catch(function(error) {
                    alert("حدث خطأ أثناء نسخ الرابط: " + error);
                });
            }
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