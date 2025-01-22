<!DOCTYPE html>
<html lang="ar" dir="rtl">
<?php
include('conn.php');
session_start();
$error = "";
$errorpass = "";
$errornumber = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['user_number'])) {
        $name = $_POST['user_name'];
        $password = $_POST['password'];
        $user_number = $_POST['user_number'];

        if (empty($name)) {
            $error = "يرجى إدخال الاسم باللغة العربية";
        }
        if (empty($password)) {
            $errorpass = "يرجى إدخال كلمة المرور";
        }
        if (empty($user_number)) {
            $errornumber = "يرجى إدخال رقمكم بالمؤسسة بشكل صحيح";
        }

        if (empty($error) && empty($errorpass) && empty($errornumber)) {
            $check_sql = "SELECT * FROM users WHERE user_number = ?";
            $stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($stmt, 's', $user_number);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $errornumber = "رقم المستخدم مسجل مسبقًا. يرجى اختيار رقم آخر.";
            } else {
                $sql = "INSERT INTO users (user_name, password, user_number) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'sss', $name, $password, $user_number);
                $sql_query = mysqli_stmt_execute($stmt);

                if ($sql_query) {
                    $user_query = "SELECT * FROM users WHERE user_number = ?";
                    $stmt = mysqli_prepare($conn, $user_query);
                    mysqli_stmt_bind_param($stmt, 's', $user_number);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['user_number'] = $row['user_number'];
                        $_SESSION['user_name'] = $row['user_name'];  
                        $_SESSION['role'] = $row['role'] ?? 'user';  

                        header("Location: user_page.php");
                        exit;
                    }
                }
            }
        }
    }
}

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap"
        rel="stylesheet" />

    <title>نموذج تسجيل الدخول</title>
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
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            display: block;
            margin: 10px auto;
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
            color: red;
            font-weight: bold;

        }

        .centered-link:hover {
            color: rgb(54, 190, 161);
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1> إنشاء حساب جديد </h1>
        <form action="" method="POST" autocomplete="off">
            <label for="username">اختر اسم المستخدم : </label>
            <div class="error">
                <?php
                if ($error) echo $error;
                ?>
            </div>
            <input type="text" id="user_name" name="user_name" placeholder="اسم المستخدم" required>


            <label for="user_number">ادخل رقمك بالمؤسسة</label>
            <div class="error">
                <?php
                if ($errornumber) echo $errornumber;
                ?>
            </div>
            <input type="text" id="user_number" name="user_number" placeholder="رقمك بالمؤسسة " required>

            <label for="password">اختر كلمة المرور :</label>
            <div class="error">
                <?php if ($errorpass) echo $errorpass;  ?>
            </div>
            <input type="password" id="password" name="password" placeholder="كلمة المرور " required>

            <button type="submit" name="submit">انشاء الحساب </button>
            <a href="login.php" class="centered-link">لدي حساب بالفعل</a>

        </form>
    </div>
</body>

</html>