<?php

echo "dfe";

?>



<?php
include('conn.php');
session_start();

$error_massage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_number = trim($_POST['user_number']);
    $password = trim($_POST['password']);

    if (empty($user_number) || empty($password)) {
        $error_massage = "يجب تعبئة جميع الحقول";
    } else {
        $sql = "SELECT * FROM users WHERE user_number = '$user_number' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_number'] = $row['user_number'];
            if ($row['role'] == 'user') {
                $_SESSION['role'] = 'user';
                header("Location: user_page.php");
                exit;
            } elseif ($row['role'] == 'admin') {
                $_SESSION['role'] = 'admin';
                header("Location: admin_page.php");
                exit;
            }elseif ($row['role'] == 'lider') {
                $_SESSION['role'] = 'lider';
                header("Location: lider_page.php");
                exit;
            }
        } else {
            $error_massage = "اسم المستخدم او كلمة المرور غير صحيحة";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نموذج تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap"
        rel="stylesheet" />
    <style>
        body {
            background: url(background-craete.webp) 50% 50% / cover no-repeat;
            font-family: 'Noto Kufi Arabic', serif;
            height: 100vh;
            margin: 0;
            padding: 0;
            direction: rtl;
            overflow: hidden;
        }

        body::after {
            content: '';
            width: 100%;
            height: 100%;
            background-color: #ffffff20;
            filter: blur(5px);
            z-index: 1;
            top: 0;
            left: 0;
        }


        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 400px;
            padding: 20px 20px 5px 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: right;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
            color: rgb(0, 0, 0);
            font-weight: bold;
        }

        label {
            display: block;
            margin-bottom: 5px;
            margin-right: 20px;
        }

        input[type="text"],
        input[type="password"] {
            display: block;
            box-sizing: border-box;
            font-size: 16px;
            height: 40px;
            outline: none;
            font-family: 'Noto Kufi Arabic', serif;
            margin: 0 auto 15px;
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: right;
        }

        button {
            width: 80%;
            padding: 8px;
            background-color:  #2c3e50;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            display: block;
            margin: 10px auto;
            /* margin-top: -6px; */
        }


        button:hover {
            background-color: #0056b3;
        }

        input::placeholder {
            color: #888;
            opacity: 0.7;
            text-indent: 14px;
        }

        .error {
            color: red;
            margin-right: 20px;
            padding-bottom: 7px;
            font-size: smaller;


        }

        .href {
            text-decoration: none;
            margin-right: 17px;
            display: block;
            margin-bottom: 1px;
            margin-top: -4px;
        }

        .centered-link {
            text-decoration: none;
            display: block;
            text-align: center;
            margin: 6px 6px 6px;
            /* تقليل المسافة من الأسفل إلى 2px */
            color: red;
            font-weight: bold;

        }

        .centered-link:hover {
            color: rgb(54, 190, 161);
            text-decoration: underline;
        }

        .centered-link_1 {
            text-decoration: none;
            display: block;
            text-align: center;
            margin: 6px 6px 6px;
            color: rgb(24, 108, 156);
            font-weight: bold;

        }

        .centered-link_1:hover {
            color: rgb(54, 190, 161);
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1> تسجيل الدخول </h1>
        <form action="" method="POST" autocomplete="off">
            <div>

            </div>
            <label for="user_number"> رقمك في المؤسسة : </label>
            <div class="error">
                <?php
                if (isset($error_massage)) echo $error_massage;
                ?>
            </div>
            <input type="text" id="user_number" name="user_number" placeholder="رقمك في المؤسسة " required>

            <label for="password"> كلمة المرور:</label>

            <input type="password" id="password" name="password" placeholder="كلمة المرور " required>

            <button type="submit">تسجيل الدخول</button>
            <a href="create_account.php" class="centered-link_1">إنشاء حساب جديد</a>
            <a href="index.php" class="centered-link">نسيت كلمة المرور</a>

        </form>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-Q6T9PpcMuRYcBOYeQ7WpdQJwNcSwwtbmsyGe6CF5JsFecJXx7HC36p6PImqM6YOE" crossorigin="anonymous"></script>

</html>