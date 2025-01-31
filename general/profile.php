<?php
include('../conn/conn.php');
session_start();
$user_number = $_SESSION['user_number'];

if (!isset($_SESSION['user_number'])) {
    header("Location: create_account.php");
    exit();
}

$user_query = "SELECT * FROM users WHERE user_number = $user_number";
$sql = mysqli_query($conn, $user_query);
$sql_query = mysqli_fetch_array($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['got_home'])) {
    if ($sql_query['role'] == 'user') {
        header("Location: ../user/user_page.php");
        exit();
    } elseif ($sql_query['role'] == 'admin') {
        header("Location: ../admin/admin_page.php");
        exit();
    } elseif ($sql_query['role'] == 'lider') {
        header("Location: ../lider/lider_page.php");
        exit();
    }
}

$translations = [
    "lider" => "المدير",
    "admin" => "مشرف",
    "user" => "مستخدم"
];

if (isset($_POST['edit_profile'])) {
    header("Location: edit_profile.php");
    exit();
}


$conn->close();

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    <!-- إضافة Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- إضافة الخط -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- إضافة Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            font-family: 'Noto Kufi Arabic', sans-serif !important;
        }

        .profile-header {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
        }

        .profile-avatar {
            width: 96px;
            height: 96px;
            margin: 0 auto;
            background-color: white;
            border-radius: 50%;
            padding: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .info-card {
            background-color: rgb(248, 250, 252);
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s;
        }

        .info-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }


        .edit-button:hover {
            background-color: #34495e;
        }

        .info-label {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .icon {
            color: #2c3e50;
        }

        .edit-button {
            background-color:#2c3e50;
            /* نفس لون الزر */
            color: white;
            /* لون النص */
            border: none;
            /* إزالة الحدود */
            padding: 10px 20px;
            /* مساحة داخلية */
            text-align: center;
            /* محاذاة النص في المنتصف */
            text-decoration: none;
            /* إزالة الخط السفلي */
            display: inline-block;
            /* العرض نفس inline-block */
            font-size: 16px;
            /* حجم النص */
            cursor: pointer;
            /* المؤشر يظهر كيد عند التمرير */
            border-radius: 5px;
            /* حواف مستديرة */
            transition: background-color 0.3s ease;
            /* تأثير الانتقال عند التمرير */
        }

        .edit-button:hover {
            background-color: #0056b3;
            /* لون أغمق عند التمرير */
        }

        .button-like {
            display: inline-block;
            /* لجعل العنصر مثل الزر */
        }

        @media (max-width: 576px) {
            .edit-button {

                margin-bottom: 5%;
            }

        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- رأس الصفحة مع الصورة -->
                    <div class="profile-header">
                        <div class="profile-avatar mb-2">
                            <svg class="w-100 h-100 text-secondary" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 14.25c3.97 0 7.19 2.795 7.19 6.25H4.81c0-3.455 3.22-6.25 7.19-6.25zM12 13a4.5 4.5 0 110-9 4.5 4.5 0 010 9z" />
                            </svg>
                        </div>
                        <h1 class="h5 fw-bold mb-1">الملف الشخصي</h1>
                    </div>

                    <!-- معلومات المستخدم -->
                    <div class="p-4">
                        <div class="info-card">
                            <div class="info-label">
                                <i data-lucide="user" class="icon"></i>
                                الاسم الكامل
                            </div>
                            <p class="h5 mb-0 pe-7"><?php echo $sql_query['user_name']; ?></p>
                        </div>

                        <div class="info-card">
                            <div class="info-label">
                                <i data-lucide="building" class="icon"></i>
                                رقمك في المؤسسة
                            </div>
                            <p class="h5 mb-0 pe-7"><?php echo $sql_query['user_number']; ?></p>
                        </div>

                        <div class="info-card">
                            <div class="info-label">
                                <i data-lucide="building" class="icon"></i>
                                الصلاحية
                            </div>
                            <p class="h5 mb-0 pe-7"><?php echo  $translations[$sql_query['role']]; ?></p>
                        </div>

                        <div class="info-card">
                            <div class="info-label">
                                <i data-lucide="phone" class="icon"></i>
                                رقم الجوال
                            </div>
                            <p class="h5 mb-0 pe-7"><?php echo $sql_query['phone_number']; ?></p>
                        </div>

                        <div class="info-card">
                            <div class="info-label">
                                <i data-lucide="key" class="icon"></i>
                                كلمة المرور
                            </div>
                            <p class="h5 mb-0 pe-7"><?php echo $sql_query['password']; ?></p>
                        </div>
                        <form action="" method="post">
                            <!-- زر تعديل الملف الشخصي -->
                            <div class="text-center mt-4">
                                <a name="edit_profile" href="edit_profile.php?id=<?php echo $sql_query['id']; ?>" class="edit-button button-like">
                                    تعديل المعلومات
                                </a>

                                <button name='got_home' class="edit-button">
                                    الرجوع للصفحة الرئيسية
                                </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- تهيئة Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>