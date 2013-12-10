#include <WiFi.h>
#include <String.h>
#include <SPI.h>
#include <SD.h>
#include <EmonLib.h>
#include <DS1307RTC.h>
#include <Time.h>
#include<Wire.h>

// Device Stuff
int deviceID = 5555; 
int toggleState = 0;

//WiFi Variables  
String SecurityType; 
String SSIDNAME;
String PASS; 
String INDEX;
int status = WL_IDLE_STATUS;
char server[] = "yoursmartsocket.com";
WiFiClient client;


// Power Stuff
EnergyMonitor emon1; 
float currentCalibration = 59.7;
double current; 
int voltage = 120; 


// Pin Stuff 
int Relay = 22;
int Red = 44; 
int Yellow = 42;
int Green = 40;

// Time Stuff 
tmElements_t time;


const int chipSelect = 4; // For Mega

void setup() // This is only run once at start up 
{
  Serial.begin(9600);
  pinMode(53, OUTPUT);
  
  pinMode(Relay, OUTPUT);
  pinMode(Red, OUTPUT);
  pinMode(Yellow, OUTPUT);
  pinMode(Green, OUTPUT);
  digitalWrite(Relay, LOW);
  delay(1000);
  emon1.current(1, 59.7); // 59.7 is calculated after performing a series of measurements 
  Serial.println("Starting setup");
  // Verify WiFi Shield is connected 
//  unsigned long start = millis(); 
//  while (WiFi.status() == WL_NO_SHIELD )
//  {
//     if ((millis() - start) > 30000)
//    {
//      Serial.println("WiFi shield not Present");
//      while(true);
//    }
//    delay(500);
//  }
  // Verify SD Card is in Place
  if (!SD.begin(chipSelect)) 
  {
    Serial.println(F("Card failed, or not present"));
    // don't do anything more:
    return;
  }

  // Demo
  getConfiguration();

  PinToggles();
  Serial.println(F("Done with setup"));

}

void loop()
{
  delay(1000);
  tmElements_t tm;
  // Connect To network
  ConnectToNetwork(); 
  // Read Current
  current =  emon1.calcIrms(1480);
  Serial.print(F("Current in Amps: "));
  Serial.println(current);
  // Get time
  RTC.read(tm);
  String time = ""; 
  time += tmYearToCalendar(tm.Year);
  time += tm.Month;
  if (tm.Day >= 0 && tm.Day < 10)
  {
    time += '0'; 
  } 
  time += tm.Day;
  time += tm.Hour;
  time += tm.Minute;
  time += tm.Second;
  // Assume voltage is 120V
  // Log Data
 // LogData( time, current, voltage, "LogFile.csv");
  Serial.println(F("Checking to see if connected"));
  if ( status == WL_CONNECTED )
  {
     digitalWrite(Green, HIGH);
      //Send Data
     sendData(current, voltage, time, toggleState); 
    // Check to see if unsent data to be sent 
    // Download Calendar
    getSchedule();
    // get toggle state
    toggleState = getToggleState(); 
    Serial.print(F("Toggle State From server is: "));
    Serial.println(toggleState);
  }
  else // Not Connected 
  {
   // LogData( time, current, voltage, "Unsent.csv");
  }
  if (toggleState == 2)
  {
    Serial.print(F("Toggle State From Schedule is: "));
    ReadFromSchedule();    
    Serial.println(toggleState);
  }
  PinToggles();
}

void getConfiguration() 
{
  File Config = SD.open("Config.txt");
  SecurityType = getLine(Config);
  Config.read(); // Reads in New Line sets up for next line
  SSIDNAME = getLine(Config);
  Config.read(); // Reads in New Line sets up for next line
  PASS = getLine(Config);
  Config.read(); // Reads in New Line sets up for next line
  INDEX = getLine(Config);
  //Serial.print(getLine(Config));
  Config.close(); 
}

