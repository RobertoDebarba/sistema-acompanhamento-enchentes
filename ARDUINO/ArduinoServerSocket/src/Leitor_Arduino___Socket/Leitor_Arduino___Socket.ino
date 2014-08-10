#include <SPI.h>
#include <Ethernet.h>

byte mac[] = { 
  0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02 }; //Endereço MAC do Arduino
IPAddress ip(192,168,1, 177); //Endereço IP do Arduino, caso no seja tribuido pelo roteador
IPAddress gateway(192,168,1, 1);// Endereço Gataway(Opcional)
IPAddress subnet(255, 255, 0, 0);//Endereço SubnetMask(Opcional)

EthernetServer server(5661); //Seta a porta para o SocketServer

int pinPotenciometer = 0;
int pinRedLed = 2;
int pinYellowLed = 3;
int pinGreenLed = 4;
int pinBlueLed = 5;

byte serverStatus;
const byte SERVER_UP = 1;
const byte SERVER_CONNECTING = 2;
const byte SERVER_DOWN = 3;
const byte SENDING_DATA = 4;



void setup() {
  //Serial.begin(9600);
  
  pinMode(pinRedLed, OUTPUT); // Seta a porta do led vermelho como saída
  pinMode(pinYellowLed, OUTPUT); // Seta a porta do led amarelo como saída
  pinMode(pinGreenLed, OUTPUT); // Seta a porta do led verde como saída
  pinMode(pinBlueLed, OUTPUT); // Seta a porta do led vermelho como saída
  
  //Condicional que inicia a conexao com a internet
  Serial.println("Trying to get an IP address using DHCP");
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    serverStatus = SERVER_CONNECTING;
    // initialize the ethernet device not using DHCP:
    Ethernet.begin(mac, ip, gateway, subnet);
  } else {
    serverStatus = SERVER_UP;
    statusServerLed();
  }
  // print your local IP address:
  Serial.print("My IP address: ");
  ip = Ethernet.localIP();
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    // print the value of each byte of the IP address:
    Serial.print(ip[thisByte], DEC);
    Serial.print("."); 
  }
  server.begin();
 
}

void loop(){
 EthernetClient client = server.available();
  if (client) {
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        Serial.write(c);
        client.println(readPotenciometer());
        receivingSendingMessage();
      }
    }
  }
}

/**
  *Faz a leitura do potenciometro
  *<p>
  *<b>Exemplo </p>
  *<code> readPotenciometer(); </code>
  *<p>
  *@return retorna o valor de leitura do potenciometro
  *
  *@author Luan
  *@version 1.0
*/
int readPotenciometer() { 
  return analogRead(pinPotenciometer);;
}
  
/**
  *Faz o led acender de acordo com o status do server socket
  *<p>
  *<b>Exemplo: </p>
  *<code> statusServerLed(); </code>
  *<p>
  *
  *@author Luan
  *@version 1.0
*/
void statusServerLed() {
  switch (serverStatus) {
    case SERVER_UP:
      statusServerLedUp(pinGreenLed);
      statusServerLedDown(pinYellowLed, pinRedLed);
      break;
    case SERVER_CONNECTING:
      statusServerLedUp(pinYellowLed);
      statusServerLedDown(pinGreenLed, pinRedLed);
      break;
    case SERVER_DOWN:
      statusServerLedUp(pinRedLed);
      statusServerLedDown(pinGreenLed, pinYellowLed);
      break;
  }
} 

/**
  *Acende o led de acordo parametro passado; <br>
  *<p>
  *<b>Exemplo: </p>
  *<code> statusServerLedUp(pinGreenLed); </code>
  *</p>
  *@param setPin seta o pino do que sera aceso 
  *
  *@author Luan
  *@version 1.0
*/
void statusServerLedUp (int setPin) {
  digitalWrite(setPin, HIGH);
}

/**
  *Apaga os leds de acordo com o status do server socket; <br>
  *<p>
  *<b> Exemplo: </p>
  *<code> statusServerLedDown(pinYellowLed, pinRedLed); </code>
  *<p>
  *@param setPin1 seta o pino do led que sera apagado
  *@param setPin2 seta o pino do led que sera apagado
  *
  *@author Luan
  *@version 1.0
*/
void statusServerLedDown (int setPin1,int setPin2) {
  digitalWrite(setPin1, LOW);
  digitalWrite(setPin2, LOW);
}


/**
  *Faz o led azul piscar quando houver uma requisicao do client socket
  *<p>
  *<b> Exemplo: </p>
  *<code> receivingSendingMessage(); </code>
  <p>
  *
  *@author Luan
  *@version 1.0
*/
void receivingSendingMessage(){
  digitalWrite(pinBlueLed, HIGH);
  delay(300);
  digitalWrite(pinBlueLed, LOW); 
}



