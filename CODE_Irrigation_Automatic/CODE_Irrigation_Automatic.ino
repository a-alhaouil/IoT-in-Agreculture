#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x3F, 16, 2);
 
void setup() {
  Serial.begin(9600);
  lcd.init();
  lcd.backlight();
  lcd.clear();
  pinMode(2, OUTPUT);
  digitalWrite(2, HIGH);
  delay(1000);
  lcd.setCursor(0, 0);
  lcd.print("IRRIGATION");
  lcd.setCursor(0, 1);
  lcd.print("SYSTEM IS ON ");
  lcd.print("");
  delay(3000);
  lcd.clear();
}
 
void loop() {
  int value = analogRead(A0);
  Serial.println(value);
  if (value < 750) {
    digitalWrite(2, LOW);
    lcd.setCursor(0, 0);
    lcd.print("Water Pump is OFF ");
  } else {
    digitalWrite(2, HIGH);
    lcd.setCursor(0, 0);
    lcd.print("Water Pump is ON");
  }
 
  if (value < 300) {
    lcd.setCursor(0, 1);
    lcd.print("Moisture : HIGH");
  } else if (value > 300 && value < 950) {
    lcd.setCursor(0, 1);
    lcd.print("Moisture : MID ");
  } else if (value > 950) {
    lcd.setCursor(0, 1);
    lcd.print("Moisture : LOW ");
  }
}






////TESTE LCD WORKINGGGG
//  #include <Wire.h>
// #include <LiquidCrystal_I2C.h>

// // Adresse I2C de l'écran LCD QAPASS (peut varier)
// int lcdAddress = 0x3F;

// // Déclaration de l'écran LCD
// LiquidCrystal_I2C lcd(lcdAddress, 16, 2);  // 16 colonnes x 2 lignes

// void setup() {
//   // Initialisation de l'écran LCD avec les broches A4 et A5
//   Wire.begin();

//   // Initialisation de l'écran LCD
//   lcd.begin(16, 2);

//   // Affichage du message de bienvenue
//   lcd.backlight(); // Activer le rétroéclairage (si pris en charge)
//   lcd.setCursor(0, 0);
//   lcd.print("LCD QAPASS Test");

//   delay(2000);
// }

// void loop() {
//   // Effacer l'écran et afficher un compteur simple
//   lcd.clear();
//   lcd.setCursor(0, 0);
//   lcd.print("Compteur:");

//   for (int i = 0; i < 10; ++i) {
//     lcd.setCursor(0, 1);
//     lcd.print(i);
//     delay(1000); // Attendre une seconde
//   }
// }
