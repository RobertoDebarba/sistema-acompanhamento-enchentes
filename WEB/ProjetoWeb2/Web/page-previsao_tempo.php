<!DOCTYPE html>
<html>
	<head>
		<!-- Informações da página -->
		<meta charset="UTF-8">
		<title>SOAEI</title>

		<!-- Bootstrap -->
		<link href="bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<link href="bootstrap-3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Estilo -->
		<link href="css/page-previsao_tempo.css" rel="stylesheet">
		<link href="css/mapaClima.css" rel="stylesheet">

		<!-- Scripts de Compatibilidade -->
		<script src="js/geral/ie-emulation-modes-warning.js"></script>

	</head>
	<body>
		<?php
			#Converte erros em exceções
			function exception_error_handler($errno, $errstr, $errfile, $errline) {
				throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
			}
			set_error_handler("exception_error_handler");
			
			include "../Comum/php/funcoes.php";
		?>
		
		<!-- Menu -->
		<div id="linhaMenu" class="container-fluid">
			<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand active" href="#">SOAEI</a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li>
								<a data-toggle="modal" data-target="#modalMedicoes" class="hidden-md hidden-lg">Acompanhamento de Medições</a>
							</li>
							<li>
								<a href="#">Histórico de Medições</a>
							</li>
							<li>
								<a data-toggle="modal" data-target="#modalSitesUteis">Sites Uteis</a>
							</li>
							<li>
								<a href="page-previsao_tempo.php">Previsão do Tempo</a>
							</li>
							<li class="active">
								<a href="#">Link</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="#">Action</a>
									</li>
									<li>
										<a href="#">Another action</a>
									</li>
									<li>
										<a href="#">Something else here</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="#">Separated link</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="#">One more separated link</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="linhaCorpo" class="container-fluid">
			<!--Caixa de pesquisa-->
			<input id="pac-input" class="controls" type="text" placeholder="Digite um endereço...">

			<!--Mapa-->
			<div id="mapaClima"></div>
		</div>
		
		<div id="painelInfo" class="hidden-xs hidden-sm">
			<table>
				<tr>
					<td>
						<!-- Widget Previs&atilde;o de Tempo CPTEC/INPE --><iframe allowtransparency="true" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" src="http://www.cptec.inpe.br/widget/widget.php?p=5400&w=n&c=909090&f=ffffff" height="46px" width="312px"></iframe><noscript>Previs&atilde;o de <a href="http://www.cptec.inpe.br/cidades/tempo/5400">Timbó/SC</a> oferecido por <a href="http://www.cptec.inpe.br">CPTEC/INPE</a></noscript><!-- Widget Previs&atilde;o de Tempo CPTEC/INPE -->
					</td>
				</tr>
				<tr>
					<td>
						<img src="http://ciram.epagri.sc.gov.br/ciram_arquivos/arquivos/saidas_scripts/img/satelite/goes13IR/anima.gif" />
					</td>
				</tr>
			</table>
		</div>		

		<!-- Telas modais -->
		<?php include "modal.php"; ?>
		
		<!-- Scripts de Compatibilidade -->
		<script src="js/geral/ie10-viewport-bug-workaround.js"></script>

		<!-- JQuery -->
		<script src="../Comum/js/jquery.min.js"></script>

		<!-- Bootstrap -->
		<script src="bootstrap-3.2.0/js/bootstrap.min.js"></script>
		
		<!-- MAPA -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=weather"></script>
		<script src="../Comum/js/mapaClima.js" type="text/javascript"></script>
	</body>
</html>