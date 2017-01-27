
void setup() {
  Serial.begin(9600);
  pinMode(8, OUTPUT);
  pinMode(9, OUTPUT);
  pinMode(6, INPUT_PULLUP);
  pinMode(3, INPUT);
  pinMode(4, INPUT);
  pinMode(10, OUTPUT);
  pinMode(11, OUTPUT);
  pinMode(12, INPUT_PULLUP);

  pinMode(13, OUTPUT);
  digitalWrite(9, HIGH);
  digitalWrite(8, HIGH);
  digitalWrite(10, HIGH);
  digitalWrite(11, HIGH);
  if (!digitalRead(3)) {
    Serial.print("Close");
    digitalWrite(8, LOW);
    while (!digitalRead(3)) {}
    digitalWrite(8, HIGH);
  }
  
  Serial.println("init cmpl");
}
void loop() {
 
  digitalWrite(10, LOW);
  digitalWrite(11, HIGH);
  if (!digitalRead(12)) {
    Serial.println("recieve!");
    if (!digitalRead(4)) {
      Serial.println("Open");
      digitalWrite(9, LOW);
      digitalWrite(10, HIGH);
      digitalWrite(11, LOW);
      digitalWrite(13, HIGH);
      while (!digitalRead(4)) {}
      digitalWrite(9, HIGH);
      delay(2000);
      while(digitalRead(6)==LOW){}
      delay(2000);
        Serial.print("Close");
        digitalWrite(8, LOW);

      
      while (!digitalRead(3)) {}
      digitalWrite(8, HIGH);
    }
  }

  digitalWrite(13, LOW);
  /*
  if (digitalRead(3)){
    Serial.println("ls1");
    }
  if (digitalRead(4)){
    Serial.println("ls2");
    } */
}
