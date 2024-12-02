// Blynk credentials
#define BLYNK_TEMPLATE_ID "TMPL2tYsKcpQI"
#define BLYNK_TEMPLATE_NAME "smart irrigation"
#define BLYNK_AUTH_TOKEN "qWKsH20v_m_yH_8b3XK0iptF-8i3R_em"

// WiFi credentials
// char ssid[] = "ghhh_plus";
// char pass[]= "whoareU@123";

// // PHP server URL
// String URL = "http://192.168.1.33/dht11_project/Add_data.php";


// // // Set password to "" for open networks.
// char ssid[] = "My Wifi"; //WiFi Name
// char pass[] = "A1234567*"; //WiFi Password
// // PHP server URL
// String URL = "http://192.168.43.188/dht11_project/Add_data.php";
// // Set password to "" for open networks.
// char ssid[] = "Ibrahim"; //WiFi Name
// char pass[] = "12345678901"; //WiFi Password
// // PHP server URL
// String URL = "http://172.20.10.6/dht11_project/Add_data.php"; 

char ssid[] = "Ahmed"; //WiFi Name
char pass[] = "Ahmed1234"; //WiFi Password
// PHP server URL
String URL = "http://192.168.137.35/dht11_project/Add_data.php"; 

// Moisture sensor thresholds
int wetSoilVal = 930;
int drySoilVal = 3000;
// Moisture in percentage = 100 – (Analog output * 100)
// int wetSoilVal = 0;
// int drySoilVal = 1023;

int moistPerLow = 20;
int moistPerHigh = 80;


#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>
#include <Adafruit_SSD1306.h>
#include <WiFiClient.h>
#include <BlynkSimpleEsp32.h>
#include <AceButton.h>

using namespace ace_button;

#define DHTPIN 5
#define SensorPin 34 // Soil moisture sensor pin

#define RelayPin 25  // Relay pin
#define wifiLed 2    // WiFi LED pin
#define RelayButtonPin 32 // Relay button pin
#define ModeSwitchPin 33  // Mode switch pin
#define BuzzerPin 26 // Buzzer pin
#define ModeLed 15 // Mode LED pin


// Uncomment whatever type you're using!
#define DHTTYPE DHT11     // DHT 11
//#define DHTTYPE DHT22   // DHT 22, AM2302, AM2321
//#define DHTTYPE DHT21   // DHT 21, AM2301

//Change the virtual pins according the rooms
#define VPIN_MoistPer    V1 
#define VPIN_TEMPERATURE V2
#define VPIN_HUMIDITY    V3
#define VPIN_MODE_SWITCH V4
#define VPIN_RELAY       V5

// OLED display settings
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 32
#define OLED_RESET -1
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

int temperature1 = 0;
int humidity1 = 0;
int moisturePercentage = 0;
bool toggleRelay = LOW;
bool prevMode = true;
String currMode = "A";

char auth[] = BLYNK_AUTH_TOKEN;

ButtonConfig config1;
AceButton button1(&config1);
ButtonConfig config2;
AceButton button2(&config2);

void handleEvent1(AceButton*, uint8_t, uint8_t);
void handleEvent2(AceButton*, uint8_t, uint8_t);

BlynkTimer timer;
DHT dht(DHTPIN, DHTTYPE);

void checkBlynkStatus() {
  bool isconnected = Blynk.connected();
  if (!isconnected) {
    Serial.print("Blynk Not Connected ");
    digitalWrite(wifiLed, LOW);
  } else {
    digitalWrite(wifiLed, HIGH);
  }
}

BLYNK_CONNECTED() {
  Blynk.syncVirtual(VPIN_MoistPer);
  Blynk.syncVirtual(VPIN_RELAY);
  Blynk.syncVirtual(VPIN_TEMPERATURE);
  Blynk.syncVirtual(VPIN_HUMIDITY);
  Blynk.virtualWrite(VPIN_MODE_SWITCH, prevMode);
}

BLYNK_WRITE(VPIN_RELAY) {
  if (!prevMode) {
    toggleRelay = param.asInt();
    digitalWrite(RelayPin, toggleRelay);
  } else {
    Blynk.virtualWrite(VPIN_RELAY, toggleRelay);
  }
}

BLYNK_WRITE(VPIN_MODE_SWITCH) {
  if (prevMode != param.asInt()) {
    prevMode = param.asInt();
    currMode = prevMode ? "A" : "M";
    digitalWrite(ModeLed, prevMode);
    controlBuzzer(500);
    if (!prevMode && toggleRelay == HIGH) {
      digitalWrite(RelayPin, LOW);
      toggleRelay = LOW;
      Blynk.virtualWrite(VPIN_RELAY, toggleRelay);
    }
  }
}

void controlBuzzer(int duration) {
  digitalWrite(BuzzerPin, HIGH);
  delay(duration);
  digitalWrite(BuzzerPin, LOW);
}

