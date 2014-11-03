var alertaAtivo;// verificador de timer do alerta ativo ou nao
    	var timer; // variavel que recebe o timer de alertas

    	var estado; // array com estado de alerta da defesa civil
    	var leituras;// array com leituras completas de mediçoes
    	
    	var dataArray = []; //array com data e nivel do rio
    	var chuva = []; // array com data e estado da chuva

    	getEstadoAlerta();
    	getLeituras(12);	
    
    	document.addEventListener("deviceready", onDeviceReady, false);
		
	    function onDeviceReady() {
	       
	      window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
	    }


	    function lerCfg(){
	    	window.resolveLocalFileSystemURL(cordova.file.applicationDirectory + "readme.txt", gotFile, fail);
	    }
	

	    function gotFS(fileSystem) {
	        fileSystem.root.getFile("readme.txt", {
	        	create: true,
	        	exclusive: false},
	        	gotFileEntry, fail);
	    }
	
	    function gotFileEntry(fileEntry) {
	        fileEntry.createWriter(gotFileWriter, fail);
	        // fileEntry.file(readAsText, fail);
	    }
	
	    function gotFileWriter(writer) {
	    	writer.onwrite = function(evt) {
    			alert("checkpoint 4: write success!")
    		};
	           
	    }


	    function readAsText(file) {
	        var reader = new FileReader();
	        reader.onloadend = function(evt) {
	           alert(evt.target.result);
	        };
	    }

	    //erro de leitura ou escrita do arquivo
	    function fail(error) {
	        alert(error.code);
	    }
	    
	    /**
	     * Ativa o modo background e manten um timer de alerta
	     */
	    function ativarAlerta(sim){
	    	if(sim){
	    		timer = setInterval(function(){alerta();}, 1000*5*15);
	    		window.plugin.backgroundMode.enable();

	    		alertaAtivo = true;
	    	}
	    	else{
	    		clearInterval(timer);
	    		
	    		window.plugin.backgroundMode.disable();
	    		 
	    		alertaAtivo = false;
	    	}
	    }
	
	    // chamado quando clicado no botao "Abrir App" do alerta
        function alertaAbrirPrograma() {
            // do something
        }
    
	    /**
	     *  o alerta
	     */
	    function alerta() {
	    	navigator.notification.beep(3);
	        navigator.notification.confirm(
	           'Atenção! Água a caminho!',  
	            alertaAbrirPrograma,
	            'SAEmóvel Alerta',           
	            ['Abrir App','Ignorar']     
	        );
	    }	    	
		
		/**
		 * exibi o menu +
		 */
		function exibirMenuPlus(){
				$("#menuPlus").slideToggle('fast');
	    }
	    
	    /**
	     * abre a tela passada como parametro
	     * -apenas nome do arquivo php sem o .php
	     */
	    function alterarConteudo(tela){
	    	if(tela == "home"){	
	    		$( "#conteudo" ).hide();
	    		$("#alerta").show();
	    		$( "#mapaconteiner" ).show();		
	    	}
	    	else{
	    		$( "#conteudo" ).show();
	    		$( "#mapaconteiner" ).hide();
		    	$("#menuPlus").hide('fast');
		    	$("#alerta").hide();
			    $( "#conteudo" ).load( "./"+tela+".html"); 	
				
			}				
	    }
		
		/**
		 * obtem as leituras do php no servidor
		 */
	    function getLeituras(qtdLeituras){
	    	$.ajax({
                url: "http://localhost/jonathan/Projeto%20Web/final/funcoes.php/?getLeituras=?",
       			data: { 'qtdLeituras' : qtdLeituras},
                dataType:'jsonp',
                crossDomain: true,

                success: function(data){
                	setleituras(data);
                }
            });
	    }
	    
	    /**
		 * obtem alertas da defesa civil do php no servidor
		 */
        function getEstadoAlerta(){
         	$.ajax({
                url: "http://localhost/jonathan/Projeto%20Web/final/funcoes.php?getEstadoAlerta=?",
                dataType:'jsonp',
                crossDomain: true,

                success: function(data){
                	setEstado(data);
				}  
            });
            
         }
		
         function setEstado(dados){
         	estado = dados;
         	alteraBarraAlerta();
         }

         function setleituras(dados){
         	leituras = dados;  
         	alteraBarraAlerta();         	
         }
		
		/**
		 * cria um array com as leituras para o grafico
		 */
		function carregaLeituras(){
			dataArray = [];
			chuva = [];
			
			chuva[0] = ['Data','Chuva'];
			dataArray[0] = ['Data', 'Nivel do Rio'];
			
	    	var key;
			for(key in leituras) {
			  	if(leituras.hasOwnProperty(key)) {
			
				    var object = leituras[key];
				    
				    datacompleta =  object[0] + " "+  object[1];					
					
					$('#tabela').append('<tr><td>'+object[0]+" "+object[1] + '</td><td>'+object[2] + ' m</td><td>'+object[3] + '</td></tr>');
				  	
				  	if(key <= 6){
				  		chuva[chuva.length] = [datacompleta, parseInt(object[3])];
						dataArray[dataArray.length] = [datacompleta, parseInt(object[2])];
					}
				}
			}	
		}
			
		function setDados(data){
			dados = data;
		}
	
		/**
		 * altera o design da barra de alerta no rodapé
		 */
    	function alteraBarraAlerta(){	   		
    		medicoes = leituras[1];
    		
			if ((estado[0] == 0) & (estado[1] == 0)) {
				$("#alerta").toggleClass("button-assertive");
				$("#alerta").toggleClass("button-energized");
				$("#alerta").html('Nivel do rio: ' + medicoes[2] + 'm | Chuva' + medicoes[3]);
			} else if ((estado[0] == 1) | ((estado[1] == 1))) {
				$("#alerta").toggleClass("button-assertive");
				$("#alerta").toggleClass("button-positive");
				$("#alerta").html('Nivel do rio: ' + medicoes[2] + 'm | Chuva ' + medicoes[3]);
			} else if (estado[0] == 2) {
				$("#alerta").toggleClass("button-energized");
				$("#alerta").toggleClass("button-positive");
				$("#alerta").html('Nivel do rio: ' + medicoes[2] + 'm | Chuva ' + medicoes[3]);
			}
	
    	}




