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
$search = '';

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$translations = [
    "lider" => "المدير",
    "admin" => "مشرف",
    "user" => "مستخدم"
];

$searchTranslated = array_search($search, $translations) ?: $search;

$sql = "SELECT * FROM users 
        WHERE users.user_number LIKE '%$search%' 
        OR users.user_name LIKE '%$search%' 
        OR users.role LIKE '%$searchTranslated%'
        ORDER BY 
            CASE 
                WHEN users.role = 'lider' THEN 1
                WHEN users.role = 'admin' THEN 2
                ELSE 3
            END,
            users.user_number DESC";






$rows = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
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
    <title>إضافة معلومات المشرفين</title>
    <style>
        /* توسيط النص في خلايا الجدول */
        #lessons-table th, #lessons-table td {
            text-align: center; /* توسيط أفقياً */
            vertical-align: middle; /* توسيط عمودياً */
        }
    </style>
</head>


<body>
    
    <!-- Navbar -->
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


    <form action="" method="get">
        <div class="container my-1">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <input class="form-control me-5" type="search" name="search" placeholder="أدخل كلمة البحث" aria-label="بحث" value="<?php echo $search; ?>">
                    <button class="btn btn-outline-success" style="color: #ae2754; border-color: #cf0c0c; margin-right: 10px;" type="submit">
                        بحث
                    </button>
                </div>
            </div>
            <!-- جعل الجدول قابلاً للتمرير -->
            <div class="table-responsive " style="overflow-x: auto;">
                <table id="lessons-table" class="table table-bordered table-striped" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="position: sticky; top: 0; z-index: 10;">#</th>
                            <th style="position: sticky; top: 0; z-index: 10;">المستخدم</th>
                            <th style="position: sticky; top: 0; z-index: 10;">رقمه في المؤسسة</th>
                            <th style="position: sticky; top: 0; z-index: 10;">كلمة المرور</th>
                            <th style="position: sticky; top: 0; z-index: 10;">رقم هاتفه</th>
                            <th style="position: sticky; top: 0; z-index: 10;">صلاحيته</th>
                            <th style="position: sticky; top: 0; z-index: 10;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($rows->num_rows > 0) {
                            while ($row = $rows->fetch_assoc()) {
                                echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['user_name'] . '</td>
                        <td>' . $row['user_number'] . '</td>
                        <td>' . $row['password'] . '</td>
                        <td>' . $row['phone_number'] . '</td>
                        <td>' . $translations[$row['role']] . '</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 align-items-center">
                                <a class="btn py-2 btn-primary update" href="update_users.php?id=' . $row['id'] . '" onclick="return confirmEdit();">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="btn py-2 btn-danger" href="delet_users.php?id=' . $row['id'] . '" onclick="return confirmDelete();">
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
          <td colspan="7">لا توجد بيانات</td>
        </tr>
        ';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>



    </div>
    <script>
        function confirmDelete() {
            return confirm('هل أنت متأكد أنك تريد حذف هذا العنصر؟');
        }

        function confirmEdit() {
            return confirm("هل أنت متأكد أنك تريد تعديل البيانات؟");
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