//Main Reader Unit Firmware ver 4
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
char server[] = "192.168.88.250";
byte readCard[4];
byte mac[] = { 0xAA, 0xBB, 0xCC, 0xDD, 0xEF, 0x02 };  
IPAddress ip(192, 168, 88, 238); 
String data;
String dataString;
String readString;
int isOK; 
int re=0;
EthernetClient client;
MFRC522 mfrc522(SS_PIN, RST_PIN);
RTC_DS1307 rtc;
void setup()
{   
  String date = "";
  String timenow = "";
  pinMode(13,OUTPUT);
  pinMode(6,OUTPUT); 
  pinMode(7,OUTPUT);
  pinMode(9,OUTPUT); 
  pinMode(8,OUTPUT); 
  digitalWrite(6,HIGH); 
  pinMode(42,OUTPUT); 
  pinMode(43,OUTPUT);
  digitalWrite(42,HIGH);
  //Begin       
  Serial.begin(9600);   
  SPI.begin();    
  lcd.begin();  
  lcd.print("Initializing...");
  Serial.println("Initializing...");
  digitalWrite(42,LOW);
  delay(50);
  digitalWrite(42,HIGH);
  delay(80);
  digitalWrite(42,LOW);
  delay(50);
  digitalWrite(42,HIGH);
  lcd.setCursor(0,1);
  lcd.print("Using DHCP...");
  lcd.print("             ");
  
//  if (Ethernet.begin(mac) == 0) {
//    lcd.setCursor(0,1);
//    lcd.print("Using Pre-Config IP");
//    Ethernet.begin(mac, ip);
//  }
  Ethernet.begin(mac, ip);
  
  lcd.setCursor(0,1);
  lcd.print("             ");
  lcd.setCursor(0,1);
  lcd.print("Ethernet");
  lcd.setCursor(13,1);
  lcd.print("[ OK ]");
  lcd.setCursor(0,2);
  lcd.print("IP:");
  lcd.setCursor(4,2);
  lcd.print(Ethernet.localIP());
  Serial.println(Ethernet.localIP());
  mfrc522.PCD_Init();
  mfrc522.PCD_DumpVersionToSerial();
  DateTime now = rtc.now();
  date = String(now.year()) +"-"+String(now.month())+"-" +String(now.day()) ;
  timenow = String(now.hour()) + ":"+ String(now.minute())+ ":"+ String(now.second());
  Serial.println(date);
  Serial.println(timenow);
  lcd.setCursor(0,3);
  lcd.print(date);
  lcd.print("  ");
  lcd.print(timenow);
  delay(1000);
  //
  
  lcd.clear();
  //RTC Check
  if (!rtc.begin()){
    lcd.setCursor(0,0);
    lcd.print("RTC");
    lcd.setCursor(13,0);
    lcd.print("[Error]");
  }else{
    lcd.setCursor(0,0);
    lcd.print("RTC");
    lcd.setCursor(13,0);
    lcd.print("[ OK ]");
  }
  
  //SD Check
  if (!SD.begin(4)) {
      Serial.println("ERROR - SD card initialization failed!");   
      lcd.clear();
      lcd.setCursor(0,0);  
      lcd.print("SD Card");
      lcd.setCursor(10,0);
      lcd.print("[ Failed ]"); 
      return;    
  }else{
    Serial.println("SUCCESS - SD card initialized.");
  }  
  lcd.setCursor(0,1);
  lcd.print("SD Card");
  lcd.setCursor(13,1);
  lcd.print("[ OK ]");  
  //Server Check
  lcd.setCursor(0,2);
  lcd.print("Server");
  lcd.setCursor(7,2);
  lcd.print("[connecting]");
  retry:   
  if (client.connect(server,80)) { 
    lcd.setCursor(0,2);        
    lcd.print("Server");
    lcd.setCursor(7,2);
    lcd.print("             ");    
    lcd.setCursor(13,2);
    lcd.print("[ OK ]");
    Serial.println("Server online"); 
    client.stop();  
  }else{
    if(re < 6){      
      lcd.setCursor(0,3);
      lcd.print("Retry: ");
      lcd.print(re);
      delay(500);
      re++;
      goto retry;      
    }
    lcd.setCursor(0,2);
    lcd.print("Server");
    lcd.setCursor(7,2);
    lcd.print("             ");     
    lcd.setCursor(13,2);
    lcd.print("[Error]");    
    Serial.println("Server offline"); 
    lcd.setCursor(0,3);
    lcd.print("Init FAILED!");
    while(true);    
  }
  
  //
  lcd.setCursor(0,3);
  lcd.print("Init SUCCESS!"); 
  Serial.println("Stand By for Card");
  digitalWrite(42,LOW);
  delay(100);
  digitalWrite(42,HIGH);
  delay(100);
  digitalWrite(42,LOW);
  delay(100);
  digitalWrite(42,HIGH);    
  delay(1000);
  lcd.clear();
  lcd.print("Stand By...");  
   
  digitalWrite(8,LOW);
  digitalWrite(9,LOW);
}

