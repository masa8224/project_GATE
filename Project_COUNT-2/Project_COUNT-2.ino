#include <Ethernet.h>
#include "RTClib.h"
#include <MFRC522.h>
#include <Wire.h>
#include <SPI.h>
#include <SD.h>
#include <LiquidCrystal_I2C.h>
#define SS_PIN 53
#define RST_PIN 3
LiquidCrystal_I2C lcd (0x27,20,4);
byte readCard[4];
byte mac[] = { 0xAA, 0xBB, 0xCC, 0xDD, 0xEF, 0x02 };  
IPAddress ip(192, 168, 1, 107); 
byte server[] = { 192,168,0,108 }; 
String data;
String dataString;
MFRC522 mfrc522(SS_PIN, RST_PIN);
RTC_DS1307 rtc;
EthernetClient client;
void setup()
{   
  pinMode(13,OUTPUT);
  pinMode(6,OUTPUT); 
  pinMode(7,OUTPUT);  
  //Begin       
  Serial.begin(9600);   
  SPI.begin();    
  lcd.begin();  
  Ethernet.begin(mac,ip); 
  mfrc522.PCD_Init();
  mfrc522.PCD_DumpVersionToSerial();
  if (!rtc.begin()){
    Serial.println("Error!: RTC not found");
  }
  //
  Serial.println("Initializing...");
  lcd.print("Init..."); 
  //RTC Check
  if (!rtc.begin()){
    Serial.println("Error!: RTC not found");
  }
  //SD Check
  if (!SD.begin(4)) {
      Serial.println("ERROR - SD card initialization failed!");     
      lcd.clear();
      lcd.print("Init FAILED!");  
      return;    
  }
  Serial.println("SUCCESS - SD card initialized.");
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("SD FOUND"); 
  //Server Check
  if (client.connect("192.168.1.109",80)) { 
    lcd.setCursor(0,1);
    Serial.println("Server Connected!");    
    lcd.print("Server online");
  }else{
    lcd.setCursor(0,1);
    Serial.println("Server offline");
    lcd.print("Server offline");
  }
  if (client.connected()) { 
    client.stop();  
  }
  //
  lcd.setCursor(0,2);
  lcd.print("Init SUCCESS!"); 
  Serial.println("Stand By for Card");
  delay(1000);
  lcd.clear();
  lcd.print("Stand By...");
  digitalWrite(6,LOW);  
}

void loop(){  
  dataString = "";  
  String lcdString = "";
  String date = "";
  String timenow = "";
  if ( ! mfrc522.PICC_IsNewCardPresent()) {   
    return;
  }
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  }  
  digitalWrite(13,HIGH);    
  for (int i = 0; i < 4; i++) {  //
    readCard[i] = mfrc522.uid.uidByte[i];
  }
  Serial.println();  
  DateTime now = rtc.now();
  uint32_t combine = 0;
  combine = readCard[3];
  combine <<= 8; 
  combine |= readCard[2];
  combine <<= 8; 
  combine |= readCard[1];
  combine <<= 8; 
  combine |= readCard[0];  
  Serial.println("--------------------------------");
  Serial.println(combine);
  date = String(now.year()) +"-"+String(now.month())+"-" +String(now.day()) ;
  timenow = String(now.hour()) + ":"+ String(now.minute())+ ":"+ String(now.second());
  lcdString = "UID > "+String(combine);
  data = "date=" + date + "&time=" + timenow + "&uid=" + String(combine);   
  dataString = date +"  "+ timenow + " > " + String(combine);
  WriteToSD();
  lcd.clear();
  lcd.print(lcdString);
  postData();
  dataString = "";
  data ="";
  Serial.println("--------------------------------");
  digitalWrite(6,HIGH);
  delay(200);
  digitalWrite(6,LOW);
  delay(300);
  digitalWrite(13,LOW);
  gateOpen();
  lcd.clear();
  lcd.print("Stand By...");
}
void WriteToSD(){
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
}
void postData(){
  Serial.println(data);
  if (client.connect("192.168.1.109",80)) { 
    Serial.println("Server Connected!");
    client.println("POST /add.php HTTP/1.1"); 
    client.println("Host: 192.168.1.109"); 
    client.println("Content-Type: application/x-www-form-urlencoded"); 
    client.print("Content-Length: "); 
    client.println(data.length()); 
    client.println(); 
    client.print(data); 
    Serial.println("POST CMPL!");
  }else{
    Serial.println("POST Failed or server offline");
  }
  if (client.connected()) { 
    client.stop();  
  }
  return;
}
void gateOpen(){
  digitalWrite(6,HIGH);
  delay(100);
  digitalWrite(6,LOW);  
  return;
}


