var timer; // variavel que recebe o timer de alertas
var alertaAtivo = false; //define o alerta desativado antes de ler cfg

var alturaAlerta;// altura do alerta salvo pelo usuario
var local;//local do alerta salvo pelo usuario

var elevacaoRio; //altura do fundo do rio

var altitude;//altitude do local
var latitude;// latitude do local atual
var longitude;//longitude do local atual

var nivelRio; // nivel do rio atual

/**
 * preenche tabela com as ultimas medições
 */
function preencheTabela() {
	$.getJSON("funcoes.php?getLeituras&qtdLeituras=12", function (leituras) {
	    var key, object ;
	    for (key in leituras) {
	        if (leituras.hasOwnProperty(key)) {
	            object = leituras[key];
		        $('#tabela').append('<tr><td>' + object['data'] + 
		        '</td><td>' + object['vlr_nivel'] + 'm</td><td>' + object['vlr_precipitacao'] + '%</td></tr>');
	        }
   		}	
	});
}

/**
 * Gera o grafico
 */
function carregaGrafico(){	
	$.getJSON("funcoes.php?getLeituras&qtdLeituras=24", function (data) { 
		data = MG.convert.date(data, 'data',"%Y-%m-%dT%H:%M:%S");	
        MG.data_graphic({
		  	data: data,
		  	animate_on_load: true,
	        area: false,
	        right: 40,
	        left: 120,
		  	min_y_from_data: true,
		  	width: 600,
		  	height: 600,
		  	xax_count:6,
		  	y_extended_ticks: true,
		  	x_extended_ticks: true,
			target: document.getElementById('graficoRio'),
	    	x_accessor: 'data',
	    	y_accessor: 'vlr_nivel',
        	y_label: 'Nivel do Rio em Metros',
		});
    });
}

/**
 * altera o design da barra de alerta no rodapé
 * 
 * estado[0] = Nivel do Rio: 0- Normal, 1- Alerta, 2- Inundação
 * estado[1] = Defesa Civil: 0- Nada encontrado, 1- Aviso encontrado
 * estado[2] = nivel do rio
 * estado[3] = % chuva
 */
function barraAlerta() { 
	$.getJSON("funcoes.php?getEstadoAlerta", function (estado) { 
	    if ((estado[0] == 0) && (estado[1] == 0)) {
	        $("#alerta").attr('class',"button button-full button-positive BFontSize	");
	        $("#alerta").html('Nivel do rio: ' + estado[2]+ 'm | Chuva ' + estado[3]+'%');
	    }
	    else if ((estado[0] == 1) || ((estado[1] == 1))) {
	        $("#alerta").attr('class',"button button-full button-energized BFontSize");
	        $("#alerta").html('Nivel do rio: ' + estado[2] + 'm | Chuva ' + estado[3]+'%');
	    }
	    else if (estado[0] == 2) {
	        $("#alerta").attr('class',"button button-full button-assertive BFontSize");   
	        $("#alerta").html('Nivel do rio: ' + estado[2] + 'm | Chuva ' + estado[3]+'%');
	    }
	    else{     
	        $("#alerta").attr('class',"button button-full button-assertive BFontSize");	        
	        $("#alerta").html("Dados indisponíveis");
	    }
	    $nivelRio = estado[2];
	});
}

/**
 * Metodo que busca na base o histórico de datas e alturas de enchentes
 * e preenche a tabela na tela de verificação de locais
 */
function getEnchentes(dados) {	
	var nivelEnchente = altitude-dados;
        
	$("#nivelRioLocal").html(nivelEnchente);
	
	$.getJSON("./funcoes.php?getEnchentes&elevAtual="+nivelEnchente, function (altura) {
        console.log(altura);

		var cont;
		for (cont in altura) {
			var alturaEnchente = altura[cont];
			$("#tabelaHistoricoInundacoes").append('<tr> <td>' + alturaEnchente[0] + '</td> </tr>');
		}
	});
}

/**
 *  Função que carrega a altura zero do rio
 */
function getElevacaoRio() {
    $.getJSON("./funcoes.php?getElevacaoRio", function(altura) {
        elevacaoRio = altura;
        
        getEnchentes(altura);
    });
}

/**
 * Metodo que utiliza as cordenadas de geolocalização para captar o endereço
 */
function geocodificacaoReversa(ltlg, gps) {
    var latlng;
    
    var geocoder = new google.maps.Geocoder();
    
    if( gps == false ){
    	latlng = geolocationBusca;
    }
    else{
        latlng = new google.maps.LatLng(ltlg[0], ltlg[1]);
    }
    
    // BUSCA O ENDEREÇO DO LOCAL
    geocoder.geocode ({'latLng' : latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                local = results[0].formatted_address;
                
                if(!gps){
                   local = $("#pesquisar").val();
                }
                
                $("#enderecoLocal").html(local);
                
                // BUSCA A ELEVAÇÃO DO LOCAL
                var locations = [];
			    var elevator = new google.maps.ElevationService();
			    
			    locations.push(latlng);
			    
			    var positionalRequest = {'locations' : locations};
			
			    elevator.getElevationForLocations(positionalRequest, function(results, status) {
			        if (status == google.maps.ElevationStatus.OK) {
			            if (results[0]) {
			                $("#elevacaoLocal").html(results[0].elevation);
			                $("#divbotao").hide();
			                $("#tabela").show();
			                
			                altitude = results[0].elevation;
			                
			                getElevacaoRio();
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
		var latlng = [];	
		latlng[0] = position.coords.latitude;
		latlng[1] = position.coords.longitude;
		
		$("#latitudeLocal").html(latlng[0]);
	
		$("#longitudeLocal").html(latlng[1]);
		
		geocodificacaoReversa(latlng);
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
       alturaAlerta = 6;//texto.substring(0,pontoVirgula);
       
       local = "Rua Seara 278, Imigrantes, Timbó" ;//texto.substring(pontoVirgula,doisPontos);
              
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
                getElevacaoRio();
                alteraBarraAlerta();
                
                nivelLocal = 66.2 - elevacaoRio;
                
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

/**
 * exibi o menu +
 */
function exibirMenuPlus() {
	$("#menuPlus").slideToggle("fast");
}

/**
 * Abre um conteudo dentro do div 'conteudos'
 * @param tela: nome do arquivo html sem a extenção
 * @param nome: nome a ser exibido no topo do App
 * */
function alterarConteudo(tela, nome) {
	$("#menuPlus").hide("fast");
	$("#mapaconteiner").show('fast');
	$("strong").html(nome);

	if (tela == "home") {
		$("#mapaconteiner").show();

		$("#conteudo").hide();
		$("#divClima").hide();
		$("#divSimulacao").hide();
		
		barraAlerta();
		
		google.maps.event.addDomListener(window, 'load', initialize);

	} else if (tela == "previsao") {
		$("#conteudo").hide();
		$("#mapaconteiner").hide();

		$("#divClima").show();
		
		initializeWeather();
	} else if (tela == "simulacao") {
		$("#conteudo").hide();
		$("#divClima").hide();

		$("#mapaconteiner").show();
		$("#divSimulacao").css("display", "inline-flex");
		passarImg('+');
	} else {
		$("#mapaconteiner").hide();
		$("#divSimulacao").hide();
		$("#divClima").hide();

		$("#conteudo").load(tela + ".html");
		$("#conteudo").show();
	}
}