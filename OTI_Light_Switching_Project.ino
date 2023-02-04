#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#define LED D7

/* esp8266 credentials */
WiFiClient wifiClient;
char* ssid = "RCA-WiFii";
char* passwd = "@rca@2023";
const char* host = "https://projects.benax.rw";

/*
  patterns
  0 - orange
  1 - red
  2 - flash simultaneously
  3 - fade simultaneously
  4 - flash orange
  5 - flash red
  6 - fade orange
  7 - fade red
  99 - none
  100 - all
*/

int pattern = 0;

/* fading variables */
int brightness = 0;    // how bright the LED is
int fadeAmount = 7;    // how many points to fade the LED by

void setup() {
  pinMode(D7, OUTPUT); //green for connection
  digitalWrite(D7, LOW);
  Serial.begin(9600);
  connectToWiFi();
  // server.on("/", [](){
  //     server.send_P(200, "text/html", webpage);
  //     if(server.arg("pattern")){
  //       pattern = server.arg("pattern").toInt();
  //     }
  //     else {
  //       pattern = 0;
  //     }
  //   }
  // );
  // server.begin();
  delay(1000);
}

void connectToWiFi(){
  WiFi.mode(WIFI_OFF); //This prevents reconnection issue
  delay(1000);
  WiFi.mode(WIFI_STA); //This hides the viewing of ESP as wifi hotspot
  // WiFi.begin(ssid, passwd); //Connect to your WiFi router
  WiFi.begin("Benax-WiFi(2.4G)","Rc@Nyabihu2023");   
  while (WiFi.status() != WL_CONNECTED){
    delay(1000);
    Serial.print(".");
  }
  Serial.println("Connected To benax !");
}

void processResponse(){
  HTTPClient http;
  String Link = "http://iot.benax.rw/projects/608294f70034decc51359fdaa125255f/oti/get_status.php";
  http.begin(wifiClient,Link);     //Specify request destination
  int httpCode = http.GET();            //Send the request
  String payload = http.getString();    //Get the response payload
  Serial.println(httpCode);
  Serial.println("> "+payload);
  if(payload == "ON"){
    digitalWrite(LED,LOW);
  }else{
    digitalWrite(LED,HIGH);
  }    //Print request response payload
  http.end();  //Close connection
}

void getStatus( const char* filepath){
  Serial.println("Getting status... ");
  wifiClient.println("GET " + (String)filepath + " HTTP/1.1");
  wifiClient.println("Host: " + (String)host);
  wifiClient.println("User-Agent: ESP8266/1.0");
  wifiClient.println("Content-Type: application/txt");
  wifiClient.println("Content-Length: 0");
  wifiClient.println();
  getFeedback("Success");
}

void getFeedback(String success_msg){
  String datarx;
  while (wifiClient.connected()){
    String line = wifiClient.readStringUntil('\n');
    if (line == "\r") {
      break;
    }
  }
  Serial.print(wifiClient.available());
  while (wifiClient.available()){
    datarx += wifiClient.readStringUntil('\n');
    Serial.println(datarx);
  }
  
  if(datarx.indexOf(success_msg) >= 0){
    Serial.println("Data Transferred.\n"); 
  } else {
    Serial.println("Data Transfer Failed.\n"); 
  }
  datarx = ""; 
}

// the loop function runs over and over again forever
void loop() {
  processResponse();
  int analogValue = analogRead(A0);
  Serial.print("Analog reading: ");
  Serial.print(analogValue);   // the raw analog reading
  delay(1000);
}
