<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رقيب | حارس السيارة الذكية</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Reem+Kufi:wght@700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body, html {
            width: 100%; height: 100%;
            font-family: 'Cairo', sans-serif;
            background-color: #050a1a; 
            overflow: hidden; 
        }

        .hero {
            position: relative;
            width: 100%; height: 100vh;
            background-image: url('img.jpg'); 
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: flex-start; 
            align-items: center;
            padding-right: 8%; 
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to left, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 100%);
            z-index: 1;
        }

     
        .topbar {
            position: absolute;
            top: 0; width: 100%;
            padding: 25px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .header-logo-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .brand-name-white-small {
            font-family: 'Reem Kufi', sans-serif;
            color: #4ea8ff; 
            font-size: 1.4rem; /* تصغير الحجم */
            opacity: 0.9;
        }

        .header-tagline-micro {
            color: rgba(255, 255, 255, 0.7); 
            font-size: 0.75rem; /* أصغر جداً */
            font-weight: 400;
            margin-top: 6px;
        }

      
        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 900px;
            text-align: right;
            margin-top: -200px; 
        }

        .main-logo-blue {
            font-family: 'Cairo', sans-serif; 
            font-size: 5rem;
            color: #ffffff; 
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 20px;
            text-shadow: 0 0 30px rgba(78, 168, 255, 0.3);
        }

        
        .hero-content p {
            font-size: 1.2rem; 
            line-height: 1.6;
            color: #ffffff; 
            margin-bottom: 45px;
            max-width: 750px;
            font-weight: 600; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .btn-container {
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 14px 45px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.4s;
        }

        .btn-primary {
            background-color: #4ea8ff;
            color: #050a1a;
            border: 2px solid #4ea8ff;
        }

        .btn-primary:hover {
            background: transparent;
            color: #4ea8ff;
        }

        .btn-secondary {
            border: 2px solid white;
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="header-logo-group">
            <span class="brand-name-white-small">رقيب</span>
            <span class="header-tagline-micro">| حارس السيارة الذكية</span>
        </div>

        <nav style="display: flex; gap: 30px;">
            <a href="login.php" style="color:white; text-decoration:none; font-weight:700;">تسجيل الدخول</a>
            <a href="signup.php" style="color:white; text-decoration:none; font-weight:700;">إنشاء حساب</a>
        </nav>
    </header>

    <main class="hero">
        <div class="hero-overlay"></div>
        
        <section class="hero-content">
            <h1 class="main-logo-blue">رقيب</h1>
            
            <p>
                نظام متطور يعتمد على تقنيات الرؤية الحاسوبية والذكاء الاصطناعي لمراقبة السائق بذكاء، 
                لضمان أعلى مستويات الأمان على الطريق.
            </p>
            
            <div class="btn-container">
                <a href="login.php" class="btn btn-primary">ابدأ الآن</a>
                <a href="signup.php" class="btn btn-secondary">إنشاء حساب</a>
            </div>
        </section>
    </main>

</body>
</html>