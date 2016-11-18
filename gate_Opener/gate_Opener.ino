
void setup() {
  Serial.begin(9600);
  pinMode(8, OUTPUT);
  pinMode(9, OUTPUT);
  pinMode(3, INPUT);
  pinMode(4, INPUT);
  pinMode(6, INPUT);
  digitalWrite(9,HIGH);
  digitalWrite(8,HIGH);
}
void loop() {/*
  if (digitalRead(4)) {
    if (analogRead(A1) > 500) {
      Serial.println("9!");
      digitalWrite(9, LOW);
    } else if(!digitalRead(4)) {
      digitalWrite(9, HIGH);
    }
  } else {
    digitalWrite(9, HIGH);
  }
  
  if (digitalRead(3)) {
  if (analogRead(A0) > 500) {
      Serial.println("8!");
      digitalWrite(8, LOW);
  }else if(!digitalRead(3)) {
      digitalWrite(8, HIGH);
    }
  } else {
    digitalWrite(8, HIGH);
  }
  */
  if (!digitalRead(4)){
    digitalWrite(9,HIGH);
  }
  if (!digitalRead(3)){
    digitalWrite(8,HIGH);
  }
  if (analogRead(A0)>500){
    if (digitalRead(4)){
      Serial.println("Open");
      digitalWrite(9,LOW);
    
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
