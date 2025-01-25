<?php
include('../conn/conn.php');
session_start();
$user_number = $_SESSION['user_number'];

if (!isset($_SESSION['user_number'])) {
    header("Location: create_account.php");
    exit();
}


$update_id = $_GET['id'];
$update_query = "SELECT * FROM users WHERE id = $update_id";

$select_datas = mysqli_query($conn, $update_query);
$data_select = mysqli_fetch_array($select_datas);

if (isset($_POST['edit_profile'])) {
    if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
        $user_name = $_POST['user_name'];
        $password = str_replace(' ' , '', $_POST['password']);
        $phone_number = str_replace(' ' , '', $_POST['phone_number']);


        $update_data = "UPDATE users SET 
                    user_name = '$user_name',
                    password = '$password', 
                    phone_number = '$phone_number'
                    where id = $update_id";

        mysqli_query($conn, $update_data);
        $conn->close();

        header('location: profile.php');
        exit();
    }
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

        .edit-button {
            background-color: #2c3e50;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            transition: background-color 0.2s;
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

        
    </style>
</head>

<body class="bg-light">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="profile-header">
                        <div class="profile-avatar mb-2">
                            <svg class="w-100 h-100 text-secondary" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 14.25c3.97 0 7.19 2.795 7.19 6.25H4.81c0-3.455 3.22-6.25 7.19-6.25zM12 13a4.5 4.5 0 110-9 4.5 4.5 0 010 9z" />
                            </svg>
                        </div>
                        <h1 class="h5 fw-bold mb-1">الملف الشخصي</h1>
                    </div>
                    <form action="" method="POST">
                        <div class="p-4">
                            <div class="info-card">
                                <div class="info-label">
                                    <i data-lucide="user" class="icon"></i>
                                    الاسم الكامل
                                </div>
                                <input class="form-control" type="text" name="user_name" value="<?php echo $data_select['user_name'];?>" required>
                            </div>

                            <div class="info-card">
                                <div class="info-label">
                                    <i data-lucide="building" class="icon"></i>
                                    رقمك في المؤسسة
                                </div>
                                <input class="form-control" type="text" name="user_number" value="<?php echo $data_select['user_number'];?> (ملاحظة: لا يمكنك تعديل رقمك؛ لأن ذلك يسبب أخطاء في الموقع)"  readonly>
                            </div>


                            <div class="info-card">
                                <div class="info-label">
                                    <i data-lucide="phone" class="icon"></i>
                                    رقم الجوال
                                </div>
                                <input class="form-control" type="text" name="phone_number" value="<?php echo $data_select['phone_number'];?> ">
                            </div>

                            <div class="info-card">
                                <div class="info-label">
                                    <i data-lucide="key" class="icon"></i>
                                    كلمة المرور
                                </div>
                                <input class="form-control" type="text" name="password" value="<?php echo $data_select['password'];?> " required>
                            </div>

                            <!-- زر تعديل الملف الشخصي -->
                            <div class="text-center mt-4">
                                <input type="submit" name="edit_profile" class="edit-button" value="تعديل البيانات">
                            </div>
                        </div>
                    </form>

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