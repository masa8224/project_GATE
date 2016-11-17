
void setup() {
  Serial.begin(9600);
  pinMode(8, OUTPUT);
  pinMode(9, OUTPUT);
  pinMode(3, INPUT);
  pinMode(4, INPUT);
  pinMode(6, INPUT);
}

void loop() {
  if (digitalRead(4)) {
    if (analogRead(A0) > 500) {
      Serial.println("9!");
      digitalWrite(9, LOW);
    } else if(!digitalRead(4)) {
      digitalWrite(9, HIGH);
    }
  } else {
    digitalWrite(9, HIGH);
  }
  
  if (digitalRead(3)) {
  if (analogRead(A1) > 500) {
      Serial.println("8!");
      digitalWrite(8, LOW);
  }else if(!digitalRead(3)) {
      digitalWrite(8, HIGH);
    }
  } else {
    digitalWrite(8, HIGH);
  }
  

}