//Reads in a line from a file and outputs it as a string
String getLine(File FileName)
{
  String line = "";
  char buf = 'a';  
  while ( FileName.available() && buf != '\n'&& buf != '\r' )
  {
    buf = FileName.read();
    line += buf;
  }
  //Serial.println(line); 
  return line; 
}

void LogData(String time, double current, int voltage, char LogFile[])
{
  String DataString;
  DataString += time;
  DataString += ','; 
  DataString += DoubleToString(current);
  DataString += ',';
  DataString += voltage;
  
  File DataLog = SD.open(LogFile, FILE_WRITE);
  if (DataLog)
  {
    DataLog.println(DataString);
    DataLog.close();
  }
  DataLog.close();
}

String DoubleToString(double Number)
{
  char buffer [10]; 
  
  return dtostrf(Number, 1 , 2, buffer);
}

void ReadFromLogFile(char LogFile[])
{
  int i;
  String Time;
  String Current;
  String Voltage;
  String Line; 
  File LFile = SD.open(LogFile);
  while(LFile.available())
  {
    i = 0; 
    Line = getLine(LFile);
    LFile.read();
    char buff[Line.length()];
    Line.toCharArray(buff,Line.length());
    if (i <  Line.length() )
    {

      while ( buff[i] != ',' )
      {
        Time += buff[i];
        i++; 
      }

      i++; // Skip over comma
      while ( buff[i] != ',' )
      {
        Current += buff[i];
        i++; 
      }

      i++; // Skip over comma
      while ( i < Line.length() )
      {
       
        Voltage += buff[i];
        i++; 
      }
//    sendData(double current, int voltage, String Time, int toggleState);   
    Time = "";
    Current = "";
    Voltage = "";  
    }
  }
  LFile.close();
  SD.remove(LogFile); // Delete once files are read and sent
}

int ReadFromSchedule()
{
  tmElements_t tm;
  RTC.read(tm);
  int i; 
  File SFile = SD.open("Schedule.txt");
  String Line;
  String CTime = "";
  String StartTime;
  String EndTime;
  CTime += now(); 
  while ( SFile.available() )
  {
    i = 0;
    Line = getLine(SFile);
    SFile.read(); 
    char buff[Line.length()];
    Line.toCharArray(buff,Line.length());
    if (i <  Line.length() )
    {
      while ( buff[i] != ';' )
      {
        StartTime += buff[i];
        i++; 
      }
      i++;

      while ( i < Line.length() )
      {
        EndTime += buff[i];
        i++; 
      }
      // Handle Start and End time
      if ( CTime >= StartTime && CTime < EndTime )
      {
        toggleState = 1; 
        return -1;
      }
      //
      StartTime = "";
      EndTime = "";
      i = 0; 
    }
  }
  SFile.close();
  toggleState = 0;
  return -1;
}

void ConnectToNetwork()
{
  Serial.println(F("Attempting to Connect to wireless network"));
  char ssid[SSIDNAME.length()];
  char pass[PASS.length()];
  int index;
  
  SSIDNAME.toCharArray(ssid, SSIDNAME.length());
  PASS.toCharArray(pass, PASS.length());
 
  for ( int i = 0; i < 2; i++ )
  {
    if( status != WL_CONNECTED) 
    {
      // WPA2 
     
      
      //if ( SecurityType == "WPA2" )
      //{
        status = WiFi.begin(ssid,pass);
      //}
      // if no security
      if ( SecurityType == "None" ) 
      {
        Serial.println(F("in NONE"));
        status = WiFi.begin(ssid);
      }
      else if ( SecurityType == "WEP" )
      {
        Serial.println(F("in WEP"));
        status = WiFi.begin(ssid,INDEX.toInt(),pass);
      }   
      delay(10000); //waits 10 seconds for connections
       
    }
  }
  printWifiStatus(); 
}

// Only for debuging 
void printWifiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print(F("IP Address: "));
  Serial.println(ip);


}

