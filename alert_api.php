<?php
session_start();
include "db.php";

// 1. معالجة إضافة أدمن جديد
if (isset($_POST['add_admin'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $sql = "INSERT INTO admins (username, password) VALUES ('$user', '$pass')";
    mysqli_query($conn, $sql);
}

// 2. معالجة حذف مستخدم
if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    header("Location: admin.php");
}

// جلب البيانات
$users_res = mysqli_query($conn, "SELECT * FROM users");
$admins_res = mysqli_query($conn, "SELECT * FROM admins");
$locations_res = mysqli_query($conn, "SELECT latitude, longitude, created_at FROM locations ORDER BY id DESC LIMIT 10");

$map_points = [];
while($loc = mysqli_fetch_assoc($locations_res)) {
    $map_points[] = $loc;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة رقيب | لوحة التحكم الادمن</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Reem+Kufi:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        :root { 
            --accent: #4ea8ff; 
            --danger: #ff4e4e; 
            --dark-bg: #050a1a;
            --glass: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Cairo', sans-serif; 
            background-color: var(--dark-bg); 
            color: white; 
            margin: 0; 
        }

        /* شريط علوي */
        .navbar { 
            display: flex; justify-content: space-between; align-items: center; 
            padding: 15px 40px; background: rgba(255,255,255,0.03); 
            backdrop-filter: blur(10px); border-bottom: 1px solid var(--glass-border);
        }
        
        .logo { font-family: 'Reem Kufi', sans-serif; font-size: 1.8rem; color: var(--accent); text-shadow: 0 0 15px rgba(78, 168, 255, 0.4); }

        .container { padding: 30px; max-width: 1300px; margin: 0 auto; }

        .dashboard-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; }

        /* الكروت الزجاجية */
        .glass-card { 
            background: var(--glass); 
            padding: 25px; 
            border-radius: 20px; 
            border: 1px solid var(--glass-border); 
            margin-bottom: 20px;
        }

        h3 { margin-bottom: 20px; color: var(--accent); display: flex; align-items: center; gap: 10px; }

        /* الخريطة */
        #map { height: 400px; border-radius: 15px; border: none; filter: invert(90%) hue-rotate(180deg); }

        /* الجداول */
        table { width: 100%; border-collapse: collapse; }
        th { text-align: right; padding: 12px; color: #666; font-size: 0.8rem; border-bottom: 1px solid var(--glass-border); }
        td { padding: 15px 12px; border-bottom: 1px solid var(--glass-border); }

        .delete-btn { color: var(--danger); text-decoration: none; font-size: 1.1rem; transition: 0.3s; }
        .delete-btn:hover { text-shadow: 0 0 10px var(--danger); }

        /* الفورم */
        .glass-input {
            width: 100%; padding: 12px; margin-bottom: 15px;
            background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border);
            border-radius: 10px; color: white; outline: none; font-family: 'Cairo';
        }
        .glass-input:focus { border-color: var(--accent); }

        .submit-btn {
            width: 100%; padding: 13px; border-radius: 50px; border: none;
            background: var(--accent); color: #050a1a; font-weight: bold; cursor: pointer;
        }

        .admin-item {
            background: rgba(255,255,255,0.02); padding: 10px; border-radius: 10px;
            margin-top: 10px; display: flex; justify-content: space-between; border-right: 3px solid var(--accent);
        }

        .status-dot { height: 10px; width: 10px; background: #2ecc71; border-radius: 50%; display: inline-block; margin-left: 5px; box-shadow: 0 0 8px #2ecc71; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">رقيب <span style="font-size: 1rem; color: #666; font-family: 'Cairo';">| لوحة الإدارة</span></div>
        <div style="display: flex; align-items: center; gap: 20px;">
            <span style="font-size: 0.8rem; color: #aaa;"><span class="status-dot"></span> النظام متصل</span>
            <a href="logout.php" style="color: var(--danger); text-decoration: none; font-size: 0.9rem; font-weight: bold;">خروج</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="glass-card">
            <h3><i class="fa-solid fa-map-location-dot"></i> تتبع المركبات المباشر</h3>
            <div id="map"></div>
        </div>

        <div class="dashboard-grid">
            <div class="glass-card">
                <h3><i class="fa-solid fa-users-gear"></i> إدارة المستخدمين</h3>
                <table>
                    <thead>
                        <tr>
                            <th>المستخدم</th>
                            <th>البريد الإلكتروني</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($u = mysqli_fetch_assoc($users_res)): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($u['username']) ?></strong></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <a href="?delete_user=<?= $u['id'] ?>" onclick="return confirm('حذف هذا العميل نهائياً؟')" class="delete-btn">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="glass-card">
                <h3><i class="fa-solid fa-shield-plus"></i> إضافة مسؤول</h3>
                <form method="POST">
                    <input type="text" name="username" placeholder="اسم الأدمن الجديد" class="glass-input" required>
                    <input type="password" name="password" placeholder="كلمة المرور" class="glass-input" required>
                    <button type="submit" name="add_admin" class="submit-btn">تفعيل الحساب</button>
                </form>

                <h4 style="margin-top: 30px; font-size: 0.8rem; color: #666; margin-bottom: 10px;">المدراء الحاليين:</h4>
                <?php while($adm = mysqli_fetch_assoc($admins_res)): ?>
                    <div class="admin-item">
                        <span><i class="fa-solid fa-user-shield" style="color:var(--accent); font-size: 0.8rem;"></i> <?= htmlspecialchars($adm['username']) ?></span>
                        <span style="color: #444; font-size: 0.7rem;">ID: #<?= $adm['id'] ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script>
        // إعداد الخريطة بالستايل المظلم
        var map = L.map('map').setView([24.7136, 46.6753], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var points = <?= json_encode($map_points) ?>;
        points.forEach(function(p) {
            L.marker([p.latitude, p.longitude]).addTo(map)
             .bindPopup("آخر ظهور: " + p.created_at);
        });
    </script>
</body>
</html>