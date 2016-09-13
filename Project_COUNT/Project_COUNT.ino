#include <MFRC522.h>
#include <LiquidCrystal_I2C.h>
#include <RTClib.h>
#include <Wire.h>
#include <SPI.h>
#include <Ethernet.h>
#include <SD.h>
#define SS_PIN 53
#define RST_PIN 3
RTC_DS1307 rtc;
LiquidCrystal_I2C lcd(0x27,20,4);
byte readCard[4];
unsigned int combine[32];
MFRC522 mfrc522(SS_PIN, RST_PIN);
String timedisplay;
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192, 168, 1, 178); 
EthernetServer server(80);  
File webFile;
void setup()
{
    SPI.begin();
    Ethernet.begin(mac, ip);  
    lcd.begin();
    lcd.backlight();
    server.begin();           
    Serial.begin(9600);
    lcd.print("IP>");
    lcd.setCursor(4,0);
    lcd.print(Ethernet.localIP());
    Serial.println("Initializing SD card...");
    if (!SD.begin(4)) {
        Serial.println("ERROR - SD card initialization failed!");
        lcd.setCursor(0,1);
        lcd.print("Setup FAILED");
        return;    
    }
    Serial.println("SUCCESS - SD card initialized.");
    // check for index.htm file
    if (!SD.exists("index.htm")) {
        Serial.println("ERROR - Can't find index.htm file!");
        lcd.setCursor(0,1);
        lcd.print("Setup FAILED");
        return;  
    }
    Serial.println("SUCCESS - Found index.htm file.");
    lcd.setCursor(0,1);
    lcd.print("Setup CMPL!");
    rtc.begin();
    if(!rtc.isrunning()){
    Serial.println("RTC not running...");
  }     
  mfrc522.PCD_Init(); 
  Serial.println("Scan PICC to see UID and type...");
}

void loop(){
    EthernetClient client = server.available();  // try to get client
    if (client) {  // got client?
        boolean currentLineIsBlank = true;
        while (client.connected()) {
            if (client.available()) {   // client data available to read
                char c = client.read(); // read 1 byte (character) from client
                // last line of client request is blank and ends with \n
                // respond to client only after last line received
                if (c == '\n' && currentLineIsBlank) {
                    // send a standard http response header
                    client.println("HTTP/1.1 200 OK");
                    client.println("Content-Type: text/html");
                    client.println("Connection: close");
                    client.println();
                    // send web page
                    webFile = SD.open("index.htm");        // open web page file
                    if (webFile) {
                        while(webFile.available()) {
                            client.write(webFile.read()); // send web page to client
                        }
                        webFile.close();
                    }
                    break;
                }
                // every line of text received from the client ends with \r\n
                if (c == '\n') {
                    // last character on line of received text
                    // starting new line with next character read
                    currentLineIsBlank = true;
                } 
                else if (c != '\r') {
                    // a text character was received from client
                    currentLineIsBlank = false;
                }
            } // end if (client.available())
        } // end while (client.connected())
        delay(1);      // give the web browser time to receive the data
        client.stop(); // close the connection
        //rtctime();
        RFID();
    } // end if (client)
}

void RFID(){
  if ( ! mfrc522.PICC_IsNewCardPresent()) {   
    return;
  }
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  }
  Serial.println("--------------------------------");
  for (int i = 0; i < 4; i++) {  //
    readCard[i] = mfrc522.uid.uidByte[i];
  }
  Serial.println();
  Serial.println("--------------------------------");
  uint32_t combine = 0;
  combine = readCard[3];
  combine <<= 8; 
  combine |= readCard[2];
  combine <<= 8; 
  combine |= readCard[1];
  combine <<= 8; 
  combine |= readCard[0];
  Serial.println(combine);
  //mfrc522.PICC_DumpToSerial(&(mfrc522.uid));
  lcd.setCursor(0,2);
  lcd.print("              ");
  lcd.setCursor(0,2);
  lcd.print(combine);
}
/*
void rtctime(){
  DateTime now = rtc.now();
  Serial.print("Date>");
  Serial.print(now.year(), DEC);
  Serial.print('/');
  Serial.print(now.month(), DEC);
  Serial.print('/');
  Serial.print(now.day(), DEC);
  Serial.print("  ");
  Serial.print(now.hour(), DEC);
  Serial.print(':');
  Serial.print(now.minute(), DEC);
  Serial.print(':');
  Serial.print(now.second(), DEC);
  Serial.println();
  timedisplay = (now.minute(),DEC);
  lcd.setCursor(0,2);
  lcd.print("                      ");
  lcd.setCursor(0,2);
  lcd.print(now.hour(), DEC);
  lcd.setCursor(2,2);
  lcd.print(":");
  lcd.setCursor(3,2);
  lcd.print(now.minute(),DEC);
  lcd.setCursor(5,2);
  lcd.print(":");
  lcd.setCursor(6,2);
  lcd.print(now.second(),DEC);
  return;
}
*/

