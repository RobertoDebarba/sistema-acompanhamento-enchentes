<?php
	include 'header.php';
	$meta = array();
	
	$meta['pag_inicial'] = false;
	$meta['pagina'] = 'Galeria';
	$meta['descricao'] = 'Galeria Colaborativa';
	$meta['css'] = array('css/page-galeria.css');
	$meta['menuAtivo'] = 3;
	
	//Define Botão Direito do menu navegador
	$itensDireita = array();
	$itensDireita[] = '<a data-toggle="modal" data-target="#modalEnviarImagens">Enviar Imagens</a>';
	$meta['itensDireita'] = $itensDireita;
	
	printHeader($meta);
?>

<!-- Biblioteca de input de arquivo -->
<script type="text/javascript" src="bootstrap-filestyle/bootstrap-filestyle.js"> </script>

<!--Biblioteca de Marcaras de campos -->
<script src="jquery-maskedinput/jquery.maskedinput.js" type="text/javascript"></script>

<!-- Lista de imagens -->
<div class="container">
	<ul class="row">
		<?php 
			#Busca itens da galeria no banco
			$galeria = getImagensGaleria();
			
			#Imprime itens
			if (isset($galeria[0])) {
				foreach ($galeria as $itemGaleria) {
					echo '<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">';
					echo '<img class="img-responsive" src="../Comum/galeria/thumbs/'.$itemGaleria.'">';
					echo '</li>';
				}	
			}
		?>
	</ul>
</div>

</div>

<!-- Modal de exibição de imagens -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>

<!-- Modal de envio de imagens -->
<div id="modalEnviarImagens" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Inicio FORM -->
			<form role="form" action="" method="post" id="form" enctype="multipart/form-data">
				<!-- Inicio MODAL -->
				<div class="modal-header">
					<h4 class="modal-title">Enviar Imagens</h4>
				</div>
				
				<div class="modal-body">				
					<input type="hidden" name="action" value="envia_imagem" />
					
					<div class="form-group">
						<label for="cidade">Cidade:</label>
						<input type="text" class="form-control" name="cidade" id="cidade" placeholder="Digite a cidade...">
					</div>
					<div class="form-group">
						<label for="ano">Bairro:</label>
						<input type="text" class="form-control" name="bairro" id="bairro" placeholder="Digite o bairro...">
					</div>
					<div class="form-group">
						<label for="ano">Rua:</label>
						<input type="text" class="form-control" name="rua" id="rua" placeholder="Digite a rua...">
					</div>
					<div class="form-group left">
						<label for="ano">Data:</label>
						<input type="text" class="form-control" name="data" id="data" placeholder="Digite a data...">
					</div>
					<div class="form-group right">
						<label for="ano">Hora:</label>
						<input type="text" class="form-control" name="hora" id="hora" placeholder="Digite a hora...">
					</div>
					<label for="imagem">Imagem:</label>
					<input type="file" class="filestyle" name="imagem" id="filestyle-3" tabindex="-1">
				</div>				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Fechar
					</button>
					<button type="submit" class="btn btn-primary">
						Enviar
					</button>
				</div>
				<!-- Fim MODAL -->
			</form>
			<!-- Fim FORM -->
		</div>
	</div>
</div>

<!-- Import do script de galeria -->
<script src="js/galeria.js"></script>

<script>
	// Define mascaras do modal de envio
	$("#data").mask("99/99/9999");
	$("#hora").mask("99:99 h");
	
	//Testa se campos foram preenchidos
	$('form').submit(function(e) { 
		if (($("#filestyle-3").val()=='') || 
			($("#cidade").val()=='') || 
			($("#bairro").val()=='') ||
			($("#rua").val()=='') || 
			($("#data").val()=='') || 
			($("#hora").val()=='')) {
			
			e.preventDefault();
			alert("Todos os campos são obrigatorios!");
		}
	});
	
	//Envia POST do formulario de cadastro de imagem
	$('#form').submit(function(){
		dados = $( this ).serialize();
	    $.ajax({
			type: "POST",
			url: "./Comum/php/funcoes.php",
			data: dados,
			success: function(result){
				alert(result);
			}
		});
	});
</script>

<?php
	include 'footer.php';
	printFooter();
?>