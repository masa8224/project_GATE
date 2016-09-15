int up = 9;
int down = 8;
int upButton = 7;
int downButton = 6;
int IR1 = 5;
int ls1 = 4;
int ls2 = 3;
void setup() {
  Serial.begin(9600);
  pinMode(down, OUTPUT);
  pinMode(up, OUTPUT);
  pinMode(upButton, INPUT);
  pinMode(downButton, INPUT);
  pinMode(IR1, INPUT);
  pinMode(ls1, INPUT);
  pinMode(ls2, INPUT);
}

void loop() {
  if (digitalRead(4)==HIGH) {
    //Serial.println("ls up 1");
    if (digitalRead(IR1)) {
      if (digitalRead(upButton)) {
        Serial.println("up!");
        digitalWrite(up, LOW);
      } else {
        digitalWrite(up, HIGH);
      }
    } else {
      digitalWrite(up, LOW);
    }
  } else {
    digitalWrite(up, LOW);
  }
  //
  if (digitalRead(3)==HIGH) {
    //Serial.println("ls down 1");
    if (digitalRead(downButton)) {
      Serial.println("down!");
      digitalWrite(down, LOW);
    } else {
      digitalWrite(down, HIGH);
    }
  } else {
    digitalWrite(down, LOW);
  }
}
