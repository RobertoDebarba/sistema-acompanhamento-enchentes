<?php
	include 'header.php';
	$meta = array();

	$meta['pag_inicial'] = false;
	$meta['pagina'] = 'Previsão do Tempo';
	$meta['descricao'] = 'Previsão do Tempo';
	$meta['css'] = array('css/mapaClima.css', 'css/page-previsao_tempo.css');
	$meta['menuAtivo'] = 2;

	printHeader($meta);

	$alerta = getEstadoAlerta();
?>

		<div id="linhaCorpo" class="container-fluid">
			<!--Caixa de pesquisa-->
			<input id="pac-input" class="controls" type="text" placeholder="Digite um endereço...">

			<!--Mapa-->
			<div id="mapaClima"></div>
		</div>
		
		<div id="painelInfo" class="hidden-xs hidden-sm">
			<table>
				<tr>
					<td id="previsaoTempo" data-iframe-src="http://www.cptec.inpe.br/widget/widget.php?p=5400&w=n&c=909090&f=ffffff">
						<!-- Widget Previs&atilde;o de Tempo CPTEC/INPE -->
					</td>
				</tr>
				<tr>
					<td id="imgSatelite" data-img-src="http://ciram.epagri.sc.gov.br/ciram_arquivos/arquivos/saidas_scripts/img/satelite/goes13IR/anima.gif">
						<!-- Imagem Satelite. Carregado assincronamente com JS -->
					</td>
				</tr>
			</table>
		</div>		
		
		<!-- MAPA -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=places,weather&sensor=false"></script>
		<script src="js/mapaClima.js" type="text/javascript"></script>
		
		<!-- Carregamento Assincrono -->
		<script>
			$(function() {
			  setTimeout(function(){
			  	//Carrega Imagem de Satelite
			    $('td[data-img-src]').each(function(){
			      var src = $(this).attr('data-img-src');
			      $('<img>').attr('src', src).appendTo('#imgSatelite');
			    });
			    
			    //Carrega Previsao do Tempo
			    $('td[data-iframe-src]').each(function(){
			      var src = $(this).attr('data-iframe-src');
			      $('<iframe>').attr('src', src)
			      		.attr('allowtransparency', 'true')
			      		.attr('marginwidth', '0')
			      		.attr('marginheight', '0')
			      		.attr('hspace', '0')
			      		.attr('vspace', '0')
			      		.attr('frameborder', '0')
			      		.attr('scrolling', 'no')
			      		.attr('height', '46px')
			      		.attr('width', '312px')
			      		.appendTo('#previsaoTempo');
			    });
			  }, 600);
			});
		</script>
<?php
	include 'footer.php';
	printFooter();
?>