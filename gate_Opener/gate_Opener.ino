
void setup() {
  Serial.begin(9600);
  pinMode(8, OUTPUT);
  pinMode(9, OUTPUT);
  pinMode(3, INPUT);
  pinMode(4, INPUT);
  pinMode(10, OUTPUT);
  pinMode(11, OUTPUT);
  digitalWrite(9,HIGH);
  digitalWrite(8,HIGH);
}
void loop() {  
  digitalWrite(10,HIGH);
  digitalWrite(11,LOW);
  if (digitalRead(13)==HIGH){
    if (digitalRead(4)){
      Serial.println("Open");
      digitalWrite(9,LOW);
      digitalWrite(10,LOW);
      digitalWrite(11,HIGH);
    
    while (digitalRead(4)==HIGH){}
      digitalWrite(9,HIGH);    
    delay(2000);
    while(digitalRead(6)==LOW){}
    delay(1000);
    if (digitalRead(3)){
      Serial.print("Close");
      digitalWrite(8,LOW);
    }
    while(digitalRead(3)){}
    digitalWrite(8,HIGH);
  }
  }
}