void loop(){   
  digitalWrite(43,HIGH);
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
  digitalWrite(42,LOW);
  delay(100);
  digitalWrite(43,LOW);
  digitalWrite(42,HIGH);   
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
  lcd.print("Checking...");
  postData();  
  dataString = "";
  data ="";
  Serial.println("--------------------------------");  
  digitalWrite(13,LOW);
  lcd.clear();
  switch(isOK){
    case 0:
        lcd.print("ACCESS DENIED");
        digitalWrite(8,HIGH);
        digitalWrite(42,LOW);
        delay(100);
        digitalWrite(42,HIGH);
        delay(100);
        digitalWrite(42,LOW);
        delay(100);
        digitalWrite(42,HIGH);       
        break;
    case 1:
        lcd.print("ACCESS GRANTED");
        digitalWrite(9,HIGH);
        
        digitalWrite(42,LOW);
        delay(300);
        digitalWrite(42,HIGH); 
        break;
    case 2:
        lcd.print("YOU'VE ALREADY ENTER");
        digitalWrite(8,HIGH);
        digitalWrite(9,HIGH);
        digitalWrite(42,LOW);
        delay(50);
        digitalWrite(42,HIGH);
        delay(100);
        digitalWrite(42,LOW);
        delay(50);
        digitalWrite(42,HIGH);
        delay(100);
        digitalWrite(42,LOW);
        delay(50);
        digitalWrite(42,HIGH);
        break;
  } 
  gateOpen();
  readString = "";
  isOK = 0;
  delay(3000);
  digitalWrite(8,LOW);
  digitalWrite(9,LOW);
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
  post:
  if (client.connect(server,80)) {     
    client.print("GET /add.php?mode=1&");      
    client.print(data);
    client.print(" HTTP/1.1"); 
    client.println();
    client.println("Host: 192.168.10.4");
    client.println("Connection: close");
    client.println();
    Serial.println("GET CMPL!");
  }else{
    Serial.println("GET Failed or server offline");
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Error:");    
    lcd.setCursor(0,1);
    lcd.print("Can't connect to ser"); 
    lcd.setCursor(0,2);
    lcd.print("ver...");   
    lcd.setCursor(0,3);
    lcd.print("Pls check connection");
    goto post;
  }  
  delay(500); 
  again: 
  while (client.available()) {
    char c = client.read();       
    readString += c;  
  }
  String checkStr = readString.substring(223);
  Serial.println(checkStr); 
  if (checkStr == ""){
    goto again;
  }
  if (checkStr.indexOf('R')>1){
     isOK = 1;
     Serial.println("ACCESS GRANTED");  
        
  }else{
  if (checkStr.indexOf('N')>1){
     isOK = 0;
     Serial.println("ACCESS DENIED");     
  }else{
    if (checkStr.indexOf('P')>1){
     isOK = 2;
     Serial.println("YOU'VE ALREADY ENTER");     
  }
  }
  }
  client.stop();    
  return;
}
void gateOpen(){
  if(isOK==1){
  digitalWrite(6,LOW);
  delay(100);
  digitalWrite(6,HIGH);  
  return;
  }
}
