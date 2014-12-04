var timer; // variavel que recebe o timer de alertas
var alertaAtivo = false; //define o alerta desativado antes de ler cfg

var estado; // array com estado de alerta da defesa civil
var leituras;// array com leituras completas de mediçoes

var dataArray = []; //array com data e nivel do rio

var alturaAlerta;// altura do alerta salvo pelo usuario
var local;//local do alerta salvo pelo usuario

var alturaRio; //altura do fundo do rio

var altitude;//altitude do local
var latitude;// latitude do local atual
var longitude;//longitude do local atual

var nivelRio; // nivel do rio atual

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
            alteraBarraAlerta();
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
            alteraBarraAlerta();
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
    if((leituras === 'undefined') || (estado === 'undefined')){
        getLeituras(12);
        getEstadoAlerta();
    }
	console.log(leituras);
    
    var medicoes = leituras[0];
    nivelRio = medicoes[2];
    if ((estado[0] == 0) && (estado[1] == 0)) {
        $("#alerta").toggleClass("button-assertive");
        $("#alerta").toggleClass("button-energized");
        $("#alerta").html('Nivel do rio: ' + medicoes[2] + 'm | Chuva ' + medicoes[3]);
    }
    else if ((estado[0] == 1) || ((estado[1] == 1))) {
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

/**
 * Metodo que preenche a tabela na tela de verificação de locais
 */
function trataEnchentes(data) {
    var cont; //contador
    var alturaEnchente;
	for (cont in data) {
		alturaEnchente = data[cont];
		$("#tabelaHistoricoInundacoes").append('<tr> <td>' + alturaEnchente[0] + '</td> </tr>');
	}
}

/**
 * Metodo que busca no banco o histórico de datas e alturas enchentes
 */
function getEnchentes(data) {
	var nivelEnchente = altitude-data;
	$("#nivelRioLocal").html(nivelEnchente);
	
	$.ajax({
		url : "http://54.232.207.63/Comum/php/funcoes.php?getEnchentes=?",
		data : { 'elevAtual' : nivelEnchente},
		dataType : 'jsonp',
		crossDomain : true,
		
		success : function(data) {
			trataEnchentes(data);
		}
	});
}

/**
 *  Função que carrega a aultura zero do rio
 */
function getAlturaRio() {
    $.ajax({
        url : "http://54.232.207.63/Comum/php/funcoes.php?getAlturaRio=?",
        dataType : 'jsonp',
        crossDomain : true,
        
         success: function (data) {
            alturaRio = data;
            getEnchentes(data);
        }
    });
}

function getAltura(gps) {
    var locations = [];
    
    var latlng;

    var elevator = new google.maps.ElevationService();
    
    if(gps){
        latlng = new google.maps.LatLng(latitude, longitude);
    }
    else{
        latlng = geolocationBusca;
    }
    
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
                getAlturaRio();
            }
            else {
                alert('No results found');
            }
        }
        else{
            alert('Elevation service failed due to: ' + status);
        }
    });
        
}

/**
 * Metodo que utiliza as cordenadas de geolocalização para captar o endereço
 */
function geocodificacaoReversa(gps) {
    var geocoder;
    var latlng;
    
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
        if (status == google.maps.GeocoderStatus.OK) {
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
 * Metodo que busca as cordenadas de geolocalização com gps ou pela rede
 */

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

	var options = {
		maximumAge : 3,
		timeout : 60000,
		enableHighAccuracy : true
	};
    
    navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
}

/*Erro para leitura ou escrita de arquivos*/
function fail(error) {
    console.log(error.code);
}

/**
 * escrevendo arquivo
 * */
function gotFileWriter(writer) {
    writer.write(altitude+";"+local+":"+alertaAtivo);
}

function gotFileEntry(fileEntry) {
    fileEntry.createWriter(gotFileWriter, fail);
}

function gotFS(fileSystem) {
    fileSystem.root.getFile("sae", {create: true, exclusive: false}, gotFileEntry, fail);
}

/**
 * ler arquivo cfg
 * */
function readAsText(file) {
    /*
alert("readastext");
    var reader;
    reader = new FileReader();
    
    reader.onload = function(evt) {
       var texto = evt.target.result;
       
       var doisPontos = texto.indexOf(":");
       var pontoVirgula = texto.indexOf(";");
       */
       alturaAlerta = 6//texto.substring(0,pontoVirgula);
       
       local = "Rua Seara 278, Imigrantes, Timbó" //texto.substring(pontoVirgula,doisPontos);
              
       $("#enderecoLocal").html(local);       
              
       //if (texto.substring(doisPontos,texto.length) == "false") {       
            $('#myonoffswitch').prop('checked', true);
            alertaAtivo = true;
/*      // }
    };*/
    reader.onload = function(e) {
       alert(reader.result);
       alert(e);
    };
    
    reader.readAsText(file);
}

function gotFile(file){
    alert("gfile");
    readAsText(file);
}

function gotEntry(fileEntry) {
    alert("gotentre");
    fileEntry.file(gotFile, fail);
}

function gotFileSystem(fileSystem) {
    alert("gotfiles");
    fileSystem.root.getFile("sae", gotEntry, fail);
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
           // window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
        }
    }
    else{
        geocodificacaoReversa(false);
        
       // window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
    }
    
    $("#forma").show();
    $("#buscaLocal").hide();  
    $("#buscarLocal").html("Alterar Local");
}

/**
 * abrir modal
 * */
function abrirModal(){
    $('#modalBuscaLocal').show();
	$("#buscaLocal").hide();
   	$("#forma").show();
}

/**
 * Metodo que mostra e esconde o gif no mapa metereologico
 */

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
                getAlturaRio();
                alteraBarraAlerta();
                
                nivelLocal = 66.2 - alturaRio;
                
                if(nivelLocal - 2 <= nivelRio ){
                    alerta();
                }
            },
            1000 /*5*/ * 2
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

//usado para busca o local digitado para o  alerta
function buscaLocal(){
    $("#forma").hide();
    $("#buscaLocal").show();
    
    initializeBusca();
}

getLeituras(12);
getEstadoAlerta();
