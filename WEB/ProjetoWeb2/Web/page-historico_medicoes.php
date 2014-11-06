<?include "../Comum/php/funcoes.php";  ?><html>
<head>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Data', 'Nível do Rio', ],
				<?php
					$leituras = getLeituras(20, true);
					
					foreach ($leituras as $leitura) {
						echo "['$leitura[0]', $leitura[1]],";
					}
				?>
			]);
		
			var options = {
				title: 'Histórico de Medições',
			    
				legend: { position: 'none' },
				pointSize: 5
			};
		
			var chart = new google.visualization.LineChart(document.getElementById('chartRio'));
			
			chart.draw(data, options);
		}
		
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
	</script>
</head>
<body>
	<div id="chartRio" style="width: 1500px; height: 500px;"></div>
</body>
</html>

