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



$conn->close();
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <link rel="stylesheet" href="style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
            <h6 class="profile-name"><?php echo $name; ?></h6>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="lider_page.php" class="sidebar-menu-link">
                    <i class="bi bi-house-door-fill"></i>
                    <span>الصفحة الرئيسية</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="lider_add.php" class="sidebar-menu-link">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>إضافة مشرف</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="lider_edit.php" class="sidebar-menu-link">
                    <i class="bi bi-pencil-square"></i>
                    <span>تعديل الرابط</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="margin-top: 30px">
        <form action="" method="POST">

            <div class="form-group">
                <label for="url_title">عنوان الرابط:</label>
                <input
                    type="text"
                    id="url_title"
                    placeholder="أدخل  عنوان الرابط"
                    name="url_title"
                    required />
            </div>
            <div class="form-group">
                <label for="url"> الرابط :</label>
                <input
                    type="url"
                    id="url"
                    placeholder="أدخل الرابط"
                    name="url"
                    required />
            </div>
            <div class="form-group">
                <label for="location">المشرف:</label>
                <select class="form-control select2" id="location" name="location" required>
                    <option value="" disabled selected>اختر المشرف</option>
                    <?php
                    if ($rows_1->num_rows > 0) {
                        while ($row_1 = $rows_1->fetch_assoc()) {
                            echo '<option value="' . $row_1['location_name'] . '">' . $row_1['location_name'] . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>لا يوجد مشرف</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="notes">الملاحظات:</label>
                <textarea
                    class="form-control"
                    id="notes"
                    placeholder="أدخل الملاحظات"
                    name="notes"
                    rows="6"
                    style="width: 100%"></textarea>
            </div>
            <div class="d-flex justify-content-center">
                <input
                    class="button btn btn-success"
                    type="submit"
                    name="submit"
                    value="إضافة البيانات" />
            </div>
        </form>

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