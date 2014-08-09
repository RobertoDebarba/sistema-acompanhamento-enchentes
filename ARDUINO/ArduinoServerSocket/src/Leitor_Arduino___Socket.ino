/*
 Chat  Server
 
 A simple server that distributes any incoming messages to all
 connected clients.  To use telnet to  your device's IP address and type.
 You can see the client's input in the serial monitor as well.
 Using an Arduino Wiznet Ethernet shield. 
 
 Circuit:
 * Ethernet shield attached to pins 10, 11, 12, 13
 * Analog inputs attached to pins A0 through A5 (optional)
 
 created 18 Dec 2009
 by David A. Mellis
 modified 9 Apr 2012
 by Tom Igoe
 
 */

#include <SPI.h>
#include <Ethernet.h>

// Enter a MAC address and IP address for your controller below.
// The IP address will be dependent on your local network.
// gateway and subnet are optional:
byte mac[] = { 
  0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192,168,1, 177);
IPAddress gateway(192,168,1, 1);
IPAddress subnet(255, 255, 0, 0);

int PinoPotenciometro = 0;
int PinoLed = 6;

//Inicializa o servidor web na porta 80
EthernetServer server(80);
void setup() {
  
  // Open serial communications and wait for port to open:
  pinMode(PinoLed, OUTPUT); // Seta a porta do led como saída
  // this check is only needed on the Leonardo:


  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    // initialize the ethernet device not using DHCP:
    Ethernet.begin(mac, ip, gateway, subnet);
  }
  ip = Ethernet.localIP();
  server.begin();
 
}

void loop(){
  digitalWrite(PinoLed, LOW);
 EthernetClient client = server.available();
  if (client) {
    Serial.println("new client");
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        Serial.write(c);
        client.println(efetuarLeitura());
        piscaLed();
      }
    }
  }
}

int efetuarLeitura() { 
  int retornoLeitura = analogRead(PinoPotenciometro); //Recebe o valor do potenciômetro
  return retornoLeitura;
}
  
void piscaLed() {
  digitalWrite(PinoLed, HIGH);
  delay(300);
  digitalWrite(PinoLed, LOW);
} 



