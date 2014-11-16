var timer; // variavel que recebe o timer de alertas
var alertaAtivo = false; //define o alerta desativado antes de ler cfg

var estado; // array com estado de alerta da defesa civil
var leituras;// array com leituras completas de mediçoes

var dataArray = []; //array com data e nivel do rio

var alturaAlerta;// altura do alerta salvo pelo usuario
var local;//local do alerta salvo pelo usuario

var altitude;
var latitude;
var longitude;

/**
 * obtem as leituras do php no servidor
 */
function getLeituras(qtdLeituras) {
    $.ajax({
        url : "http://54.232.207.63/Comum/php/funcoes.php/?getLeituras=?",
        data : { 'qtdLeituras' : qtdLeituras},
        dataType : 'jsonp',
        crossDomain : true,

        success : function (data) {
            leituras = data;
        }
    });
}


/**
 * obtem alertas da defesa civil do php no servidor
 */
function getEstadoAlerta() {
    $.ajax({
        url: "http://54.232.207.63/Comum/php/funcoes.php?getEstadoAlerta=?",
        dataType : 'jsonp',
        crossDomain : true,

        success: function (data) {
            estado = data;
        }
    });   
}

/**
 * cria um array com as leituras para o grafico
 */
function carregaLeituras() {
    dataArray = [];
    dataArray[0] = ['Data', 'Nivel do Rio'];

    var key, object ;
    for (key in leituras) {
        if (leituras.hasOwnProperty(key)) {
            object = leituras[key];
            
            $('#tabela').append('<tr><td>' + object[0] + " " + object[1] + '</td> <td>' + object[2] + ' m</td> <td>' + object[3] + '</td> </tr>');

            if (key <= 7) {
                dataArray[dataArray.length] = [object[1], parseInt(object[2], 10)];
            }
        }
    }
}


/**
 * altera o design da barra de alerta no rodapé
 */
function alteraBarraAlerta() {
    if((typeof leituras === 'undefined') | (typeof estado === 'undefined')){
        getLeituras(12);
        getEstadoAlerta();
        alteraBarraAlerta();
    }
    
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
    else{     
        $("#alerta").toggleClass("button-assertive");
        $("#alerta").toggleClass("button-energized");
        $("#alerta").html("Dados indisponíveis");
    }
}



var alturaAtual = 4;/**>>>>>QG<<<<<<<*/

function trataEnchentes(data) {
    var dado, teste;
	for (dado in data) {
		teste = data[dado];
		if (alturaAtual < parseFloat(teste[1])) {
			$("#tabelaHistoricoInundacoes").append('<tr> <td>' + teste[0] + '</td> </tr>');
		}
	}
}


function getEnchentes() {
	$.ajax({
		url : "http://54.232.207.63/Comum/php/funcoes.php?getEnchentes=?",
		dataType : 'jsonp',
		crossDomain : true,
		
		success : function(data) {
			trataEnchentes(data);
		}
	});
}


function getAltura(gps) {
    var locations = [];
    var latlng;

    elevator = new google.maps.ElevationService();
    
    if(gps){
       latlng = new google.maps.LatLng(latitude, longitude);
    }
    else{
        alert(geolocationBusca);
        latlng = geolocationBusca;
    }
    
    locations.push(latlng);
    positionalRequest = {
        'locations' : locations
    };

    elevator.getElevationForLocations(positionalRequest, function(results, status) {
        if (status === google.maps.ElevationStatus.OK) {
            if (results[0]) {
                $("#elevacaoLocal").html(results[0].elevation);
                $("#divbotao").hide();
                $("#tabela").show();
                altitude = results[0].elevation;
            }
            else {
                return ('No results found');
            }
        }
        else{
            alert('Elevation service failed due to: ' + status);
        }
    });
        
}



