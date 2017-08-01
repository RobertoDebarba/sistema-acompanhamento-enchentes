# Sistema Online de Acompanhamento de Enchentes e Inundações

Projeto submetido como TCC ao Curso Técnico de Informática com Habilitação em Desenvolvimento de Software.  
CEDUP Timbó, 2014.

## Principais recursos

* Régua automatizada de leitura do nível do rio
* Nível do rio atual
* Estado de inundação atual
* Histórico do nível do rio
* Galeria colaborativa
* Previsão do tempo
* Mapa com o estado de inundaço
* Sites úteis
* Interface WEB
* Interdace WEB mobile
* Aplicativo móvel
* Notificações de alerta programáveis no aplicativo

## Componentes

### Arduino

Resposável por realizar a medição do nível do rio e enviar para o servidor via Socket.

### Servidor

Responsável por gerar a imagem de status de inundação com base no nível do rio e dados de relevo obtidos da API do Google Maps.
Também abre um porta socket para o Arduino enviar os dados de leitura.

### Web

Interface WEB para leitura dos dados gerados.

### Móvel

Aplicativo móvel para leitura dos dados gerados.

### Capturas de tela

#### Web

![web1](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-1.png)
![web2](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-2.PNG)
![web3](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-3.PNG)
![web4](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-4.PNG)
![web5](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-5.PNG)
![web6](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-6.PNG)
![web7](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-7.PNG)
![web8](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-8.PNG)

#### Web Mobile

![mobile-web-1](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-mobile-1.PNG)
![mobile-web-2](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-mobile-2.PNG)
![mobile-web-3](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-mobile-3.PNG)
![mobile-web-4](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-mobile-4.PNG)
![mobile-web-5](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/web-mobile-5.PNG)

#### Mobile

![mobile1](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/mobile-1.png)
![mobile2](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/mobile-2.png)
![mobile3](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/mobile-3.png)
![mobile4](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/mobile-4.png)
![mobile5](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/mobile-5.png)
![mobile6](https://github.com/RobertoDebarba/SAEnchentes/blob/master/screenshot/mobile-6.png)

## Autores
* [Jonathan Eli Suptitz](https://github.com/jonnymohamed)
* [Luan Carlos Purim](https://github.com/Feenux)
* [Roberto Luiz Debarba](https://github.com/RobertoDebarba)
