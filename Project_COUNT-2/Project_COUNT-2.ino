#include "RTClib.h"
#include <MFRC522.h>
#include <Wire.h>
#include <SPI.h>
#include <SD.h>
#include <LiquidCrystal_I2C.h>
#define SS_PIN 53
#define RST_PIN 5
LiquidCrystal_I2C lcd (0x27,20,4);
byte readCard[4];
unsigned int combine[32];
MFRC522 mfrc522(SS_PIN, RST_PIN);
RTC_DS1307 rtc;
void setup()
{   
  pinMode(13,OUTPUT);
  pinMode(6,OUTPUT);         
  Serial.begin(9600);   
  SPI.begin();    
  Serial.println("Initializing SD card...");
  if (!rtc.begin()){
    Serial.println("Error!: RTC not found");
  }
  if (!SD.begin(4)) {
      Serial.println("ERROR - SD card initialization failed!");       
      return;    
  }
  Serial.println("SUCCESS - SD card initialized.");   
  mfrc522.PCD_Init();
  mfrc522.PCD_DumpVersionToSerial(); 
  Serial.println("Scan PICC to see UID and type...");
}

void loop(){  
  String dataString = "";  
  if ( ! mfrc522.PICC_IsNewCardPresent()) {   
    return;
  }
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  }  
  digitalWrite(13,HIGH);
  digitalWrite(6,HIGH);
  Serial.println("--------------------------------");
  for (int i = 0; i < 4; i++) {  //
    readCard[i] = mfrc522.uid.uidByte[i];
  }
  Serial.println();
  Serial.println("--------------------------------");
  DateTime now = rtc.now();
  uint32_t combine = 0;
  combine = readCard[3];
  combine <<= 8; 
  combine |= readCard[2];
  combine <<= 8; 
  combine |= readCard[1];
  combine <<= 8; 
  combine |= readCard[0];  
  Serial.println(combine);  
  dataString += String(now.day()) +"/"+String(now.month())+"/" +String(now.year()) +"  "+ String(now.hour()) + ":"+ String(now.minute())+ ":"+ String(now.second()) + " > " + String(combine);
  File dataFile = SD.open("datalog.txt", FILE_WRITE);
  if (dataFile) {
    dataFile.println(dataString);
    dataFile.close();    
    Serial.println(dataString);
    Serial.println("Write!");
  }  
  else {
    Serial.println("error opening datalog.txt");
  }
  if (combine == 231317241){
    Serial.println("Access Granted!");
  }
  dataString = "";
  delay(200);
  digitalWrite(6,LOW);
  delay(300);
  digitalWrite(13,LOW);
  delay(500);
  //mfrc522.PICC_DumpToSerial(&(mfrc522.uid)); 
}

