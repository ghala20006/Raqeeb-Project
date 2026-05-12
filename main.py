from fastapi import FastAPI
from contextlib import asynccontextmanager
from ultralytics import YOLO
import cv2
import mysql.connector
import threading
import time

# ==================== إعدادات ====================
CAMERA_URL = "http://172.20.10.4:81/stream"
DB_CONFIG = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "raqeeb"
}

# ==================================================

model = YOLO("best.pt")

CLASS_NAMES = {
    0: "Drowsy",
    1: "Awake"
}

latest_status = {
    "driver_status": "Unknown",
    "confidence": 0.0,
    "last_alert": None
}

def save_alert(status):
    if status != "Drowsy":
        return
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        cursor = conn.cursor()
        cursor.execute(
            """INSERT INTO alerts 
            (vehicle_id, user_id, alert_type, alert_message, latitude, longitude)
            VALUES (%s, %s, %s, %s, %s, %s)""",
            (1, 5, "Drowsiness", "Driver is drowsy", None, None)
        )
        conn.commit()
        cursor.close()
        conn.close()
        print("✅ Alert saved to DB")
    except Exception as e:
        print(f"❌ DB Error: {e}")

def analyze_camera():
    global latest_status
    last_alert_time = 0

    while True:
        # ✅ إعادة الاتصال إذا انقطعت الكاميرا
        print("📷 جاري الاتصال بالكاميرا...")
        cap = cv2.VideoCapture(CAMERA_URL)

        if not cap.isOpened():
            print("⚠️ فشل الاتصال، إعادة المحاولة بعد 3 ثواني...")
            time.sleep(3)
            continue

        print("✅ متصل بالكاميرا")

        while True:
            ret, frame = cap.read()

            if not ret:
                print("⚠️ انقطع البث، إعادة الاتصال...")
                cap.release()
                break  # يرجع للحلقة الخارجية ويعيد الاتصال

            results = model(frame, verbose=False)
            detected_status = "Awake"
            confidence = 0.0

            for result in results:
                for box in result.boxes:
                    class_id = int(box.cls[0])
                    confidence = float(box.conf[0])
                    label = CLASS_NAMES.get(class_id, "Unknown")
                    if label == "Drowsy":
                        detected_status = "Drowsy"
                        break

            latest_status["driver_status"] = detected_status
            latest_status["confidence"] = round(confidence, 4)

            if detected_status == "Drowsy":
                current_time = time.time()
                if current_time - last_alert_time > 10:
                   save_alert(detected_status)
                   latest_status["last_alert"] = "Drowsy alert saved"
                   last_alert_time = current_time
                   print("🚨 السائق نايم!")
            else:
                print("✅ السائق صاحي")  # يطبع صاحي بس ما يخزن

            time.sleep(0.2)

# ✅ الطريقة الحديثة بدل on_event
@asynccontextmanager
async def lifespan(app: FastAPI):
    thread = threading.Thread(target=analyze_camera, daemon=True)
    thread.start()
    print("🚀 السيرفر شغّال")
    yield

app = FastAPI(lifespan=lifespan)

@app.get("/")
def home():
    return {"message": "Raqeeb AI Server is running ✅"}

@app.get("/status")
def get_status():
    return latest_status