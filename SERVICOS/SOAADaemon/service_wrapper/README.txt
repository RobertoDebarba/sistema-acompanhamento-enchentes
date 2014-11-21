Instruções:

*** Iniciar
	sh bin/soaei-service start
		ou
	sh ./start-service
	
*** Parar
	sh bin/soaei-service stop
		ou
	sh ./stop-service
	
*** Console
	sh bin/soaei-service console
		ou
	sh ./console-start
	
*** Atualizar Pacote

	.
	├── bin
	│   ├── lib
	│   ├── libwrapper.so
	│   ├── soaei-service
	│   ├── soaei-service.jar  <-------- Pacote .jar aqui
	│   ├── wrapper
	│   └── wrapper.jar
	├── conf
	│   └── wrapper.conf
	├── console-start.sh
	├── logs
	│   └── wrapper.log
	├── start-service.sh
	└── stop-service.sh


*** Copyright Roberto Luiz Debarba <roberto.debarba@gmail.com> | 2014