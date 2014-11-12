var timer; // variavel que recebe o timer de alertas

var estado; // array com estado de alerta da defesa civil
var leituras;// array com leituras completas de mediçoes

var dataArray = []; //array com data e nivel do rio

var alturaAlerta;

var altitude;
var latitude;
var longitude;
var local;

getEstadoAlerta();
getLeituras(12);	


/**
 * Ativa o modo background e manten um timer de alerta
 */
function ativarAlerta(sim){
	if(sim){
		timer = setInterval(function(){alerta();}, 1000*5/*15*/);

		alertaAtivo = true;
	}
	else{
		clearInterval(timer);
		 
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
	var now = new Date();
	window.plugin.notification.local.add({
	    id:      1,
	    date : now,
	    title:   'SAEmóvel Alerta',
	    message: 'Atenção! Água a caminho!',
	    autoCancel: true
    });
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
	dataArray[0] = ['Data', 'Nivel do Rio'];

	var key;
	for(key in leituras) {
  		if(leituras.hasOwnProperty(key)) {

	    	var object = leituras[key];				
		
			$('#tabela').append('<tr><td>'+object[0]+" "+object[1] + '</td><td>'+object[2] + ' m</td><td>'+object[3] + '</td></tr>');
		  	
		  	if(key <= 7){
				dataArray[dataArray.length] = [object[1], parseInt(object[2])];
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
	}
	else if ((estado[0] == 1) | ((estado[1] == 1))) {
		$("#alerta").toggleClass("button-assertive");
		$("#alerta").toggleClass("button-positive");
		$("#alerta").html('Nivel do rio: ' + medicoes[2] + 'm | Chuva ' + medicoes[3]);
	}
	else if (estado[0] == 2) {
		$("#alerta").toggleClass("button-energized");
		$("#alerta").toggleClass("button-positive");
		$("#alerta").html('Nivel do rio: ' + medicoes[2] + 'm | Chuva ' + medicoes[3]);
	}
}


var alturaAtual = 4;/**>>>>>QG<<<<<<<*/

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
				local = results[0].formatted_address;
				$("#enderecoLocal").html(local);
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
				altitude = results[0].elevation;
			}
			else{
				return ('No results found');
			}
		}
		else{
			alert('Elevation service failed due to: ' + status);
		}
	});
		
}

/**
 * adiciona local na pagina Serviços
 * */
function addLocal(){
	try{
		coordenadas();
	}
	catch(exception){
		console.log(exception);
	}	
	finally{
		window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
	}
	
	$("#modal").hide();
	$("#buscarLocal").html("Alterar Local");
	
	$("#conteudoServico").show();
	
	
	
		
}

function abrirModal(){
	$("#conteudoServico").hide();
	$("#modal").show("slow");
}


/**
 * ler arquivo cfg
 * */
function lerCfg(){
	 window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFile, fail);
}

 function gotFile(fileSystem) {
    fileSystem.root.getFile("sae", null, gotEntry, fail);
}

function gotEntry(fileEntry) {
    fileEntry.file(gotFile, fail);
}

function gotFile(file){
    readAsText(file);
}

function readAsText(file) {
    var reader = new FileReader();
    reader.onloadend = function(evt) {
       console.log(evt.target.result);
    };
    reader.readAsText(file);
}


/**
 * escrevendo arquivo
 * */
function gotFS(fileSystem) {
        fileSystem.root.getFile("sae", {create: true, exclusive: false}, gotFileEntry, fail);
    }

function gotFileEntry(fileEntry) {
    fileEntry.createWriter(gotFileWriter, fail);
}

function gotFileWriter(writer) {
    writer.write(altitude);
    writer.seek(4);
    writer.write(local);
}

 function fail(error) {
    console.log(error.code);
}
