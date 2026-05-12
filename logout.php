<?php
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 1. البحث في جدول المدراء (admins)
    $admin_sql = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $admin_result = mysqli_query($conn, $admin_sql);

    // 2. البحث في جدول المستخدمين (users)
    $user_sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $user_result = mysqli_query($conn, $user_sql);

    if (mysqli_num_rows($admin_result) == 1) {
        $admin_data = mysqli_fetch_assoc($admin_result);
        $_SESSION['admin_id'] = $admin_data['id'];
        $_SESSION['username'] = $admin_data['username'];
        
        echo "<script>alert('مرحباً بك أيها المسؤول'); window.location.href='admin.php';</script>";
    } 
    elseif (mysqli_num_rows($user_result) == 1) {
        $user_data = mysqli_fetch_assoc($user_result);
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];

        echo "<script>alert('تم تسجيل الدخول بنجاح'); window.location.href='user.php';</script>";
    } 
    else {
        echo "<script>alert('خطأ: البريد الإلكتروني أو كلمة المرور غير صحيحة');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - رقيب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #050a1a;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            overflow: hidden;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.05);
            padding: 45px;
            border-radius: 25px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
        }

        .logo-text {
            color: #4ea8ff;
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(78, 168, 255, 0.3);
        }

        p { color: #aaa; margin-bottom: 35px; font-size: 0.95rem; }

        form { display: flex; flex-direction: column; gap: 15px; }

        input {
            width: 100%;
            padding: 15px 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.07);
            color: white;
            font-family: 'Cairo', sans-serif;
            outline: none;
            transition: 0.3s ease;
        }

        input:focus {
            border-color: #4ea8ff;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 15px rgba(78, 168, 255, 0.2);
        }

        button {
            width: 100%;
            padding: 14px;
            border-radius: 50px;
            border: none;
            background: linear-gradient(45deg, #4ea8ff, #3a8ee6);
            color: #050a1a;
            font-weight: 900;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.4s;
            margin-top: 15px;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(78, 168, 255, 0.5);
        }

        .footer-links {
            margin-top: 30px;
            font-size: 0.9rem;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-links a {
            color: #4ea8ff;
            text-decoration: none;
            font-weight: 700;
        }

        .back-home {
            display: block;
            margin-top: 15px;
            color: #666 !important;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2 class="logo-text">رقيب</h2>
        <p>سجل دخولك للوصول إلى النظام</p>
        
        <form method="POST" action="">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول النظام</button>
        </form>

        <div class="footer-links">
            <div>ليس لديك حساب؟ <a href="signup.php">سجل الآن</a></div>
            <a href="index.html" class="back-home">← العودة للرئيسية</a>
        </div>
    </div>

</body>
</html>