<?php
	include 'header.php';
	$meta = array();

	$meta['pag_inicial'] = false;
	$meta['pagina'] = 'Historico de Medições';
	$meta['descricao'] = 'Historico de Medições';
	$meta['css'] = array('css/page-historico_medicoes.css');
	$meta['menuAtivo'] = 1;

	printHeader($meta);

	$alerta = getEstadoAlerta();
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Data', 'Nível do Rio', ],
			<?php
				$leituras = getLeituras(15, true);
				
				foreach ($leituras as $leitura) {
					echo "['$leitura[1]h', $leitura[2]],";
				}
			?>
		]);
	
		var options = {
			title: 'Medição do Nível do Rio',
			legend: { position: 'none' },
			pointSize: 5,
			'chartArea': {'width': '80%'}
		};
	
		var chart = new google.visualization.LineChart(document.getElementById('chartRio'));
		
		chart.draw(data, options);
	}
	
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
</script>

<div id="chartRio"></div>

<table class="table table-striped">
<thead>
	<tr>
		<td><b>Data - Hora</b></td>
		<td><b>Nível do Rio</b></td>
		<td><b>Estado da Chuva</b></td>
	</tr>
</thead>
<tbody>
	<?php 
		foreach ($leituras as $leitura) {
			echo "<tr>";
			echo "<td>$leitura[0] - $leitura[1] h</td>";
			echo "<td>$leitura[2] m</td>";
			echo "<td>$leitura[3]</td>";
			echo "</tr>";
		}
	?>
</tbody>

<?php
	include 'footer.php';
	printFooter();
?>