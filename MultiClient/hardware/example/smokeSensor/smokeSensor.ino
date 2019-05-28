
// auther : yongming.li

int sensorPin = A0;    // select the input pin for the potentiometer
int led = 11;      // select the pin for the LED
int alarm = 10;
int bee = 9;
int sensorValue = 0;  // variable to store the value coming from the sensor

void setup() {
  // declare the ledPin as an OUTPUT:
  pinMode(led, OUTPUT);  
  pinMode(bee, OUTPUT);  
  pinMode(alarm, INPUT);  
  digitalWrite(led, LOW); 
  digitalWrite(led, HIGH); 
  Serial.begin(9600);
}

void loop() {
int val;
int dat;
val=analogRead(0);
Serial.println(val);
 
  int state = 0; 
  state = digitalRead(alarm);

  // check if the pushbutton is pressed.
  // if it is, the buttonState is HIGH:
  if (state == LOW) {     
    // turn LED on:    
    Serial.println("alarm"); 
    digitalWrite(bee, HIGH); 
  } 
  else
  {
    digitalWrite(bee, LOW);
  }
delay(500);           
}
