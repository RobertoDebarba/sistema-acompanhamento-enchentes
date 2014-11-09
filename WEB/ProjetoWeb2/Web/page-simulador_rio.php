<?php
	include 'header.php';
	$meta = array();

	$meta['pag_inicial'] = false;
	$meta['pagina'] = 'Simulador de Inundações';
	$meta['descricao'] = 'Simulador de Inundações';
	$meta['css'] = array('css/page-simulador_rio.css');
	$meta['menuAtivo'] = 0;

	printHeader($meta);
?>

<!-- Corpo -->
<div id="linhaCorpo" class="container-fluid">
	<!--Caixa de pesquisa-->
	<input id="pac-input" class="controls" type="text" placeholder="Digite um endereço...">

	<!--Mapa-->
	<div id="mapa"></div>
</div>

<!-- MAPA -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=weather"></script>
<script src="js/mapaSimulador.js" type="text/javascript"></script>

<?php
	include 'footer.php';
	printFooter();
?>