
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
    var dataTable = google.visualization.arrayToDataTable(dataArray);

	var options = {
            title: 'Medição do Nível do Rio',
            legend: { position: 'none' },
            pointSize: 5,
            'chartArea': {'width': '80%'}
        };
	
	var chart = new google.visualization.LineChart(document.getElementById('graficoRio'));				

	chart.draw(dataTable, options);
}
