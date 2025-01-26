<?php
include('../conn/conn.php');
session_start();
if (!isset($_SESSION['user_number']) || $_SESSION['role'] !== 'lider') {
    header('Location: ../index.php');
    exit;
}
$user_number = $_SESSION['user_number'];

$query = "SELECT user_name, user_number FROM users WHERE role = 'admin'";
$rows_1 = $conn->query($query);


$update_id =  $_GET['id'];
$update_query = "SELECT * FROM url_data WHERE id = $update_id";

$select_datas = mysqli_query($conn, $update_query);
$data_select = mysqli_fetch_array($select_datas);

if (isset($_POST['url_update'])) {
    if (!empty($_POST['url_title']) && !empty($_POST['url']) && !empty($_POST['link_type'])) {
        $url_title = $_POST['url_title'];
        $url = $_POST['url'];
        $link_type = $_POST['link_type'];
        $admin_url = $_POST['admin_url'];
        $note= $_POST['note'];

        $update_data = "UPDATE url_data SET
                     url_title= '$url_title',
                     url= '$url',
                     link_type= '$link_type',
                     admin_url= '$admin_url',
                     note = '$note'
                    where id = $update_id";

        mysqli_query($conn, $update_data);
        $conn->close();

        header('location: users_url.php');
        exit();
    }
    else {
        $error_message = "يجب تعبئة جميع الحقول";
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

                        <h1 class="h5 fw-bold mb-1"> تعديل الروابط </h1>
                    </div>
                    <form action="" method="POST">
                        <div class="p-4">
                            <div class="info-card">
                                <div class="info-label">
                                    <i data-lucide="user" class="icon"></i>
                                    عنوان الرابط
                                </div>
                                <input class="form-control" type="text" name="url_title" value="<?php echo $data_select['url_title'];?>" required>
                            </div>

                            <div class="info-card">
                                <div class="info-label">
                                    <i data-lucide="user" class="icon"></i>
                                    الرابط
                                </div>
                                <input class="form-control" type="text" name="url" value="<?php echo $data_select['url']; ?>" required>
                            </div>

                            <div class="info-card">
                                <label for="link_type">نوع الرابط:</label>
                                <select class="form-control" id="link_type" name="link_type" required>
                                    <option value="" disabled selected>الرجاء اختيار نوع الرابط مرة أخرى</option>
                                    <option value="عام">عام</option>
                                    <option value="خاص">خاص</option>
                                </select>
                            </div>

                            <div class="info-card" id="admin_field" style="display: none;">
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

                            <div class="info-card">
                                <div class="info-label">
                                    <i data-lucide="key" class="icon"></i>
                                    ملاحظات
                                </div>
                                <input class="form-control" type="text" name="note" value="<?php echo $data_select['note']; ?>">
                            </div>

                            <div class="text-center mt-4">
                                <input type="submit" name="url_update" class="edit-button" value="تعديل البيانات">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>

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
</body>

</html>