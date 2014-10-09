
#include <SPI.h>
#include <Ethernet.h>
#define triggerPin 3
#define echoPin 2


byte mac[] = { 
  0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02 }; //Endereço MAC do Arduino
IPAddress ip(192,168,1, 177); //Endereço IP do Arduino, caso no seja tribuido pelo roteador
IPAddress gateway(192,168,1, 1);// Endereço Gataway(Opcional)
IPAddress subnet(255, 255, 0, 0);//Endereço SubnetMask(Opcional)

EthernetServer server(5661); //Seta a porta para o SocketServer

int pino_d = A5;
int pinLed = 4;

void setup() {
  //Serial.begin(9600);

  pinMode(pino_d, INPUT);//pino sensor de chuva
  pinMode(triggerPin, OUTPUT); //pino trigger sensor ultrasonico
  pinMode(echoPin, INPUT); //pino echo sensor ultrasonico
  pinMode(pinLed, OUTPUT); // Seta a porta do led vermelho como saída
 

  //Condicional que inicia a conexao com a internet
  //Serial.println("Conectando via DHCP");
  if (Ethernet.begin(mac) == 0) {
   // Serial.println("Falha para conectar utilizando DHCP");
    Ethernet.begin(mac, ip, gateway, subnet);
  } 
  // escreve o ip local
 // Serial.print("IP Local: ");
  ip = Ethernet.localIP();
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
  //  Serial.print(ip[thisByte], DEC);
   // Serial.print("."); 
  }
  server.begin();

}

void loop(){
EthernetClient client = server.available();
 if (client) {   
    if (client.available()) {   
     // Serial.println("leitura efetuada");   
      client.println(JSONLeituras());
      piscaLed();
    }
  }
}
/**
 *Faz a leitura do sensor de chuva e retorna o estado da chuva
 *<p>
 *<b> Exemplo: </p>
 *<code> leituraChuva(); </code>
 *<p>
 *
 *@return Valor do estado da chuva;
 *
 *@author Luan
 *@version 1.0
 */
String leituraChuva (){
  int valorLeitura = analogRead(pino_d);
  int valorRetorno;
  if(valorLeitura>900 && valorLeitura<1023){
    valorRetorno = 0;//sem chuva
  } else if (valorLeitura>450 && valorLeitura<900){
    valorRetorno = 1; //chuva moderada
  } else if (valorLeitura>0 && valorLeitura<450){
    valorRetorno = 2;//chuva intensa
  } 
  return String(valorRetorno);
}

/**
 *Concatena strings para criar o arquivo JSON que retornar ao cliente
 *<p>
 *<b> Exemplo: </p>
 *<code> JSONLeituras()(); </code>
 *<p>
 *
 *@return String no formato JSON;
 *
 *@author Luan
 *@version 1.0
 */
String JSONLeituras () {
  String inicio = "{\"nivelChuva\": ";
  String meio = ", \"nivelRio\": ";
  String fim = " }";
  String leituras = inicio+leituraChuva()+meio+leituraSensorUltrasonco()+fim;
  return leituras;
}

/**
 *Faz o led vermelho piscar quando houver uma requisicao do client socket
 *<p>
 *<b> Exemplo: </p>
 *<code> piscaLed(); </code>
 *<p>
 *
 *@author Luan
 *@version 1.0
 */
void piscaLed(){
  digitalWrite(pinLed, HIGH);
  delay(300);
  digitalWrite(pinLed, LOW); 
}

/**
 *Faz a leitura do sensor ultrasonico
 *<p>
 *<b> Exemplo: </p>
 *<code>  leituraSensorUltrasonco(); </code>
 *<p>
 *
 *@return Distancia do sensor e o objeto
 *
 *@author Luan
 *@version 1.0
 */

String leituraSensorUltrasonco(){
  digitalWrite(triggerPin, LOW);
  delayMicroseconds(2);
  digitalWrite(triggerPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(triggerPin, LOW);
  
  // O sensor calcula o tempo gasto entre o envio e o recebimento
  // do sinal e retorna um pulso com esta duração
  long duration = pulseIn(echoPin, HIGH);

  // Converte o tempo para distancia em centimetros
  float cm = microsecondsToCentimeters(duration);
  
  // Informa a distancia na serial
  
  char leitura[100];
     
  dtostrf(cm,2,2,leitura);
  
 return leitura;
}

float microsecondsToCentimeters(long microseconds){
  // Converte o tempo de microsegundos para segundos
  float seconds = (float) microseconds / 1000000.0;
  // Com a velocidade do som de 340m/s calcula-se a
  // distancia percorrida
  float distance = seconds * 340;
  // Divide o resultado por dois pois o tempo é calculado
  // considerando a ida e a volta do sinal  
  distance = distance / 2;
  // Converte o resultado em metros para centimetros
  distance = distance * 100;
  
  return distance;
}

