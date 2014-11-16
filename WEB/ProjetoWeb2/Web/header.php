<?php
	/**
	 * @param pag_inicial
	 * @param pagina
	 * @param descricao
	 * @param imagem
	 * @param css
	 * @param menuAtivo
	 */
	function printHeader($meta = array()) {
		
		$titulo = 'Monitor de Enchentes';
		$separador = ' - ';
		$logo_url = 'imagens/foto-regua.jpg';
		
		?>
		<!DOCTYPE html>
		<html lang="pt-br">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1">
			<link rel="shortcut icon" href="imagens/icon-water.ico">
			<?php
				# -- Titulo --
				#Se for pagina inicial
				if (isset($meta['pag_inicial']) && $meta['pag_inicial']) {
					echo "<title>$titulo</title>";
				#Se não for pagina inicial
				} else {
					$pagina = $meta['pagina'];
					echo "<title>$pagina $separador $titulo</title>";
				}
				
				# -- Descrição --
				if (isset($meta['descricao'])) {
					#descrição
					echo '<meta name="description" content="'.$meta['descricao'].'">';
					#OpenGraph Facebook
					echo '<meta property="og:title" content="'.$meta['descricao'].'"/>';
					echo '<meta property="og:type" content="website"/>';
				}
				
				# -- Imagem --
				if (isset($meta['imagem'])) {
					#OpenGraph Facebook
					echo '<meta property="og:image" content="'.$meta['imagem'].'"/>';
				} else {
					echo '<meta property="og:image" content="'.$logo_url.'"/>';
				}				
			?>
				<!-- Bootstrap -->
				<link href="bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet">
				<link href="bootstrap-3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">
		
				<!-- Scripts de Compatibilidade -->
				<script src="js/geral/ie-emulation-modes-warning.js"></script>
				
				<!-- JQuery -->
				<script src="js/geral/jquery.min.js"></script>
				
			<?php 
				# -- Importações --
				#Estilo
				foreach ($meta['css'] as $css) {
					echo '<link href="'.$css.'" rel="stylesheet">';
				}
			?>
		</head>
		<body>
			<?php
				#Converte erros em exceções
				function exception_error_handler($errno, $errstr, $errfile, $errline) {
					throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
				}
				set_error_handler("exception_error_handler");
				
				include "../Comum/php/funcoes.php";
				include "menu.php";
				include "modal.php";
				
				if (isset($meta['itensDireita'])) {
					printMenu($meta['menuAtivo'], $meta['itensDireita']);
				} else {
					printMenu($meta['menuAtivo']);
				}
			?>
		
<?php } ?>