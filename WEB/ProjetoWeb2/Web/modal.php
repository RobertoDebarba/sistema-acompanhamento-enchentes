<!-- Estilo -->
<link href="css/modal.css" rel="stylesheet">

<!-- Tela de medições MODAL
	Quando em modo Mobile, o item que chama esse modal aparece no navegaor -->
<div id="modalMedicoes" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Acompanhamento de Medições</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<td>Hora</td>
							<td>Nivel do Rio</td>
							<td>Estado da Chuva</td>
						</tr>
					</thead>
					<tbody>
						<?php						
							$leituras = getLeituras(4, true);
	
							for ($i = 0; $i < count($leituras); $i++) {
								echo "<tr>";
								echo "<td>" . $leituras[$i][0] . "</td>";
								echo "<td>" . $leituras[$i][1] . " m</td>";
								echo "<td>" . $leituras[$i][2] . "</td>";
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Sites Uteis MODAL -->
<div id="modalSitesUteis" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Sites Úteis</h4>
			</div>
			<div class="modal-body">
				<!-- Tabela -->
			<table class="table table-striped">
				<tbody>
					<tr>
						<td><a href="http://ceops.furb.br/" target="_blank">CEOPS - Centro de Opração do Sistema de Alerta</a></td>
					</tr>
					<tr>
						<td><a href="http://www.defesacivil.sc.gov.br/" target="_blank">Defesa Civil de Santa Catarina</a></td>
					</tr>
					<tr>
						<td><a href="http://www.timbo.sc.gov.br/" target="_blank">Prefeitura de Timbó</a></td>
					</tr>
					<tr>
						<td><a href="http://ciram.epagri.sc.gov.br/" target="_blank">EPAGRI/CIRAM</a></td>
					</tr>
					<tr>
						<td><a href="http://www.samae.com.br/" target="_blank">SAMAE</a></td>
					</tr>
				</tbody>
			</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Baixar app MODAL -->
<div id="modalBaixarApp" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Baixe o Aplicativo</h4>
			</div>
			<div class="modal-body">
				<h4>Para acessar todas as funções da ferramenta, baixe nosso aplicativo:</h4>
				<br>
				<div class="row">
					<!-- Google Play -->
					<div class="col-md-6">
				  		<a>
							<img alt="Get it on Google Play" src="https://developer.android.com/images/brand/pt-br_generic_rgb_wo_45.png" />
						</a>
  					</div>
  					<!-- Apple Store -->
  					<div class="col-md-6">
  						<a target="itunes_store" style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/htmlResources/assets/pt_br//images/web/linkmaker/badge_appstore-lrg.png) no-repeat;width:135px;height:40px;@media only screen{background-image:url(https://linkmaker.itunes.apple.com/htmlResources/assets/pt_br//images/web/linkmaker/badge_appstore-lrg.svg);}">
						</a>
  					</div>
				</div>	
				<div class="row">
					<!-- Windows Store -->
  					<div class="col-md-6">
  						<a>
							<img src="imagens/windows-phone-store.png" width="130px"/>
						</a>
  					</div>
  					<!-- Firefox Marketplace -->
  					<div class="col-md-6">
  						<a>
							<img src="imagens/firefox-marketplace.png" width="130px"/>
						</a>
  					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div>
	</div>
</div>