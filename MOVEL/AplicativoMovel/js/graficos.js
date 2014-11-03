
/**
 *chama o garregamento dos graficos
 * */
function loadchart(){		    	
	google.load("visualization", "1.0", {"callback" : drawVisualization, packages:["corechart"]});

	google.load("visualization", "1.0", {"callback" : drawVisualization, packages:["corechart"]});
}

/**
 * pinta os graficos
 */
function drawVisualization() {		
    dataTable1 = google.visualization.arrayToDataTable(dataArray);
    console.log(chuva);
    dataTable2 = google.visualization.arrayToDataTable(chuva);

	var options1 = {
	    title: 'Histórico de Medições',
	    curveType: 'function',
		legend: { position: 'none' },
		pointSize: 5
	};
	
	var options2 = {
	    title: 'Histórico de Chuva',
	    curveType: 'function',
		legend: { position: 'none' },
		pointSize: 5
	};
	
	var chart = new google.visualization.LineChart(document.getElementById('graficoRio'));				
	chart.draw(dataTable2, options2);
	
	var chart = new google.visualization.LineChart(document.getElementById('graficoChuva'));
	chart.draw(dataTable1, options1);
}
