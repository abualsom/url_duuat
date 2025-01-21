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


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <title>إضافة معلومات الدروس</title>
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --hover-color: aqua;
            --text-color: white;
            --border-color: #ddd;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Kufi Arabic', serif;

            background-color: #f5f5f5;
            margin: 0px 2px 8px;
            padding: 20px;
            direction: rtl;
            text-align: start;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        

        h2 {
            font-size: 25px;
            display: block;
            height: 55px;
            border-radius: 9px;
            background-color: rgb(11, 153, 141);
            color: rgb(255, 255, 255);
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            line-height: 55px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button {
            padding: 10px 20px;
            background-color: rgb(11, 153, 141);
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        th,
        td {
            text-align: center;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: rgb(11, 153, 141);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: rgba(11, 153, 141, 0.1);
        }

        thead th {
            position: sticky;
            top: 0;
            /* تثبيته في أعلى الجدول */
            z-index: 10;
            /* ضمان ظهور الصف فوق المحتوى */
            background-color: rgb(11, 153, 141);
            /* خلفية للرؤوس */
            color: white;
            /* لون النص */
            border: 1px solid #ddd;
        }



        .update {
            margin: 3px;
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


        .get_serch,
        .get_location {
            text-decoration: none;
            color: rgb(11, 153, 141);
            display: block;
            text-align: center;
            margin-top: 15px;
            font-weight: 600;
            letter-spacing: -1px;
            word-spacing: -0.10cap;
        }

        .select2-selection.select2-selection--single,
        .select2-selection__rendered,
        .select2-selection__arrow {
            height: 48px !important;
        }

        .select2-selection__rendered,
        .select2-selection__arrow {
            line-height: 48px !important;
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
                    <i class="bi bi-speedometer2 ms-2"></i>
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

</div>


    <div class="container">
        <h2>إضافة معلومات الدروس</h2>

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
        </form>

        <div class="overflow-auto w-100" style="height: 400px;">
            <table id="lessons-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="position: sticky; top: 0; z-index: 10;">#</th>
                        <th style="position: sticky; top: 0; z-index: 10;">عنوان الرابط</th>
                        <th style="position: sticky; top: 0; z-index: 10;">الرابط</th>
                        <th style="position: sticky; top: 0; z-index: 10;">المشرف</th>
                        <th style="position: sticky; top: 0; z-index: 10;">الإجراءات</th>
                        <th style="position: sticky; top: 0; z-index: 10;">الملاحظات</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($rows->num_rows > 0) {
                        while ($row = $rows->fetch_assoc()) {
                            echo '
              <tr>
                  <td>' . $row['ders_tame'] . '</td>
                  <td>' . $row['ders_konu'] . '</td>
                  <td>' . $row['book'] . '</td>
                  <td>' . $row['teacher'] . '</td>
                  <td class="notes_1"> ' . $row['notes'] . '</td>
                  <td>
                      <div class="d-flex justify-content-center gap-2 align-items-center">
                          <a class="btn py-2 btn-primary update" href="update.php?id=' . $row['id'] . '">
                              <i class="bi bi-pencil-square"></i>
                          </a>
                          <a class="btn py-2 btn-danger" href="delet.php?id=' . $row['id'] . '" onclick="return confirmDelete();">
                              <i class="bi bi-trash"></i>
                          </a>
                      </div>
                  </td>
              </tr>
              ';
                        }
                    } else {
                        echo '
            <tr>
              <td colspan="6">لا توجد بيانات</td>
            </tr>
            ';
                    } ?>
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

<?php
$conn->close();
?>