// onSuccess Callback
// This method accepts a Position object, which contains the
// current GPS coordinates
//
var alturaAtual = 4;
function trataEnchentes(data) {
	for (var oi in data) {
		var teste = data[oi];
		if(alturaAtual < parseFloat(teste[1])) {
			$("#tabelaHistoricoInundacoes").append('<tr> <td>'+teste[0]+'</td> </tr>');
		}
	}
}

function getEnchentes() {
	$.ajax({
		url : "http://localhost/jonathan/Projeto%20Web/final/functions.php?getEnchentes=?",
		dataType : 'jsonp',
		crossDomain : true,
		
		success : function(data) {
			trataEnchentes(data);
		}
	});
}

var altitude;
var latitude;
var longitude;

function coordenadas() {
	alert('Certifique-se que o GPS do dispositivo está ativado para maior precisão');
	var onSuccess = function(position) {
		latitude = position.coords.latitude;
		longitude = position.coords.longitude;
		geocodificacaoReversa();
		$("#latitudeLocal").html(latitude);
		$("#longitudeLocal").html(longitude);
	
	};

	function onError(error) {
		alert('code: ' + error.code + '\n' + 'message: ' + error.message + '\n');
	}

	var options = {
		maximumAge : 3,
		timeout : 60000,
		enableHighAccuracy : true
	};

	navigator.geolocation.watchPosition(onSuccess, onError, options);

}

function geocodificacaoReversa() {
	var geocoder;
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(latitude, longitude);
	geocoder.geocode({
		'latLng' : latlng
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				$("#enderecoLocal").html(results[0].formatted_address);
				getAltura();
			} else {
				alert("Geocoder failed due to: " + status);
			}
		}
	});
}

function getAltura() {
	locations = [];

	elevator = new google.maps.ElevationService();
	var latlng = new google.maps.LatLng(latitude, longitude);

	locations.push(latlng);
	var positionalRequest = {
		'locations' : locations
	};

	elevator.getElevationForLocations(positionalRequest, function(results, status) {
		if (status == google.maps.ElevationStatus.OK) {
			if (results[0]) {
				$("#elevacaoLocal").html(results[0].elevation);
				$("#divbotao").hide();
				$("#tabela").show();
			} else {
				return ('No results found');
			}
		} else {
			alert('Elevation service failed due to: ' + status);
		}
	});
}
