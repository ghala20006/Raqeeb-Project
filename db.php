header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $message = $_POST['message'] ?? '';
    $user_id = 1;

    $stmt = mysqli_prepare($conn, 
        "INSERT INTO alerts (user_id, type, message, created_at) 
         VALUES (?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "iss", $user_id, $type, $message);
    mysqli_stmt_execute($stmt);

    echo json_encode(['status' => 'success', 'message' => 'تم حفظ التنبيه']);
} else {
    echo json<?php
_encode(['status' => 'error', 'message' => 'طلب غير صحيح']);
}
?>