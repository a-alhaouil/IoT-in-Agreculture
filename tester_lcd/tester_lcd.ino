 #include <Wire.h>

void setup() {
  Serial.begin(9600);
  while (!Serial);

  Serial.println("Scanning...");

  int deviceCount = 0;

  Wire.begin();

  for (int address = 1; address < 127; ++address) {
    Wire.beginTransmission(address);
    byte error = Wire.endTransmission();

    if (error == 0) {
      Serial.print("Device found at address 0x");
      if (address < 16) Serial.print("0");
      Serial.print(address, HEX);
      Serial.println();

      deviceCount++;
    }
  }

  if (deviceCount == 0) {
    Serial.println("No I2C devices found.");
  } else {
    Serial.println("Scan complete.");
  }
}

void loop() {
  // Do nothing here
}
