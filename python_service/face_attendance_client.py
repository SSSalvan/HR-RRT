"""
Smart Attendance Vision Client (Kamera Presensi AI)
Terintegrasi langsung dengan Laravel HR-RRT Backend API.

Dapat dihubungkan ke:
- Webcam kantor / Laptop
- IP Camera / CCTV RTSP stream (HikVision, Dahua, dll)
- Edge device (Raspberry Pi / Jetson Nano)
"""

import cv2
import requests
import base64
import time
from datetime import datetime

# Konfigurasi Backend Laravel
LARAVEL_API_URL = "http://127.0.0.1:8000/api/attendance/check-in"

def encode_frame_to_base64(frame):
    """Mengubah frame OpenCV menjadi base64 JPEG"""
    _, buffer = cv2.imencode('.jpg', frame, [cv2.IMWRITE_JPEG_QUALITY, 85])
    return base64.b64encode(buffer).decode('utf-8')

def send_attendance_to_laravel(nik, attendance_type="in", frame=None):
    """Mengirim data presensi dan snapshot wajah ke Laravel"""
    payload = {
        "nik": nik,
        "type": attendance_type,
        "time": datetime.now().strftime("%H:%M:%S")
    }

    if frame is not None:
        payload["image"] = f"data:image/jpeg;base64,{encode_frame_to_base64(frame)}"

    try:
        response = requests.post(LARAVEL_API_URL, json=payload, timeout=5)
        result = response.json()
        if response.status_code == 200 and result.get("success"):
            print(f"✅ [SUCCESS] {result.get('message')}")
            return True
        else:
            print(f"⚠️ [WARNING] {result.get('message')}")
            return False
    except requests.exceptions.RequestException as e:
        print(f"❌ [ERROR] Gagal menghubungi server Laravel: {e}")
        return False

def run_camera_stream():
    """Menjalankan kamera live preview dengan panduan scan wajah"""
    print("=" * 60)
    print("   SMART VISION ATTENDANCE CLIENT (HR-RRT)")
    print("   Tekan 'I' untuk Presensi Masuk (Clock-In)")
    print("   Tekan 'O' untuk Presensi Pulang (Clock-Out)")
    print("   Tekan 'Q' untuk Keluar")
    print("=" * 60)

    cap = cv2.VideoCapture(0) # 0 untuk default webcam, atau masukkan URL RTSP HikVision

    if not cap.isOpened():
        print("❌ Kamera tidak dapat diakses.")
        return

    while True:
        ret, frame = cap.read()
        if not ret:
            break

        # Mirror frame agar terlihat natural
        display_frame = cv2.flip(frame, 1)
        h, w, _ = display_frame.shape

        # Gambar kotak pemandu wajah di tengah
        cv2.ellipse(display_frame, (w // 2, h // 2), (120, 160), 0, 0, 360, (0, 255, 0), 2)
        cv2.putText(display_frame, "Posisikan Wajah di Dalam Garis", (w // 2 - 140, h // 2 - 180),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)

        # Jam real-time di layar
        current_time = datetime.now().strftime("%H:%M:%S WIB")
        cv2.putText(display_frame, current_time, (20, 40),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.8, (255, 255, 255), 2)

        cv2.imshow("Smart Attendance Camera - HR-RRT", display_frame)

        key = cv2.waitKey(1) & 0xFF
        if key == ord('q'):
            break
        elif key == ord('i') or key == ord('I'):
            nik = input("\nMasukkan NIK Karyawan (contoh: EMP001): ").strip()
            if nik:
                print(f"Memproses Presensi Masuk untuk NIK: {nik}...")
                send_attendance_to_laravel(nik, "in", frame)
        elif key == ord('o') or key == ord('O'):
            nik = input("\nMasukkan NIK Karyawan (contoh: EMP001): ").strip()
            if nik:
                print(f"Memproses Presensi Pulang untuk NIK: {nik}...")
                send_attendance_to_laravel(nik, "out", frame)

    cap.release()
    cv2.destroyAllWindows()

if __name__ == "__main__":
    run_camera_stream()
