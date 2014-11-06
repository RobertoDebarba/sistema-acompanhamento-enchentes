
/**
 *chama o garregamento dos graficos
 * */
function loadchart(){		    	
	google.load("visualization", "1.0", {"callback" : drawVisualization, packages:["corechart"]});	
}

/**
 * pinta os graficos
 */
function drawVisualization() {		
    dataTable1 = google.visualization.arrayToDataTable(dataArray);

	var options1 = {
	    title: 'Histórico de Medições',
		legend: { position: 'none' },
		pointSize: 5
	};
	
	var chart = new google.visualization.LineChart(document.getElementById('graficoRio'));				

	chart.draw(dataTable1, options1);
}