int sendData(double current, int voltage, String Time, int toggleState) 
{
  String phpSend; 
  int mAmps = current * 1000; 
  String phpStart = "GET /SmartSocket/arduino_readings?id=";
  phpSend = phpStart; 
	//Make connection with server
  if (client.connect(server, 80)) 
  {
    Serial.println(F("connected to server to send data"));
  
    // Send readings to server
 
    phpSend += deviceID;
    phpSend += "&I=";
    phpSend += mAmps; 
    phpSend += "&V=";
    phpSend += voltage;
    phpSend += "&time=";
    phpSend = phpSend + Time;
    phpSend += "&state=";
    phpSend += toggleState; 
  
    //Serial.println(phpSend);
    client.println(phpSend);
    client.println(F("Host: www.yoursmartsocket.com"));
    client.println(F("Connection: close"));
  
    client.println();


  }
  else
  { 
    Serial.println(F("Unable to send data"));
  }
  client.flush(); 
  client.stop(); 
  delay(500);
}

int getToggleState()
{
  String phpSend; 
  String phpToggleStart = "GET /SmartSocket/arduino_state?id="; 
  client.stop();
  // 1 = on 2 = USE scheduler  0 = OFF 
   phpSend = phpToggleStart; 
  if (client.connect(server, 80) && status == WL_CONNECTED ) 
  {
       
        Serial.println(F("connected to server to get toggle state"));
        client.println(phpToggleStart + (String)deviceID);
        client.println(F("Host:www.yoursmartsocket.com"));
        client.println(F("Connection: close"));
        client.println();
  


    
    delay(50); 
      int count = 0;
      char c; 
      while(client.connected() && !client.available() && count < 10000 ) 
      {
        delay(1); 
        count++; 
      }
      if (client.connected() || client.available())
      { //connected or data available
        c = client.read();
        c = client.read(); //gets byte from wifi buffer
      }
      client.flush(); 
      client.stop(); 
      return c - '0';   
  }
  return toggleState; // No Change
} 

// toggles various display leds 
void PinToggles()
{
  //Led Stuff

  //Display Connected
  if (status == WL_CONNECTED)
  {
    digitalWrite(Green, HIGH);
  }
  else
  {
    digitalWrite(Green, LOW);
  }
  if (toggleState == 1) // ON 
  {
    digitalWrite(Red,HIGH);
    digitalWrite(Relay,HIGH);
    digitalWrite(Yellow,LOW);
  }
  if ( toggleState == 0 ) // OFF
  {
    digitalWrite(Yellow,HIGH);
    digitalWrite(Red,LOW);
    digitalWrite(Relay,LOW);
  }
  
  //Dispaly Toggle On
  //Display Toggle Off
}

void getSchedule()
{
  SD.remove("Schedule.txt"); // Delete old schedule
  Serial.println(F("Attempting to get Schedule"));
  String phpSend;
  String DataString = "";  
  File Schedule = SD.open("Schedule.txt", FILE_WRITE);
  String phpToggleStart = "GET /SmartSocket/ScheduleFiles/"; 
  phpToggleStart += deviceID;
  phpToggleStart += ".txt";
  if (client.connect(server, 80) && status == WL_CONNECTED ) 
  {
    Serial.println(F("connected to server to get Schedule"));
    client.println(phpToggleStart );
    client.println(F("Host:www.yoursmartsocket.com"));
    client.println(F("Connection: close"));
    client.println();
    delay(50); 
    int count = 0;
    char c = ' '; 
    while(client.connected() && !client.available() && count < 10000 ) 
    {
      delay(1); 
      count++; 
    }
    while ( client.available() && c != '-1' )
    { //connected or data available
      DataString = "";
      if (c != '\n')
      {
        c = client.read(); 
        DataString += c; 
      }
      Schedule.println(DataString);
      c = client.read();
    }
    client.flush(); 
    client.stop(); 
    Schedule.close();
  }
 }

 
