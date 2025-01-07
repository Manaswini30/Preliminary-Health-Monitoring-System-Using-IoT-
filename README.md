# Preliminary-Health-Monitoring-System-Using-IoT-
# This provides unparalleled insights into a person's health status and makes prompt interventions possible when needed. In this regard, the creation of an Internet of Things-based health monitoring system with real-time temperature, heart rate, and oxygen level monitoring is the main emphasis of our research.
#include <Wire.h>
#include <Adafruit_MLX90614.h>
#include <WiFi.h>
#define REPORTING_PERIOD_MS 1000
#define WIFI_SSID "medimonitor"
#define WIFI_PASSWORD "medimonitor"
#define SERVER_HOST "medimonitorsvpcet.000webhostapp.com"
#define SERVER_PORT 80
#define SERVER_PATH "/project/testdata.php"
#define BUZZER_PIN 4 // Define the pin connected to the buzzer

Adafruit_MLX90614 mlx = Adafruit_MLX90614();

float body_temp, heart_rate, So2;
uint32_t tsLastReport = 0; // Declaration of tsLastReport

const int touchPin = 2; // Define the pin connected to the touch sensor

WiFiClient client;

void setup() {
  Serial.begin(115200);
  delay(100);

  pinMode(BUZZER_PIN, OUTPUT); // Initialize buzzer pin

  Serial.print("Initializing MLX90614 sensor...");
  mlx.begin();
  Serial.println("SUCCESS");

  // Connect to WiFi
  connectToWiFi();
}

void loop() {
  if (digitalRead(touchPin) == HIGH) { // Check if touch is detected
    heart_rate = random(60, 100); // Random BPM value for demonstration
    So2 = random(95, 100); // Random SpO2 value for demonstration

    if (millis() - tsLastReport > REPORTING_PERIOD_MS) {
      body_temp = mlx.readObjectTempF();    
      Serial.println("\n*\n");
      Serial.print("Heart Beat Rate: ");
      Serial.println(heart_rate);
      Serial.print("Oxygen Level: ");
      Serial.print(So2);
      Serial.println("%");
      Serial.print("Body Temperature: ");
      Serial.print(body_temp);
      Serial.println(" °F");

      // Send data to server
      sendDataToServer(So2, body_temp, heart_rate);

      // Control buzzer based on temperature
      controlBuzzer(body_temp);

      tsLastReport = millis(); // Update last reporting time
    }
  } else {
    Serial.println("No touch detected");
  }

  delay(5000);
}

void connectToWiFi() {
  Serial.println("Connecting to WiFi...");
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void sendDataToServer(float SpO2, float body_temp, float heart_rate) {
  if (client.connect(SERVER_HOST, SERVER_PORT)) {
    Serial.println("Connected to server");
    // Construct the HTTP GET request
    String request = "GET "+ String(SERVER_PATH) + "?so2=" + String(SpO2) + "&body_temp=" + String(body_temp) + "&heart_rate=" + String(heart_rate) + " HTTP/1.1";
    Serial.println("Request: " + request); // Debug print the request
    client.println(request);
    client.print("Host: ");
    client.println(SERVER_HOST);
    client.println("Connection: close");
    client.println();
  } else {
    Serial.println("Connection failed");
  }
}
void controlBuzzer(float temp) {
  if (temp > 106) {
    // Beep differently for hyperpyrexia
    tone(BUZZER_PIN, 1000, 1000);
  } else if (temp > 104) {
    // Beep differently for high-grade fever
    tone(BUZZER_PIN, 800, 1000);
  } else if (temp > 102) {
    // Beep differently for moderate fever
    tone(BUZZER_PIN, 600, 1000);
  } else if (temp > 100) {
    // Beep differently for low-grade fever
    tone(BUZZER_PIN, 400, 1000);
  } else {
    // No beep for normal temperature
    noTone(BUZZER_PIN);
  }
}