function coordenadas() {
	var onSuccess = function(position) {
		
		latitude = position.coords.latitude;
		longitude = position.coords.longitude;
		
		geocodificacaoReversa(true);
		
		$("#latitudeLocal").html(latitude);
	
		$("#longitudeLocal").html(longitude);

	};

	function onError(error) {
		console.log('code: ' + error.code + '\n' + 'message: ' + error.message + '\n');
	}

	options = {
		maximumAge : 3,
		timeout : 60000,
		enableHighAccuracy : true
	};

	navigator.geolocation.watchPosition(onSuccess, onError, options);

}


function geocodificacaoReversa(gps) {
	var geocoder, latlng;
	
	geocoder = new google.maps.Geocoder();
	
	if(gps){
	   latlng = new google.maps.LatLng(latitude, longitude);
	}
	else{
	    latlng = geolocationBusca;
	}
	
	geocoder.geocode ({
		'latLng' : latlng
	}, 
	function(results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				local = results[0].formatted_address;
				if(!gps){
                   local = $("#pesquisar").val();
                }
				$("#enderecoLocal").html(local);
				
				if(gps){
                   getAltura(true);
                }
                else{
                    getAltura(false);
                }
			} 
			else {
				alert("Geocoder failed due to: " + status);
			}
		}
	});
}





/**
 * ler arquivo cfg
 * */
 function gotFileSystem(fileSystem) {
    fileSystem.root.getFile("sae", gotEntry, fail);
}

function gotEntry(fileEntry) {
    fileEntry.file(gotFile, fail);
}

function gotFile(file){
    readAsText(file);
}

function readAsText(file) {
    var reader = new FileReader();
    
    
    
    reader.onload = function(evt) {
       texto = evt.target.result;
       
       doisPontos = texto.indexOf(":");
       pontoVirgula = texto.indexOf(";");
       
       alturaAlerta = texto.substring(0,ponto);
       
       local = texto.substring(pontoVirgula,doisPontos);
              
       $("#enderecoLocal").html(local);       
              
       if (texto.substring(doisPontos,texto.length) === "false") {       
			$('#myonoffswitch').prop('checked', true);
			alertaAtivo = true;
       }
    };
       
    reader.onload = function(e) {
	   alert(reader.result);
	};
	
	reader.readAsText(file);
}
/*****/


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
    writer.write(altitude+";"+local+":"+alertaAtivo);
}
/****/

/*Erro para leitura ou escrita de arquivos*/
 function fail(error) {
    console.log(error.code);
}

/**
 * adiciona local na pagina Serviços
 * */
function addLocal(gps){
    if(gps){
        try{
            coordenadas();
        }
        catch(exception){
            console.log(exception);
        }   
        finally{
            //window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
        }
    }
    else{
        geocodificacaoReversa(false);
        
        //window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
    }
    
    $("#forma").show();
    $("#buscaLocal").hide();
    $("#modal").hide();
    $("#conteudoServico").show();       
    $("#buscarLocal").html("Alterar Local");
}


/**
 * abrir modal
 * */
function abrirModal(){
    $("#conteudoServico").hide();
    $("#modal").show();
}



function OpcoesMapaMetereologico() {
	if ($("#painelOpcoesMapa").html() == "Mais Informações") {
		$("#painelOpcoesMapa").html("Fechar");
		$("#painelInfo").show();
	} 
	else {
		$("#painelOpcoesMapa").html("Mais Informações");
		$("#painelInfo").hide();
	}

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
 * Ativa o modo background e manten um timer de alerta
 */
function ativarAlerta(sim) {
    if (sim) {
        timer = setInterval(
            function () {
                alerta();
            },
            1000 /*5*/ * 15
        );

        alertaAtivo = true;

        window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
  }
  else{
    clearInterval(timer);
		 
    alertaAtivo = false;
		
    window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
  }
}

function buscaLocal(){
    $("#forma").hide();
    $("#buscaLocal").show();
    
    initializeBusca();
}

/**
 * chama a obtenção de dadod do servidor
 * */  
getLeituras(12);
getEstadoAlerta();
