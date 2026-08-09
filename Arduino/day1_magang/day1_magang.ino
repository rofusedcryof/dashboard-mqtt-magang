#include <WiFi.h>
#include <PubSubClient.h>

// editable network
const char* ssid = "NAMA_WIFI_KANTOR";
const char* password = "PASSWORD_WIFI_KANTOR";
const char* mqtt_server = "192.168.x.x"; // Isi dengan IP Address IPv4 klo udh connect wifi

WiFiClient espClient;
PubSubClient client(espClient);

void setup() {
  Serial.begin(115200);
  
  // 1. Koneksi ke WiFi
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan ke WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi Terhubung!");
  Serial.print("IP ESP32: ");
  Serial.println(WiFi.localIP());

  // 2. Setup Server MQTT
  client.setServer(mqtt_server, 1883);
}

void loop() {
  // 3. MQTT always connect
  if (!client.connected()) {
    while (!client.connected()) {
      Serial.print("Menghubungkan ke MQTT Broker...");
      // Membuat Client ID acak
      String clientId = "ESP32Client-";
      clientId += String(random(0xffff), HEX);
      
      if (client.connect(clientId.c_str())) {
        Serial.println("Berhasil!");
      } else {
        Serial.print("Gagal, rc=");
        Serial.print(client.state());
        Serial.println(" Coba lagi dalam 5 detik");
        delay(5000);
      }
    }
  }
  client.loop();

  // 4. Simulasi Pembacaan Sensor (Ganti dengan sensor asli besok)
  float suhu_dummy = random(250, 350) / 10.0; // Menghasilkan angka 25.0 - 35.0
  
  // 5. Merakit data menjadi format JSON
  String payload = "{\"suhu\": " + String(suhu_dummy) + "}";

  // 6. Mengirim data ke topik "sensor/suhu"
  client.publish("sensor/suhu", payload.c_str());
  
  Serial.print("Data Terkirim: ");
  Serial.println(payload);
  
  // Jeda 5 detik sebelum mengirim data berikutnya
  delay(5000);
}