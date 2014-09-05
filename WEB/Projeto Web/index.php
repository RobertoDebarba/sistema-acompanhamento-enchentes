<!DOCTYPE html>
<!--
Autor: jonathan, luan, roberto

sobre as classes utilizadas acesse
http://bootstrapdocs.com/v3.2.0/docs/
-->
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Sistema de monitoramento de Enchentes de Timbó">
		<meta name="author" content="Jonathan, Luan e Roberto">
		<link rel="icon" href="icone da barinha">

		<title>SAEnchentes Timbó</title>

		<!-- Bootstrap -->
		<link href="./bootstrap-3.2.0-dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="./bootstrap-3.2.0-dist/css/bootstrap-theme.min.css" rel="stylesheet">
		<!--fim carregamento bootstrap -->

		<!--estilos proprios-->
		<link href="./css/index.css" rel="stylesheet" />

		<!--estilos mapa-->
		<link href="./css/mapa.css" rel="stylesheet" />
		<link href="./css/mapaClima.css" rel="stylesheet" />

	</head>
	<body>
		<!-- Conecta ao MongoDB e recupera todas informações necessarias para tela -->
		<?php
			#Conecta ao MongoDB
			$m = new MongoClient();
			$db = $m -> mydb;
			$collection = $db -> leituras;
			
			#Verifica se ultima leitura é valida
			$cursor = $collection -> find();
			$cursor -> sort(array('dataHora' => -1));
			$cursor -> limit(1);
			
			foreach ($cursor as $document) {
				$nivelRio = $document["nivelRio"];
			}
			
			#Se ultima leitura é valida armazena dados
			if ($nivelRio != "null") {
				$ultimaLeituraValida = true;
				$dataHora = date(DATE_ISO8601, $document["dataHora"] -> sec);
				$nivelRio = $document["nivelRio"];
				$nivelChuva = $document["nivelChuva"];
				
			#Se não é valida busca ultima valida
			} else {
				$ultimaLeituraValida = false;
				
				#Busca ultima leitura valida
				$query = array('nivelRio' => array('$ne' => 'null'));
				$cursor = $collection -> find($query);
				$cursor -> sort(array('dataHora' => -1));
				$cursor -> limit(1);
				
				foreach ($cursor as $document) {
					$dataHora = date(DATE_ISO8601, $document["dataHora"] -> sec);
					$nivelRio = $document["nivelRio"];
					$nivelChuva = $document["nivelChuva"];
				}
			}
		?>

		<!--NAVEGARDOR-->
		<header class="navbar navbar-default" >
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Enchentes e Inundações</a>

				</div>
				<nav class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="#">Inicio</a>
						</li>
						<li>
							<a href="#">Monitoramento</a>
						</li>
						<li>
							<a data-toggle="modal" data-target="#myModal">Sistema de Alerta</a>
						</li>
						<li>
							<a href="#Sobre">Sobre</a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<!--fim navegador-->
		
		
		<div class="container">
			

			<div class="row">

				<div class="col-md-8">

					<!--Caixa de pesquisa-->
					<input id="pac-input" class="controls" type="text" placeholder="Digite um endereço...">
					<!--Mapa-->
					<div id="containerMapa" class="container">
						<div id="mapa"></div>
					</div>

					<!--Rodape Mapa-->
					<div class="row">

						<div id="textoMapaEsquerdo" class="col-md-6">
							<?php
							if ($ultimaLeituraValida) {
								echo '<span class="label label-info">ONLINE</span>';
							} else {
								echo '<span class="label label-danger">OFFLINE</span>';
							}
							
							echo(" Atualizado em: ");
							echo date("d/m/Y", strtotime($dataHora)) . ", ";
							echo date("h:i:sa", strtotime($dataHora)) . ".";
							?>
						</div>
					</div>
				</div>

				<div id="painel2" class="col-md-4">
					
					<div id="painelAlerta">
						<!--Painel de alerta -->
						<?php
						if ($nivelRio < 7) {
							echo('<div class="alert alert-success" id="alerta">');
							#echo ('<img src="_Imagens/statusRioOK.png" id="alertaImagem"/>');
							echo('<strong>Status: </strong> Rio em condições normais.');
							echo('</div>');
						} else if (($nivelRio >= 7) & ($nivelRio < 10)) {
							echo('<div class="alert alert-warning" id="alerta">');
							#echo ('<img src="_Imagens/statusRioAlerta.png" id="alertaImagem"/>');
							echo('<strong>Status: </strong> Nível do rio em alerta!');
							echo('</div>');
						} else if ($nivelRio >= 10) {
							echo('<div class="alert alert-danger" id="alerta">');
							#echo ('<img src="_Imagens/statusRioPerigo.png" id="alertaImagem"/>');
							echo('<strong>Status: </strong> Rio em inundação!');
							echo('</div>');
						}
						?>
					</div>
					
					<div id="tabelaInfo">
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
									$cursor -> limit(5);
									
									#Imprime leituras na tabela
									foreach ($cursor as $document) {
										$Hora = date(DATE_ISO8601, $document["dataHora"] -> sec);
										
										echo "<tr>";
										echo "<td>".date("d/m/Y", strtotime($Hora)) . ", ".
											date("h:i:sa", strtotime($Hora)) . "</td>";
										echo "<td>".$document["nivelRio"]."</td>";
										echo "<td>".$document["nivelChuva"]."</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
					
					<div class="visible-"></div>
					<div id="row2" class="row">

						<!-- Mapa de Clima -->
						<div id="mapaClima" class="col-md-6"></div>
	
						<div id="previsaoTempo" class="col-md-6">
							<iframe allowtransparency="true" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"
							src="http://www.cptec.inpe.br/widget/widget.php?p=5400&w=h&c=748ccc&f=ffffff" height="200px" width="215px"></iframe>
							<!-- Widget Previs&atilde;o de Tempo CPTEC/INPE -->
						</div>
						
					</div>

				</div>

			</div>

			<!-- tela Modal sms -->

			<div id="myModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

							<h4 class="modal-title">Recebimento SMS</h4>
						</div>
						<div class="modal-body">

							<!--faz o famoso "edit" do delphi -->

							<input type="text" name="entrada" id="entrada">
							<br>

							<p id="resposta"></p>
						</div>
						<div class="modal-footer">
							<!-- botao fechar tela modal sms -->
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Fechar
							</button>

							<!--botao cadastrar da tela modal sms(chama o metodo jquery da arquivo funcoes.js) -->
							<button type="button" class="btn btn-primary" onclick="Alterar_div()">
								Cadastrar
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- fim tela modal sms-->

			<!--carrega os arquivos js necessarios -->

			<script src="./js/jquery.min.js"></script><!--JQuery-->

			<script src="./bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>

			<script src="./js/funcoes.js"></script>

			<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
			<!--[if lt IE 9]><script src="./js/ie8-responsive-file-warning.js"></script><![endif]-->
			<script src="./js/ie-emulation-modes-warning.js"></script>

			<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			<script src="./js/ie10-viewport-bug-workaround.js"></script>

			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->

			<!--scripts do mapa-->

			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=weather"></script>

			<script type="text/javascript" src="./js/mapa.js"></script>

			<script type="text/javascript" src="./js/mapaClima.js"></script>

			<!--AJAX-->
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		</div>
	</body>
</html>
