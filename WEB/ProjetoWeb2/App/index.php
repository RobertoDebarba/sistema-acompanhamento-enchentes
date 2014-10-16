
<!DOCTYPE html>
<html>
  <head>	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title></title>
	
	<link href="../Comum/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet"><!--Bootstrap-->

    <link href="./lib/ionic/css/ionic.css" rel="stylesheet"><!--Ionic-->
    
    <link href="./css/style.css" rel="stylesheet"><!--estilos-->

	<script src="../Comum/js/jquery.min.js"></script><!--JQuery-->
	
	<script src="cordova.js"></script>
	<script src="cordova_plugins.js"></script>
	
    <script type="text/javascript" charset="utf-8">
    	var alertaAtivo;
    	var timer
    
    	document.addEventListener("deviceready", onDeviceReady, false);
		
	    function onDeviceReady() {
	       
	    }
	    
	    /**
	     * Ativa o modo background e manten um timer de alerta
	     */
	    function ativarAlerta(sim){
	    	if(sim){
	    		timer = setInterval(function(){alerta()}, 1000*5/*15*/);
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
    
	    //parametros do alerta
	    function alerta() {
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
			    $( "#conteudo" ).load( "./"+tela+".php"); 	
				
			}				
	    }
	    
	    
	</script>

	</head>
	<body>
		<?php
			include "../Comum/php/funcoes.php";
			
			$alerta = getEstadoAlerta();
		?>
		
		<!--barra superior com menus-->
		<div id="header">
			<div class="bar bar-header tabs-top bar-positive">
			  <h1 class="title">
			  	<strong>APLICATIVO</strong>
			  </h1>
			</div>
			<div class="tabs tabs-top tabs-background-positive tabs-light tabs-positive">
				  <a onclick="alterarConteudo('home');" href="javascript:void(0);" class="tab-item active">
					<i class="icon ion-home"></i>
				    Home
				  </a>
				  <a href="javascript:void(0);" class="tab-item">
					<i class="icon ion-plus-round" onclick="exibirMenuPlus();"></i>
				    Menu
				  </a>
				  <a onclick="alterarConteudo('Servico');" class="tab-item" href="javascript:void(0);">
					<i class="icon ion-gear-a"></i>
				    Configurações
				  </a>
			</div>
		</div>
		
		<!--menu plus-->
	  	<div id="menuPlus" class="popover bottom ">
            <div class="arrow"></div>
            <div class="popover-content">
				  <a onclick="alterarConteudo('medicoes');" class="item" href="javascript:void(0);">
				    Medições
				  </a>				
				  <a class="item" href="#">
				    História
				  </a>				
				  <a class="item " href="#">
				    Previsão do Tempo
				  </a>
				  <a class="item" href="#">
				    Links Úteis
				  </a>
				  <a class="item" href="#">
				    Galeria
				  </a>
				  <a class="item" href="#">
				    Simulador
				  </a>
				  <a class="item" href="#">
				    Verificar Local
				  </a>
	  		</div>
       </div>
	  	
		<!--Conteúdo adicionais-->
		
		<div id="conteudo" class="container">
	
		</div>
		
		<!--area do mapa-->
		<div id="mapaconteiner" >
			<input id='pac-input' class='controls' type='text' placeholder='Digite um endereço...'>
			<div id='mapa'></div>
		</div>
		
		<!--alerta rodapé-->
		<div id="painelInfo">
			<?php
			$leituras = getLeituras(1, true);

			if (($alerta[0] == 0) & ($alerta[1] == 0)) {
				echo('<button onclick="alterarConteudo(\'medicoes\');" id="alerta" class="button button-full button-positive" role="alert">Nivel do rio: ' . $leituras[0][1] . 'm | Chuva ' . $leituras[0][2] . '</button> ');
			} else if (($alerta[0] == 1) | (($alerta[1] == 1))) {
				echo('<button onclick="alterarConteudo(\'medicoes\');" id="alerta" class="button button-full button-energized" role="alert">Nivel do rio: ' . $leituras[0][1] . 'm | Chuva ' . $leituras[0][2] . '</button> ');
			} else if ($alerta[0] == 2) {
				echo('<button onclick="alterarConteudo(\'medicoes\');" id="alerta" class="button button-full button-assertive" role="alert">Nivel do rio: ' . $leituras[0][1] . 'm | Chuva ' . $leituras[0][2] . '</button> ');
			}
			?>
		</div>
			
		
		
		<!--JAVASCRIPT-->		
		
	    <script type="text/javascript" src="./lib/ionic/js/ionic.js"></script><!-- ionic-->
	    
	    <script type="text/javascript" src="./lib/ionic/js/ionic.bundle.js"></script><!-- ionic-->
	    
	    <script type="text/javascript" src="../Comum/bootstrap-3.2.0/js/bootstrap.min.js"></script><!--boots-->
	    <script type="text/javascript" src="../Comum/bootstrap-3.2.0/js/bootstrap.js"></script><!--boots-->
		
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
		<script type="text/javascript" src="../Comum/js/mapa.js"></script><!-- MAPA -->
		
		<!--grafico-->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	    <script type="text/javascript">
	    
		    /*carrega o grafico*/
		    function loadchart(){
		  		google.load("visualization", "1", {"callback" : drawVisualization, packages:["corechart"]});
			}
		    	
		    <?php
			date_default_timezone_set("America/Sao_Paulo");
			
			$m = new MongoClient();
			$db = $m -> mydb;
			$collectionLeituras = $db -> leituras;
			
			$query = array('nivelRio' => array('$ne' => 'null'));
				
			$cursor = $collectionLeituras -> find($query);
				
			$cursor -> sort(array('dataHora' => -1));
			$cursor -> limit(24);
		
			#Monta array
			$leituras[] = array();
		
			
				?>
			
		  	function drawVisualization() {
		        var data = google.visualization.arrayToDataTable([
						["Hora",  "Nivel do Rio"],
						<?php  	
						#Imprime leituras no grafico
						foreach ($cursor as $document) {
							$Hora = $document["dataHora"];
					
							$hora = date("H:i:s", strtotime($Hora));
							$nivelRio = $document["nivelRio"];
							$nivelChuva = $document["nivelChuva"];
							
							echo '["'.$hora.'" , '.$nivelRio.'],';
					
						}
						
						?>					
					]);
					 var options = {
					    title: 'Histórico de Medições',
					    curveType: 'function',
					    legend: { position: 'bottom' }
					  };
				
					var chart = new google.visualization.LineChart(document.getElementById('graficoRio'));
				
					chart.draw(data, options);
				}
			
		</script> 
	</body>
</html>
