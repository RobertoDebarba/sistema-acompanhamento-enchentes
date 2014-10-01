<!DOCTYPE html>
<html>
	<head>
		<!-- Informações da página -->
		<meta charset="UTF-8">
		<title>SOAEI</title>

		<!-- Importações -->
		<!-- Bootstrap -->
		<link href="./Web/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<link href="./Web/bootstrap-3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Estilo -->
		<link href="./Web/css/index/style.css" rel="stylesheet">
		<link href="./Web/css/index/mapa.css" rel="stylesheet" />

	</head>
	<body>
		<?php
		#Conecta ao MongoDB
		$m = new MongoClient();
		$db = $m -> mydb;
		$collection = $db -> leituras;
		?>

		<!-- Menu -->

		<!-- <nav class="navbar navbar-default" role="navigation"> -->
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">SOAEI</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="#">Link</a>
						</li>
						<li>
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
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->

		</div>

		<!-- Corpo -->
		=
		<!--Caixa de pesquisa-->
		<input id="pac-input" class="controls" type="text" placeholder="Digite um endereço...">

		<!--Mapa-->
		<div id="mapa"></div>

		<!--Painel de informações Mobile-->
		<div id="painelInfoMobile" class="hidden-lg hidden-md">
			<img src="./Web/imagens/index/menu-painel-movel.png" />
		</div>

		<!--Painel de informações-->
		<div id="painelInfo" class="hidden-xs hidden-sm">

			<!-- Quadro de alerta -->
			<a href="https://www.google.com.br">
			<div id="labelAlerta" class="alert alert-danger" role="alert">
				<strong>Oh snap!</strong> Change a few things!
			</div> </a>

			<!-- Tabela -->
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

		<!-- JQuery -->
		<script src="./Web/js/geral/jquery.min.js"></script>

		<!-- Bootstrap -->
		<script src="./Web/bootstrap-3.2.0/js/bootstrap.min.js"></script>

		<!-- Scripts de Compatibilidade -->
		<script src="./Web/js/geral/ie-emulation-modes-warning.js"></script>
		<script src="./Web/js/geral/ie10-viewport-bug-workaround.js"></script>

		<!-- MAPA -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=weather"></script>
		<script src="./Web/js/index/mapa.js" type="text/javascript"></script>

	</body>
</html>

<!-- Lixo -->

<?php
/*
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
 echo '</style>';*/
?>

<!-- tela Modal sms
<div id="myModal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

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
$cursor -> limit(5);

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
<!-- botao fechar tela modal sms
<button type="button" class="btn btn-primary" data-dismiss="modal">
Fechar
</button>
</div>
</div>
</div>
</div>
fim tela modal sms-->
<?php

#http://simplehtmldom.sourceforge.net/manual.htm
include "./Web/lib/simple_html_dom.php";

$html = file_get_html('http://www.defesacivil.sc.gov.br/');

echo "<br>";
echo "<br>";
echo "<br>";
echo $html -> getElementById("user5");
/*
 echo "<br>";
 echo "<br>";
 echo "<br>";
 echo $teste;*/
?>
