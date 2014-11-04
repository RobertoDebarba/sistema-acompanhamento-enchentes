<?php
	include 'header.php';
	$meta = array();

	$meta['pag_inicial'] = true;
	$meta['descricao'] = 'Sistema Online de Acompanhamento de Enchentes e Inundações';
	$meta['css'] = array('css/index.css', 'css/mapa-index.css');
	$meta['menuAtivo'] = 0;

	printHeader($meta);

	$alerta = getEstadoAlerta();
?>

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
		<thead>
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

<!-- MAPA -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=weather"></script>
<script src="js/mapa.js" type="text/javascript"></script>

<?php
	include 'footer.php';
	printFooter();
?>
