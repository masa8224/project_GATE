#include <Ethernet.h>
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
byte mac[] = { 0xAA, 0xBB, 0xCC, 0xDD, 0xEF, 0x02 };  
IPAddress ip(192, 168, 1, 178); 
byte server[] = { 192,168,0,108 }; 
int combine;
String data;
MFRC522 mfrc522(SS_PIN, RST_PIN);
RTC_DS1307 rtc;
EthernetClient client;
void setup()
{   
  pinMode(13,OUTPUT);
  pinMode(6,OUTPUT);         
  Serial.begin(9600);   
  SPI.begin();    
  lcd.begin();
  Serial.println("Initializing...");
  lcd.print("Initializing SD card...");
  Ethernet.begin(mac,ip);  

  if (!rtc.begin()){
    Serial.println("Error!: RTC not found");
  }
  if (!SD.begin(4)) {
      Serial.println("ERROR - SD card initialization failed!");       
      return;    
  }
  Serial.println("SUCCESS - SD card initialized."); 
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Init SUCCESS!"); 
  mfrc522.PCD_Init();
  mfrc522.PCD_DumpVersionToSerial(); 
  Serial.println("Stand By for Card");
  delay(1000);
  lcd.clear();
  lcd.print("Stand By...");
}

void loop(){  
  String dataString = "";  
  String lcdString = "";
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
  lcdString += "UID > "+String(combine);
  data = "uid=" + String(combine); 
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
  lcd.clear();
  lcd.print(lcdString);
  if (combine == 231317241){
    Serial.println("Access Granted!");
  }  
  postData();
  dataString = "";
  data ="";
  delay(200);
  digitalWrite(6,LOW);
  delay(300);
  digitalWrite(13,LOW);
  delay(800);
  lcd.clear();
  lcd.print("Stand By...");
  //mfrc522.PICC_DumpToSerial(&(mfrc522.uid)); 
}
void postData(){
  if (client.connect("192.168.1.108",80)) { 
    Serial.println("Server Connected!");
    client.println("POST /add.php HTTP/1.1"); 
    client.println("Host: 192.168.1.108"); 
    client.println("Content-Type: application/x-www-form-urlencoded"); 
    client.print("Content-Length: "); 
    client.println(data.length()); 
    client.println(); 
    client.print(data); 
    Serial.println(data);
    Serial.println("Post Complete");
  }
  if (client.connected()) { 
    client.stop();  
  }
  return;
}

