import paho.mqtt.client as mqtt
import mysql.connector
import json
from datetime import datetime

DB_HOST = "127.0.0.1"
DB_PORT = 3307
DB_USER = "root"
DB_PASS = ""
DB_NAME = "db_magang_mqtt"

def simpan_ke_database(suhu):
    try:
        conn = mysql.connector.connect(
            host=DB_HOST, 
            port=DB_PORT,
            user=DB_USER, 
            password=DB_PASS, 
            database=DB_NAME
        )
        cursor = conn.cursor()
        sekarang = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        
        # ruang buat logicnya/algo/AI nya
        # ml
        # ------------------------------------------------
        
        sql = "INSERT INTO sensor_logs (suhu, created_at, updated_at) VALUES (%s, %s, %s)"
        cursor.execute(sql, (suhu, sekarang, sekarang))
        conn.commit()
        
        print(f"[{sekarang}] Berhasil disimpan ke DB -> Suhu: {suhu}°C")
        
    except mysql.connector.Error as err:
        print(f"Error Database: {err}")
    finally:
        if 'conn' in locals() and conn.is_connected():
            cursor.close()
            conn.close()

def on_message(client, userdata, msg):
    payload = msg.payload.decode('utf-8')
    try:
        # Mengubah data string JSON dari ESP32 menjadi dictionary Python
        data = json.loads(payload)
        if "suhu" in data:
            simpan_ke_database(data["suhu"])
    except json.JSONDecodeError:
        print(f"Pesan diabaikan (Bukan format JSON): {payload}")

# Inisialisasi MQTT Client
client = mqtt.Client()
client.on_message = on_message

# Menghubungkan ke Broker Mosquitto lokal
print("Menghubungkan ke Broker MQTT...")
client.connect("127.0.0.1", 1883, 60)

# Subscribe ke topik yang sama dengan ESP32
topik = "sensor/suhu"
client.subscribe(topik)
print(f"Berhasil terhubung! Menunggu data di topik: '{topik}'...")

# Looping agar script terus berjalan
client.loop_forever()