<?php
include('../conn/conn.php');
session_start();
if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'lider') {
    header('Location: ../index.php');
    exit;
}

$user_number = $_SESSION['user_number'];

$sql_name = "SELECT user_name FROM users WHERE user_number = '$user_number'";
$sql_query = mysqli_query($conn, $sql_name);

if ($sql_query) {
    $row = mysqli_fetch_assoc($sql_query);
    $user_name = $row['user_name'];
}
$query = "SELECT user_name, user_number FROM users WHERE role = 'admin'";
$rows_1 = $conn->query($query);

if (!$rows_1) {
    die("خطأ في الاستعلام: " . $conn->error);
}

$url_sql = 'INSERT INTO url_data (url, url_title, admin_url, note, link_type) VALUES (?, ?, ?, ?, ?)';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url'];
    $url_title = $_POST['url_title'];
    $link_type = $_POST['link_type'];
    $admin_url = isset($_POST['admin_url']) ? $_POST['admin_url'] : null;
    $note = $_POST['note'];

    if ($stmt = $conn->prepare($url_sql)) {
        $stmt->bind_param("sssss", $url, $url_title, $admin_url, $note, $link_type);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "تمت إضافة البيانات بنجاح!";
        } else {
            $_SESSION['error_message'] = "حدث خطأ أثناء الإضافة: " . $stmt->error;
        }

        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "خطأ في إعداد الاستعلام: " . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة معلومات المشرفين</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" href="../heder-icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        body,
        html {
            height: 100%;
            padding-bottom: 10px;
        }

        .btn_submit {
            background-color: #2c3e50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .btn_submit:hover {
            background-color: rgb(17, 118, 119);
            color: #fff;
        }
        .container {
            max-width: 700px;
            margin: 15px auto;
            padding: 15px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            text-align: right;
            padding-right: 10px;
        }

        .select2-container {
            width: 100% !important;
        }

        #message-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            max-width: 400px;
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
                <a class="nav-link d-flex align-items-center" href="../general/profile.php">
                    <i class="bi bi-person "  style="font-size: x-large; margin: 0 0 0 8px;"></i>
                    <span>                   

                   الملف الشخصي
                   </span>   

                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="bi bi-people-fill ms-2" style="font-size: x-large; margin: 0 0 0 8px;"></i>
                    <span>                   
                المستخدمين

                </span>   
            </a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users_url.php">
                    <i class="bi bi-people-fill ms-2 " style="font-size: x-large; margin: 0 0 0 8px;"></i>
                    <span>                   
                    روابط المستخدمين
                    </span>   

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="links.php">
                    <i class="bi bi-link-45deg ms-2" style="font-size: x-large; margin: 0 0 0 8px;"></i>
                    <span>                   

                    إضافة الروابط
                    </span>   

                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../general/logout.php">
                    <i class="bi bi-door-open-fill me-1"style="font-size: x-large; margin: 0 0 0 8px;" ></i>
                    <span class="m-none d-sm-inline">تسجيل الخروج</span>
                </a>
            </li>
        </ul>
    </div>


    <div id="message-container">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">'
                . htmlspecialchars($_SESSION['success_message']) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">'
                . htmlspecialchars($_SESSION['error_message']) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            unset($_SESSION['error_message']);
        }
        ?>
    </div>

    <div class="container">
        <h2 class="text-center mb-4">إضافة روابط الدروس</h2>

        <form action="" method="POST">
            <div class="form-group">
                <label for="url_title">عنوان الرابط:</label>
                <input type="text" class="form-control" id="url_title" placeholder="أدخل عنوان الرابط" name="url_title" required />
            </div>

            <div class="form-group">
                <label for="url">الرابط:</label>
                <input type="url" class="form-control" id="url" placeholder="أدخل الرابط" name="url" required />
            </div>

            <div class="form-group">
                <label for="link_type">نوع الرابط:</label>
                <select class="form-control" id="link_type" name="link_type" required>
                    <option value="" disabled selected>اختر نوع الرابط</option>
                    <option value="عام">عام</option>
                    <option value="خاص">خاص</option>
                </select>
            </div>

            <div class="form-group" id="admin_field" style="display: none;">
                <label for="admin_url">المشرف:</label>
                <select class="form-control select2" id="admin_url" name="admin_url">
                    <option value="" disabled selected>اختر المشرف</option>
                    <?php
                    if ($rows_1->num_rows > 0) {
                        while ($row_1 = $rows_1->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row_1['user_number']) . '">'
                                . htmlspecialchars($row_1['user_number']) . ' - '
                                . htmlspecialchars($row_1['user_name']) .
                                '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>لا يوجد مشرف</option>';
                    }
                    ?>
                </select>
            </div>


            <div class="form-group">
                <label for="note">الملاحظات:</label>
                <textarea class="form-control" id="note" placeholder="أدخل الملاحظات" name="note" rows="6"></textarea>
            </div>

            <div class="text-center">
                <button class="btn btn_submit"  type="submit" name="submit">إضافة البيانات</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const linkType = document.getElementById('link_type');
            const adminField = document.getElementById('admin_field');

            linkType.addEventListener('change', function() {
                if (this.value === 'خاص') {
                    adminField.style.display = 'block';
                    document.getElementById('admin_url').required = true;
                } else {
                    adminField.style.display = 'none';
                    document.getElementById('admin_url').required = false;
                }
            });
        });

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'اختر المشرف',
                allowClear: true,
                language: {
                    noResults: function() {
                        return "لم يتم العثور على نتائج";
                    },
                    searching: function() {
                        return "جار البحث...";
                    }
                }
            });

            setTimeout(function() {
                $(".alert").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 3000);
        });
    </script>
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