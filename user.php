<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_btn'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$pass')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('تم التسجيل بنجاح!'); window.location.href='login.php';</script>";
    } else {
        echo "خطأ: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب | رقيب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Cairo', sans-serif; 
            background-color: #050a1a; 
            color: white; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .card { 
            background: rgba(255, 255, 255, 0.05); 
            padding: 40px; 
            border-radius: 20px; 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            width: 380px; 
            text-align: center; 
            backdrop-filter: blur(10px); 
        }
        input { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 15px; 
            border-radius: 10px; 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            background: rgba(255, 255, 255, 0.05); 
            color: white; 
            box-sizing: border-box; 
            outline: none; 
        }
        input:focus { border-color: #4ea8ff; }
        .btn { 
            width: 100%; 
            padding: 12px; 
            border-radius: 50px; 
            border: none; 
            background: #4ea8ff; 
            color: #050a1a; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s; 
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(78, 168, 255, 0.3); 
        }
        .links-container { margin-top: 20px; font-size: 0.85rem; }
        .links-container a { color: #4ea8ff; text-decoration: none; display: block; margin-bottom: 10px; }
        .back-link { color: #666 !important; font-size: 0.75rem; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color: #4ea8ff; font-weight: 900; margin-bottom: 10px;">رقيب</h2>
        <p style="color: #ccc; margin-bottom: 25px;">إنشاء حساب جديد للمنظومة</p>
        
        <form method="POST">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit" name="signup_btn" class="btn">إنشاء الحساب</button>
        </form>

        <div class="links-container">
            <a href="login.php">لديك حساب بالفعل؟ <strong>سجل دخولك</strong></a>
            <a href="index.html" class="back-link">← العودة للرئيسية</a>
        </div>
    </div>
</body>
</html>