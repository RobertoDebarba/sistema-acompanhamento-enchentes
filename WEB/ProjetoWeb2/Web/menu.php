<?php
	function printMenu($menuAtivo, $itensDireita = array()) { ?>
		<style>
			#linhaMenu {
				height: 51px;
			}
		</style>
		
		<!-- Menu -->
		<div id="linhaMenu" class="container-fluid">
			<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand active" href="index.php">Monitor de Enchentes</a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li <?php if($menuAtivo == 0) {echo 'class="active"';} ?>>
								<a href="index.php">Inicio</a>
							</li>
							<!-- Aparece apenas no mobile -->
							<li>
								<a data-toggle="modal" data-target="#modalMedicoes" class="hidden-md hidden-lg">Medições</a>
							</li>
							<!-- -->
							<li <?php if($menuAtivo == 1) {echo 'class="active"';} ?>>
								<a href="page-historico_medicoes.php">Histórico</a>
							</li>
							<li <?php if($menuAtivo == 2) {echo 'class="active"';} ?>>
								<a href="page-previsao_tempo.php">Previsão do Tempo</a>
							</li>
							<!-- Aparece apenas no Desktop -->
							<li <?php if($menuAtivo == 3) {echo 'class="active"';} ?> class="hidden-xs hidden-sm">
								<a href="page-galeria.php">Galeria</a>
							</li>	
							<li <?php if($menuAtivo == 4) {echo 'class="active"';} ?> class="hidden-xs hidden-sm">
								<a href="javascript:void(0);" onclick="ativarSimulador();">Simulador de Inundações</a>
							</li>
							<!-- -->
							<!-- Aparece apenas no mobile -->
							<li class="hidden-md hidden-lg">
								<a data-toggle="modal" data-target="#modalBaixarApp">Aplicativo</a>
							</li>
							<!-- -->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mais<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a data-toggle="modal" data-target="#modalSitesUteis">Sites Uteis</a>
									</li>
									<!-- Aparece apenas no Desktop -->
									<li class="hidden-xs hidden-sm">
										<a data-toggle="modal" data-target="#modalBaixarApp">Baixe o Aplicativo</a>
									</li>
									<!-- Aparece apenas no Desktop -->
									<li class="hidden-xs hidden-sm">
										<a data-toggle="modal" data-target="#modalWS">Web Service</a>
									</li>
									<!-- -->
									<li class="divider"></li>
									<li>
										<a data-toggle="modal" data-target="#modalSobre">Sobre</a>
									</li>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<?php
								foreach ($itensDireita as $item) {
									echo "<li>$item</li>";
								}
							?>
					    </ul>
					</div>
				</div>
			</div>
		</div>
			
<?php } ?>