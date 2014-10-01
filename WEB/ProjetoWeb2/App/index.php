<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<title>SAE</title>
		
		<link href="../Comum/css/mapa.css" rel="stylesheet" />

		<script type="text/javascript" charset="utf-8" src="./plugins/cordova.js"></script> 
	    <script type="text/javascript" charset="utf-8">
	    	function onLoad(){				
			    document.addEventListener("deviceready", onDeviceReady, true);
			}			    
		
			function exitFromApp(){
		    	navigator.app.exitApp();
		    }
		            
			function geoLocalizar(){
				navigator.geolocation.getCurrentPosition(onSuccess, onError);
			}

			function onSuccess(position){'
				$("#geolocation").html("Latitude: "  + position.coords.latitude + "<br />" +
					                   "Longitude: " + position.coords.longitude + "<br />" + "<hr />");
			}

			function onError(error){
				alert("code: "    + error.code    + "\n" +
					 	"message: " + error.message + "\n");
			}	
			
	    </script>
    </head>

    <body role="application" onload="onLoad()">
       
		<!-- tela Modal de alertas-->
		<div id="modalAlerta" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Alertas</h4>
					</div>
					<div class="modal-body">
						<div id="geolocation"></div>
										
					</div>
					<div class="modal-footer">
						<button type="button" onclick="geoLocalizar()" class="btn btn-primary" >Obter Localização</button>	
						<!-- botao fechar-->
						<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- fim tela modal Alertas-->
		
		<!-- tela Modal-->
		<div id="myModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Medições</h4>
					</div>
					<div class="modal-body">
						<table class="table table-striped">
						<thead class="tituloTabela">
							<tr>
								<td>Hora</td>
								<td>Nivel do Rio</td>
								<td>Estado da Chuva</td>
							</tr>
						</thead>
						<tbody>
							<?php
							#Busca tres ultimas leituras validas
							$query = array('nivelRio' => array('$ne' => 'null'));
							$cursor = $collection -> find($query);
							$cursor -> sort(array('dataHora' => -1));
							$cursor -> limit(4);

							#Imprime leituras na tabela
							foreach ($cursor as $document) {
								$Hora = date(DATE_ISO8601, $document["dataHora"] -> sec);

								echo "<tr>";
								echo "<td>" . date("d/m/Y", strtotime($Hora)) . ", " . date("h:i:sa", strtotime($Hora)) . "</td>";
								echo "<td>" . $document["nivelRio"] . "</td>";
								echo "<td>" . $document["nivelChuva"] . "</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
					</div>
					<div class="modal-footer">
						<!-- botao fechar-->
						<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- fim tela modal -->
		
		<!-- Menu lateral -->
		<section id="menuLateral" data-type="sidebar">
			<header>
				<h1>Menu</h1>
			</header>
			<nav>
				<ul>
					<li>
						<a href="#">label</a>
					</li>
					<li>
						<a href="#">label</a>
					</li>
					<li> <a id="btnAlerta" data-toggle="modal" data-target="#modalAlerta">Alertas</a></li>
				</ul>
			</nav>
		</section>
		
		<!-- barra superior-->
		<section id="drawer" role="region">
			<header><!--
				<?php
					#Define cor da barra de titulos
					$query = array('nivelRio' => array('$ne' => 'null'));
					$cursor = $collection -> find($query);
					$cursor -> sort(array('dataHora' => -1));
					$cursor -> limit(1);
	
					foreach ($cursor as $document) {
						$nivelRio = $document["nivelRio"];
					}
	
					if ($nivelRio < 7) {
						$corTitulo = "rgb(56, 165, 41)";
					} else if (($nivelRio >= 7) & ($nivelRio < 10)) {
						$corTitulo = "#f97c17";
					} else if ($nivelRio >= 10) {
						$corTitulo = "rgb(255, 21, 21)";
					}
	
					echo '<style type="text/css">';
					echo 'section[role="region"] > header:first-child {background-color: ' . $corTitulo . '};';
					echo '</style>';
				?>
				-->
				
				<a href="#">hide sidebar</a>
				
				<a href="#drawer">show sidebar</a>
								
				<div id="wrap">
					<div id="left_col">
						<h1>SOEnchentes</h1>
					</div>
					<div id="right_col">
						<a id="btnAlerta" data-toggle="modal" data-target="#modalAlerta">Alertas</a>
						<a id="teste" data-toggle="modal" data-target="#myModal">teste</a>
					</div>
					<?php if($movel == true){echo '<a onclick="exitFromApp()">Fechar!</a>';}?>
				</div>							
			</header>
			
			<div role="main">
				<!--Caixa de pesquisa-->
				<input id="pac-input" class="controls" type="text" placeholder="Digite um endereço...">
				
				<!--Mapa-->
				<div id="mapa"></div>
			</div>
		</section>

		<script src="../Comum/js/jquery.min.js"></script><!--JQuery-->
		
		<script src="./plugins/backgroundmode/www/background-mode.js"></script><!--Plugin background -->
		<script src="./plugins/org.apache.cordova.dialogs/www/notification.js"></script><!--Plugin notification-->
		<script src="./plugins/org.apache.cordova.geolocation/www/geolocation.js"></script><!--Plugin geolocalization-->
		
		<!-- MAPA -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
		<script type="text/javascript" src="../Comum/js/mapa.js"></script>
		
	</body>
</html>
