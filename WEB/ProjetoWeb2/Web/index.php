<!DOCTYPE html>
<html>
	<head>
		<!-- Informações da página -->
		<meta charset="UTF-8">
		<title>SOAEI</title>

		<!-- Bootstrap -->
		<link href="./Web/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<link href="./Web/bootstrap-3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Estilo -->
		<link href="./Web/css/index/style.css" rel="stylesheet">
		<link href="./Web/css/index/mapa.css" rel="stylesheet" />

		<!-- Scripts de Compatibilidade -->
		<script src="./Web/js/geral/ie-emulation-modes-warning.js"></script>

	</head>
	<body>

		<!-- tela Modal sms -->
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

							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<!-- botao fechar tela modal sms -->
						<button type="button" class="btn btn-primary" data-dismiss="modal">
							Fechar
						</button>
					</div>
				</div>
			</div>
		</div>
		<!--fim tela modal sms-->

		<?php
		include "./Comum/php/funcoes.php";

		$alerta = getEstadoAlerta();
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
						<a class="navbar-brand" href="#">SOAEI</a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li class="active">
								<a href="#">Link</a>
							</li>
							<li>
								<a data-toggle="modal" data-target="#myModal" class="hidden-md hidden-lg">Medições</a>
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

		<!-- Corpo -->
		<div id="linhaCorpo" class="container-fluid">
			<!--Caixa de pesquisa-->
			<input id="pac-input" class="controls" type="text" placeholder="Digite um endereço...">

			<!--Mapa-->
			<div id="mapa"></div>
		</div>

		<!-- Linha de Rodapé -->
		<div id="linhaRodape" class="container-fluid hidden-md hidden-lg">

			<div id="painelInfoMobile">
				<?php
				$leituras = getLeituras(1, true);

				if ($alerta[1]) {
					echo '<a href="https://www.google.com.br">';
				}

				if (($alerta[0] == 0) & ($alerta[1] == 0)) {
					echo('<div class="alert alert-info" role="alert">Nivel do rio: ' . $leituras[0][1] . 'm | Chuva ' . $leituras[0][2] . '</div> ');
				} else if (($alerta[0] == 1) | (($alerta[1] == 1))) {
					echo('<div class="alert alert-warning" role="alert">Nivel do rio: ' . $leituras[0][1] . 'm | Chuva ' . $leituras[0][2] . '</div> ');
				} else if ($alerta[0] == 2) {
					echo('<div class="alert alert-danger" role="alert">Nivel do rio: ' . $leituras[0][1] . 'm | Chuva ' . $leituras[0][2] . '</div> ');
				}

				if ($alerta[1]) {
					echo '</a>';
				}
				?>
			</div>
		</div>

		<!--Painel de informações-->
		<div id="painelInfo" class="hidden-xs hidden-sm">

			<!-- Quadro de alerta -->
			<?php
			if ($alerta[1]) {
				echo '<a href="https://www.google.com.br">';
			}

			if (($alerta[0] == 0) & ($alerta[1] == 0)) {
				echo '<div id="labelAlerta" class="alert alert-info" role="alert"><strong>Normal.</strong> Sem riscos de inundação!</div> ';
			} else if (($alerta[0] == 1) | (($alerta[1] == 1))) {
				echo '<div id="labelAlerta" class="alert alert-warning" role="alert"><strong>Aviso!</strong> Alerta de inundação!</div> ';
			} else if ($alerta[0] == 2) {
				echo '<div id="labelAlerta" class="alert alert-danger" role="alert"><strong>Perigo!</strong> Estado de inundação!</div> ';
			}

			if ($alerta[1]) {
				echo '</a>';
			}
			?>

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
					$leituras = getLeituras(4, true);

					for ($i = 0; $i < count($leituras); $i++) {
						echo "<tr>";
						echo "<td>" . $leituras[$i][0] . "</td>";
						echo "<td>" . $leituras[$i][1] . " m</td>";
						echo "<td>" . $leituras[$i][2] . "</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>

		<!-- Scripts de Compatibilidade -->
		<script src="./Web/js/geral/ie10-viewport-bug-workaround.js"></script>

		<!-- JQuery -->
		<script src="./Comum/js/jquery.min.js"></script>

		<!-- Bootstrap -->
		<script src="./Web/bootstrap-3.2.0/js/bootstrap.min.js"></script>

		<!-- MAPA -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=weather"></script>
		<script src="./Comum/js/mapa.js" type="text/javascript"></script>

	</body>
</html>