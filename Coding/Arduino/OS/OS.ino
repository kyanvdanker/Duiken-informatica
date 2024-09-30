#include <LiquidCrystal.h>

// Define the pin for the pressure sensor
const int sensorPin = 2;  // Pin where the pressure sensor is connected
float pressure;  // Variable to store the pressure in bar
float depth;     // Depth in meters
int ndl;         // No-Decompression Limit in minutes
int decoStopDepth = 3;  // Depth for the first decompression stop (default is 3 meters)
int totalDecoTime = 0;  // Total decompression time required
unsigned long startTime;  // Start time for the dive
unsigned long currentTime;  // Current time in milliseconds

// Calibration constants (depends on your sensor)
// These constants will vary depending on your sensor's specifications.
const float minVoltage = 0.8;  // Minimum voltage output from the sensor at minimum pressure
const float maxVoltage = 4.5;  // Maximum voltage output from the sensor at maximum pressure
const float minPressure = 0.0;  // Minimum pressure in bar
const float maxPressure = 5.0;  // Maximum pressure in bar

// Create an instance of the LCD
LiquidCrystal lcd(8, 9, 10, 11, 12, 13); // Adjust pin numbers as needed

void setup() {
  // Initialize serial communication for output
  Serial.begin(9600);
  
  // Set the start time of the dive (when the Arduino starts)
  startTime = millis();

  // Initialize the LCD
  lcd.begin(16, 2); // Set the dimensions of the LCD (16 columns, 2 rows)
  lcd.print("Dive Info"); // Display a welcome message
}

void loop() {
  // Read the analog value from the sensor
  int sensorValue = analogRead(sensorPin);
  
  // Convert the analog value (0-1023) to voltage (0-5V)
  float voltage = sensorValue * (5.0 / 1023.0);

  // Convert the voltage to pressure in bar based on sensor calibration
  pressure = ((voltage - minVoltage) * (maxPressure - minPressure) / (maxVoltage - minVoltage)) + minPressure;

  // Calculate depth in meters (assuming 1 bar = 10 meters water depth)
  depth = (pressure - 1.0) * 10.0;  // Subtract 1.0 bar for surface pressure

  // Calculate the dive time in minutes and seconds
  currentTime = millis();
  int diveTimeSeconds = (currentTime - startTime) / 1000;  // Convert milliseconds to seconds
  int diveMinutes = diveTimeSeconds / 60;  // Get the minutes
  int diveSeconds = diveTimeSeconds % 60;  // Get the remaining seconds

  // Calculate No-Decompression Limit (NDL) based on depth (simplified model)
  if (depth < 12) {
    ndl = 200 - (depth * 10);  // Rough NDL estimate for shallow depths
  } else if (depth < 30) {
    ndl = 120 - (depth * 3);   // For medium depths
  } else {
    ndl = 40 - (depth);        // For deeper depths
  }

  // Display depth, dive time, and NDL on the LCD
  lcd.clear();  // Clear the LCD screen
  lcd.setCursor(0, 0);  // Set cursor to the first row
  lcd.print("Depth: ");
  lcd.print(depth);
  lcd.print("m");

  lcd.setCursor(0, 1);  // Set cursor to the second row
  lcd.print("Time: ");
  lcd.print(diveMinutes);
  lcd.print("m ");
  lcd.print(diveSeconds);
  lcd.print("s");

  // Display the data on Serial Monitor
  Serial.print("Depth: ");
  Serial.print(depth);
  Serial.println(" meters");

  Serial.print("Dive Time: ");
  Serial.print(diveMinutes);
  Serial.print(" minutes and ");
  Serial.print(diveSeconds);
  Serial.println(" seconds");

  if (ndl > 0 && diveMinutes < ndl) {
    Serial.print("NDL: ");
    Serial.print(ndl - diveMinutes);  // Show remaining no-decompression time
    Serial.println(" minutes left before deco stops are required.");
  } else {
    Serial.println("Decompression stop required!");

    if (totalDecoTime == 0) {
      totalDecoTime = (depth - decoStopDepth) * 2;  // Simplified formula for deco time
    }
    
    Serial.print("Total decompression time required: ");
    Serial.print(totalDecoTime);
    Serial.println(" minutes.");

    int decoStepDepth = depth;  // Start at the current depth
    while (decoStepDepth > decoStopDepth) {
      int stopTime = (decoStepDepth - decoStopDepth) * 2;  // Simplified stop time calculation
      
      Serial.print("Stop at depth: ");
      Serial.print(decoStepDepth);
      Serial.print(" meters for ");
      Serial.print(stopTime);
      Serial.println(" minutes.");
      
      decoStepDepth -= 3;  // Decrease stop depth by 3 meters after each stop
    }

    Serial.print("Final stop at ");
    Serial.print(decoStopDepth);
    Serial.println(" meters.");
  }

  // Small delay before the next reading
  delay(1000);  // Delay of 1 second to reduce the serial monitor spam
}
