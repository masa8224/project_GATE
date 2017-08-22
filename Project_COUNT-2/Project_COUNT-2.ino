//Main Reader Unit Firmware ver 6
#include <Ethernet.h>
#include <RTClib.h>
#include <I2C_eeprom.h>
#include <MFRC522.h>
#include <Wire.h>
#include <SPI.h>
#include <SD.h>
#include <LiquidCrystal_I2C.h>
#define SS_PIN 53
#define RST_PIN 38 
#define MEMORY_SIZE 0x2000
LiquidCrystal_I2C lcd (0x27,20,4);
byte readCard[4];
byte mac[] = { 0xAA, 0xBB, 0xCC, 0xDD, 0xEF, 0x02 };  
char ServerIP[14];
byte server[4];
char ar[14];
IPAddress ip = {192,168,88,171}; 
char stat;
EthernetClient client;
MFRC522 mfrc522(SS_PIN, RST_PIN);
MFRC522::MIFARE_Key key;
RTC_DS3231 rtc;
I2C_eeprom ee(0x57, MEMORY_SIZE);
int comData[16]={1, 2, 3, 4, 5, 6, 255, 7, 128, 105, 3, 4, 255, 1, 255, 255};
//int intarray[16];
boolean connection(){
  int re;
  retry:   
  if (client.connect(server,80)) { 
    delay(1000);    
    client.stop();  
    return true;
  }else{
    if(re < 6){      
      lcd.setCursor(0,3);
      lcd.print("Retry: ");
      lcd.print(re);
      delay(500);
      re++;
      goto retry;      
    }
    return false;
  }
}
//ROM data to byte array operation
void parseBytes(const char* str, char sep, byte* bytes, int maxBytes, int base) {
    for (int i = 0; i < maxBytes; i++) {
        bytes[i] = strtoul(str, NULL, base);  
        str = strchr(str, sep);               
        if (str == NULL || *str == '\0') {
            break;                            
        }
        str++;                                
    }
}
void setup()
{   
  String date = "";
  String timenow = "";
  pinMode(13,OUTPUT);
  pinMode(6,OUTPUT); 
  pinMode(7,OUTPUT);
  pinMode(9,OUTPUT); 
  pinMode(8,OUTPUT); 
  digitalWrite(6,HIGH);//<-----Signal
  pinMode(42,OUTPUT); //<-----Buzzer 
  pinMode(43,OUTPUT);
  digitalWrite(42,HIGH);
  //Begin       
  Serial.begin(9600);   
  SPI.begin();    
  lcd.begin();  
  ee.begin();
  lcd.print("Initializing...");
  Serial.println("Initializing...");  
  /*------------------EEPROM OPERATION------------------*/
  char eekey[50]; 
  //ee.writeBlock(40,(uint8_t*)key,sizeof(key));
  ee.readBlock(20, (uint8_t*)ServerIP, 14);
  ee.readBlock(40, (uint8_t*)eekey, 40);
  //Serial.println(eekey);
  parseBytes(ServerIP, '.', server, 4, 10);  
  parseBytes(eekey, ',', key.keyByte, 6, 10);
  
  /*-------------EEPROM TEST-------*/
    //dump_byte_array(key.keyByte, MFRC522::MF_KEY_SIZE);
  //Serial.println(ee2key[4]);
        //Serial.print(" ");
  //dump_byte_array(key,6);  
  //dump_byte_array(server,4);  
  //Serial.println(ee2key[1]);
  /*---------------------------------------*/
  /*--------------Check Data---------------*/
  /*bool correct= false;
    for (byte i = 0; i < 6; i++) {        
        //Serial.print(array1[i]);
        //Serial.print(" ");
        if(key[i]!=comData[i]){
          //Serial.println("Data Incorrect");
          correct= false;
          break;          
        }
        correct = true;
        //Serial.println("Data Correct");
    } */ /*
    if (correct){
      Serial.println("Data Correct");
    }else{
      Serial.println("Data Incorrect");
    }*/
  /*----------First Beep-----------*/
  digitalWrite(42,LOW);
  delay(50);
  digitalWrite(42,HIGH);
  delay(80);
  digitalWrite(42,LOW);
  delay(50);
  digitalWrite(42,HIGH);
  /*------------------------------*/
  lcd.setCursor(0,1);
  lcd.print("Using DHCP...");
  lcd.print("             ");  
  if (Ethernet.begin(mac) == 0) {
    lcd.setCursor(0,1);
    lcd.print("Using Pre-Config IP");
    Ethernet.begin(mac, ip);
  }  
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
    Serial.println("RTC   [ OK ]");
  }
  
  /*//SD Check
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
  lcd.print("[ OK ]");  */
  //Server Check
  lcd.setCursor(0,2);
  lcd.print("Server");
  lcd.setCursor(7,2);
  lcd.print("[connecting]");
  if (connection()){
    lcd.setCursor(0,2);        
    lcd.print("Server");
    lcd.setCursor(7,2);
    lcd.print("             ");    
    lcd.setCursor(13,2);
    lcd.print("[ OK ]");
    Serial.println("Server  [ OK ]"); 
  }else{ 
    lcd.setCursor(0,2);
    lcd.print("Server");
    lcd.setCursor(7,2);
    lcd.print("             ");     
    lcd.setCursor(13,2);
    lcd.print("[Error]");    
    Serial.println("Server offline"); 
    lcd.setCursor(0,3);
    lcd.print("Init in [ OFFLINE MODE ]");
    Serial.println("Init in OFFLINE MODE");    
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
void READCARD(){
  byte buffer[18];
    byte size = sizeof(buffer);
    byte blockAddr = 5;
  Serial.print(F("Reading data from block ")); Serial.print(blockAddr);
    Serial.println(F(" ..."));
    MFRC522::StatusCode status;
    status = (MFRC522::StatusCode) mfrc522.MIFARE_Read(blockAddr, buffer, &size);
    if (status != MFRC522::STATUS_OK) {
        Serial.print(F("MIFARE_Read() failed: "));
        Serial.println(mfrc522.GetStatusCodeName(status));
    }
    Serial.print(F("Data in block ")); Serial.print(blockAddr); Serial.println(F(":"));
    //dump_byte_array(buffer, 16); 
    bool correct= false;
    for (byte i = 0; i < 16; i++) {        
        //Serial.print(buffer[i]);
        //Serial.print(" ");
        if(buffer[i]!=comData[i]){
          //Serial.println("Data Incorrect");
          correct= false;
          break;          
        }
        correct = true;
        //Serial.println("Data Correct");
    }  
    Serial.println("According to Data in card");
    if (correct){
      Serial.println("Access Granted");
    }else{
      Serial.println("Access Denied");
    }
}
void dump_byte_array(byte *buffer, byte bufferSize) {
    for (byte i = 0; i < bufferSize; i++) {
        Serial.print(buffer[i] < 0x10 ? " 0" : " ");
        Serial.print(buffer[i], HEX);
        //intarray[i] = buffer[i];
    }
    Serial.println();
}
int postData(String dataPOST){
  Serial.println(dataPOST);
  String cString;
  post:
  if (client.connect(server,80)) {     
    client.print("GET /add.php?mode=1&");      
    client.print(dataPOST);
    client.print(" HTTP/1.1"); 
    client.println();
    client.println("Host: 192.168.88.236");
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
  again: 
  while (client.available()) {
    char c = client.read();       
    cString += c;  
  }
  String checkStr = cString.substring(223);
  if (checkStr == ""){
    goto again;
  }
  Serial.println(checkStr);   
   
  if (checkStr.indexOf('R')>1){     
     Serial.println("ACCESS GRANTED");
     client.stop();  
     return 1;
        
  }else{
  if (checkStr.indexOf('N')>1){     
     Serial.println("ACCESS DENIED");
     client.stop();
     return 2;     
  }else{
    if (checkStr.indexOf('P')>1){     
     Serial.println("YOU'VE ALREADY ENTER"); 
     client.stop();
     return 3;    
  }
  }
  }      
}
void gateOpen(){  
  digitalWrite(6,LOW);
  delay(100);
  digitalWrite(6,HIGH);  
  return;  
}

void loop(){   
  
  digitalWrite(43,HIGH);
  String data;
  String dataString;  
  String lcdString = "";
  String date = "";
  String timenow = "";  
  /*------CARD OPERATION--------*/
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
  int sector;
    byte trailerBlock   = 7;
    
    MFRC522::StatusCode status;
    Serial.println(F("Authenticating again using key A..."));
    status = (MFRC522::StatusCode) mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, trailerBlock, &key, &(mfrc522.uid));
    if (status != MFRC522::STATUS_OK) {
        Serial.print(F("This card is Unregistered Card "));
        
    }else{
        Serial.print(F("This card is Registered Card "));
        READCARD();
    }
  for (int i = 0; i < 4; i++) {  
    readCard[i] = mfrc522.uid.uidByte[i];
  }
  /*-------------------------*/
  Serial.println();  
  /*---------DATA OPERATION-----------*/
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
  //WriteToSD(dataString);
  lcd.clear();
  lcd.print("Checking..."); 
  Serial.println("--------------------------------");  
  digitalWrite(13,LOW); 
  /*-----------------------------------*/
  /*-----------ACCESS CONTROL----------*/
  switch(postData(data)){
    case 2:
        lcd.clear();
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
        lcd.clear();
        lcd.print("ACCESS GRANTED");
        digitalWrite(9,HIGH);        
        digitalWrite(42,LOW);
        delay(300);
        digitalWrite(42,HIGH); 
        gateOpen();
        break;
    case 3:
        lcd.clear();
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
  /*---------------------------------*/
  mfrc522.PICC_HaltA(); 
  mfrc522.PCD_StopCrypto1();
  Serial.println("--------------------------------");
  delay(3000);
  digitalWrite(8,LOW);
  digitalWrite(9,LOW);
  lcd.clear();
  lcd.print("Stand By...");
}

void WriteToSD(String data){
  File dataFile = SD.open("datalog.txt", FILE_WRITE);
  if (dataFile) {
    dataFile.println(data);
    dataFile.close();    
    Serial.println(data);
    Serial.println("Write!");
  }  
  else {
    Serial.println("error opening datalog.txt");
  }
}


