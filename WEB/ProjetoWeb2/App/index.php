<html>
  <head>
    <meta charset="utf-8">
    <title></title>
	
	<link href="./Comum/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <link href="./App/lib/ionic/css/ionic.css" rel="stylesheet">
    
    <link href="./App/css/style.css" rel="stylesheet">

	<script src="./Comum/js/jquery.min.js"></script><!--JQuery-->
    <script>
		function onLoad(){				
 
		    document.addEventListener("deviceready", onDeviceReady, true);
		    	
		}			    
	
		function exitFromApp(){
	    	navigator.app.exitApp();
	    }
	            
		function geoLocalizar(){
			navigator.geolocation.getCurrentPosition(onSuccess, onError);
		}

		function onSuccess(position){
			$("#geolocation").html("Latitude: "  + position.coords.latitude + "<br />" +
				                   "Longitude: " + position.coords.longitude + "<br />" + "<hr />");
		}

		function onError(error){
			alert("code: "    + error.code    + "\n" +
				 	"message: " + error.message + "\n");
		}	
		
		function exibirMenuPlus(){
				$("#menuPlus").slideToggle('fast');
	    }
	    
	    function alterarBT(){
	    	$('#alerta').toggleClass('button-assertive button-positive');
	    }
	    
	    function alterarConteudo(tela){
	    	if(tela == "home"){	
	    		$( "#conteudo" ).hide();
	    		$( "#mapaconteiner" ).show();		
	    	}
	    	else{
	    		$( "#conteudo" ).show();
	    		$( "#mapaconteiner" ).hide();
		    	$("#menuPlus").slideToggle('fast');
			    $( "#conteudo" ).load( "./App/"+tela+".php"); 	
			}				
	    }
	    
	</script>

	</head>
	<body onload="onLoad">
		<div id="header">
			<div class="bar bar-header tabs-top bar-positive">
			  <h1 class="title">
			  	<strong>APLICATIVO</strong>
			  </h1>
			</div>
			<div class="tabs tabs-top tabs-background-positive tabs-light tabs-positive">
				  <a onclick="alterarConteudo('home');" href="javascript:void(0);" class="tab-item active">
					<i class="icon ion-home"></i>
				    Test
				  </a>
				  <a onclick="exibirMenuPlus();" href="javascript:void(0);" class="tab-item">
					<i class="icon ion-plus-round"></i>
				    Favorites
				  </a>
				  <a class="tab-item" href="#">
					<i class="icon ion-gear-a"></i>
				    Settings
				  </a>
			</div>
		</div>
		
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
	  	
		<!--Conteúdo-->
		
		<div id="conteudo"></div>
		
		<div id="mapaconteiner">
			<input id='pac-input' class='controls' type='text' placeholder='Digite um endereço...'>
			<div id='mapa'></div>
		</div>
		
		<button id="alerta" class="button button-full button-assertive" onclick="alterarBT()">
		  <Strong>Nivel do rio: 12 metros | Chuva Moderada</strong>
		</button>
		
		<!--JAVASCRIPT-->
		
		
	    <script src="./App/lib/ionic/js/ionic.js"></script><!-- ionic-->
	    
	    <script src="./App/lib/ionic/js/ionic.bundle.js"></script><!-- ionic-->
	    
	    <script src="./Comum/bootstrap-3.2.0/js/bootstrap.min.js"></script><!--boots-->
	    <script src="./Comum/bootstrap-3.2.0/js/bootstrap.js"></script><!--boots-->
	        
  		<script src="./App/plugins/cordova.js"></script><!-- cordova-->
				
		<script src="./App/plugins/backgroundmode/www/background-mode.js"></script>
		<script src="./App/plugins/org.apache.cordova.dialogs/www/notification.js"></script>
		<script src="./App/plugins/org.apache.cordova.geolocation/www/geolocation.js"></script>
		
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
		<script type="text/javascript" src="./Comum/js/mapa.js"></script><!-- MAPA -->
	</body>
</html>