void displayData(String line1, String line2) {
  display.clearDisplay();
  display.setTextSize(2);
  display.setCursor(30, 2);
  display.print(line1);
  display.setTextSize(1);
  display.setCursor(1, 25);
  display.print(line2);
  display.display();
}

void getMoisture() {
  int sensorVal = analogRead(SensorPin);
  if (sensorVal > (wetSoilVal - 100) && sensorVal < (drySoilVal + 100)) {
    moisturePercentage = map(sensorVal, drySoilVal, wetSoilVal, 0, 100);
    Serial.print("Moisture Percentage: ");
    Serial.print(moisturePercentage);
    Serial.println(" %");
  } else {
    Serial.println(sensorVal);
  }
  delay(100);
}

void getWeather() {
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  if (isnan(h) || isnan(t)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  } else {
    humidity1 = int(h);
    temperature1 = int(t);
  }
}

void sendSensor() {
  getMoisture();
  getWeather();
  displayData(String(moisturePercentage) + " %", "T:" + String(temperature1) + " C, H:" + String(humidity1) + " % " + currMode);
  Blynk.virtualWrite(VPIN_MoistPer, moisturePercentage);
  Blynk.virtualWrite(VPIN_TEMPERATURE, temperature1);
  Blynk.virtualWrite(VPIN_HUMIDITY, humidity1);

  String postData = "temperature=" + String(temperature1) + "&humidity=" + String(humidity1)+ "&moisture=" + String(moisturePercentage);
  HTTPClient http;
  http.begin(URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData);
  String payload = "";
  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      payload = http.getString();
      Serial.println(payload);
    } else {
      Serial.printf("[HTTP] POST... code: %d\n", httpCode);
    }
  } else {
    Serial.printf("[HTTP] POST... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }
  http.end();
}

void controlMoist() {
  if (prevMode) {
    if (moisturePercentage < moistPerLow) {
      if (toggleRelay == LOW) {
        controlBuzzer(500);
        digitalWrite(RelayPin, HIGH);
        toggleRelay = HIGH;
        Blynk.virtualWrite(VPIN_RELAY, toggleRelay);
        delay(1000);
      }
    }
    if (moisturePercentage > moistPerHigh) {
      if (toggleRelay == HIGH) {
        controlBuzzer(500);
        digitalWrite(RelayPin, LOW);
        toggleRelay = LOW;
        Blynk.virtualWrite(VPIN_RELAY, toggleRelay);
        delay(1000);
      }
    }
  } else {
    button1.check();
  }
}

void setup() {
  Serial.begin(115200);
  pinMode(RelayPin, OUTPUT);
  pinMode(wifiLed, OUTPUT);
  pinMode(ModeLed, OUTPUT);
  pinMode(BuzzerPin, OUTPUT);

  pinMode(RelayButtonPin, INPUT_PULLUP);
  pinMode(ModeSwitchPin, INPUT_PULLUP);

  digitalWrite(wifiLed, LOW);
  digitalWrite(ModeLed, LOW);
  digitalWrite(BuzzerPin, LOW);

  dht.begin();

  config1.setEventHandler(button1Handler);
  config2.setEventHandler(button2Handler);

  button1.init(RelayButtonPin);
  button2.init(ModeSwitchPin);

  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {
    Serial.println(F("SSD1306 allocation failed"));
    for (;;);
  }
  delay(1000);
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.clearDisplay();

  WiFi.begin(ssid, pass);
  timer.setInterval(2000L, checkBlynkStatus);
  timer.setInterval(3000L, sendSensor);
  Blynk.config(auth);
  controlBuzzer(1000);
  digitalWrite(ModeLed, prevMode);
}

void loop() {
  Blynk.run();
  timer.run();// Initiates SimpleTimer

  button2.check();
  controlMoist();
}

void button1Handler(AceButton* button, uint8_t eventType, uint8_t buttonState) {
  Serial.println("EVENT1");
  switch (eventType) {
    case AceButton::kEventReleased:
      digitalWrite(RelayPin, !digitalRead(RelayPin));
      toggleRelay = digitalRead(RelayPin);
      Blynk.virtualWrite(VPIN_RELAY, toggleRelay);
      break;
  }
}

void button2Handler(AceButton* button, uint8_t eventType, uint8_t buttonState) {
  Serial.println("EVENT2");
  switch (eventType) {
    case AceButton::kEventReleased:
      if (prevMode && toggleRelay == HIGH) {
        digitalWrite(RelayPin, LOW);
        toggleRelay = LOW;
        Blynk.virtualWrite(VPIN_RELAY, toggleRelay);
      }
      prevMode = !prevMode;
      currMode = prevMode ? "A" : "M";
      digitalWrite(ModeLed, prevMode);
      Blynk.virtualWrite(VPIN_MODE_SWITCH, prevMode);
      controlBuzzer(500);
      break;
  }
}
