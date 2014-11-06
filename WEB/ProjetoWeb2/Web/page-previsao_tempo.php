<?php
	include 'header.php';
	$meta = array();

	$meta['pag_inicial'] = false;
	$meta['pagina'] = 'Previsão do Tempo';
	$meta['descricao'] = 'Previsão do Tempo';
	$meta['css'] = array('css/mapaClima.css', 'css/page-previsao_tempo.css');
	$meta['menuAtivo'] = 0;

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
					<td>
						<!-- Widget Previs&atilde;o de Tempo CPTEC/INPE --><iframe allowtransparency="true" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" src="http://www.cptec.inpe.br/widget/widget.php?p=5400&w=n&c=909090&f=ffffff" height="46px" width="312px"></iframe><noscript>Previs&atilde;o de <a href="http://www.cptec.inpe.br/cidades/tempo/5400">Timbó/SC</a> oferecido por <a href="http://www.cptec.inpe.br">CPTEC/INPE</a></noscript><!-- Widget Previs&atilde;o de Tempo CPTEC/INPE -->
					</td>
				</tr>
				<tr>
					<td>
						<img src="http://ciram.epagri.sc.gov.br/ciram_arquivos/arquivos/saidas_scripts/img/satelite/goes13IR/anima.gif" />
					</td>
				</tr>
			</table>
		</div>		
		
		<!-- Scripts de Compatibilidade -->
		<script src="js/geral/ie10-viewport-bug-workaround.js"></script>

		<!-- JQuery -->
		<script src="../Comum/js/jquery.min.js"></script>

		<!-- Bootstrap -->
		<script src="bootstrap-3.2.0/js/bootstrap.min.js"></script>
		
		<!-- MAPA -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&libraries=weather"></script>
		<script src="js/mapaClima.js" type="text/javascript"></script>

<?php
	include 'footer.php';
	printFooter();
?>