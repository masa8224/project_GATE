
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
<<<<<<< HEAD
void loop() {
  if (!digitalRead(4)){
    digitalWrite(9,HIGH);
  }
  if (!digitalRead(3)){
    digitalWrite(8,HIGH);
  }
  if (analogRead(A0)>500){
=======
void loop() {  
  digitalWrite(10,HIGH);
  digitalWrite(11,LOW);
  if (digitalRead(13)==HIGH){
>>>>>>> ece32e8e01dd1d0b0b77305e7fbddd08dfa30815
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
