<?php
	include 'header.php';
	$meta = array();
	
	$meta['pag_inicial'] = false;
	$meta['pagina'] = 'Galeria';
	$meta['descricao'] = 'Galeria Colaborativa';
	$meta['css'] = array('css/page-galeria.css');
	$meta['menuAtivo'] = 0;
	
	//Define Botão Direito do menu navegador
	$itensDireita = array();
	$itensDireita[] = '<a data-toggle="modal" data-target="#modalEnviarImagens">Enviar Imagens</a>';
	$meta['itensDireita'] = $itensDireita;
	
	
	printHeader($meta);
?>

<div id="linhaCorpo" class="container-fluid">
<!-- Lista de imagens -->
<div class="container">
	<ul class="row">
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="../Comum/galeria/thumbs/imgExe01.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="../Comum/galeria/thumbs/imgExe02.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="../Comum/galeria/thumbs/imgExe03.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="../Comum/galeria/thumbs/imgExe04.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="../Comum/galeria/thumbs/imgExe05.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="../Comum/galeria/thumbs/imgExe06.jpg">
		</li>
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
			<div class="modal-header">
				<h4 class="modal-title">Enviar Imagens</h4>
			</div>
			<!-- Corpo do Modal -->
			<div class="modal-body">
				<h2>Vertical (basic) form</h2>
				<form role="form">
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" placeholder="Enter email">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" id="pwd" placeholder="Enter password">
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox">
							Remember me</label>
					</div>
					<button type="submit" class="btn btn-default">
						Submit
					</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Import do script de galeria -->
<script src="js/galeria.js"></script>

<!-- FACEBOOK
<script>
window.fbAsyncInit = function() {
FB.init({
appId : '586048604832464',
xfbml : true,
version : 'v2.1'
});
}; ( function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) {
return;
}
js = d.createElement(s);
js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div id="fb-root"></div>
<script>
( function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id))
return;
js = d.createElement(s);
js.id = id;
js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=586048604832464&version=v2.0";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<div id="facebook">
<!-- LIKE SHARE --
<div
class="fb-like"
data-share="true"
data-width="450"
data-show-faces="true"></div>

<!-- LOGIN --
<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>

</div>
-->
<?php
	include 'footer.php';
	printFooter();
?>