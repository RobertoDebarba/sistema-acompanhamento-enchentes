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
								echo "<td>" . $leituras[$i][0] . " - " . $leituras[$i][1] . " h</td>";
								echo "<td>" . $leituras[$i][2] . " m</td>";
								echo "<td>" . $leituras[$i][3] . "</td>";
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
  						<a>
  							<img src="imagens/apple-store.png" width="130px" height="45px"/>
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

<!-- Sobre MODAL -->
<div id="modalSobre" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Sistema Online de Acompanhamento de Enchentes e Inundações</h4>
			</div>
			<div class="modal-body">
				<br />
				<p>
					Projeto submetido como TCC ao Curso Técnico em Informática com Habilitação em Desenvolvimento de Software.
				</p>
				<p>
					CEDUP Timbó, 2014.
				</p>
				<br>
				<p>
					Jonathan Eli Suptitz,<br />
					Luan Carlos Purim, <br />
					Roberto Luiz Debarba
				</p>
				<br />
				<p>
					Copyright 2014.<br />
					Timbó, Santa Catarina - Brasil.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Web Service MODAL -->
<div id="modalWS" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Web Service</h4>
			</div>
			<div class="modal-body">
				<br />
				<p>
					Para acesso as leituras de nível do rio e estado da chuva, o sistema disponibiliza um WebService.
					O sistema retornará os seguintes dados:
				</p>
				<p>
					<ul>
						<li>● Nível de rio: medida em metros em que o rio se encontrava no momento da medição;</li> 
						<li>● Nível de chuva: valores entre 0 e 2 (0 = chuva nula; 1 = chuva moderada; 2 = chuva intensa);</li> 
						<li>● Data/Hora: data e hora em que as leituras foram realizadas(formato ISO 8601);</li> 
					</ul>
				</p>
				<hr />
				<p>
					O WebService é baseado no protocolo SOAP e o cliente pode ser desenvolvido em qualquer linguagem de programação. 
					O metodo invocado é "leituras()", com os parametros:
				</p>  
				<p>
					<ul>
						<li>● Quantidade de Leituras: a quantidade de leituras a serem buscadas;
						Obs: Limite de 15 leituras por busca.</li>
						<li>● Data/hora: texto com a data e hora em que as leituras foram feitas;
						Obs: a data/hora deve ser passado no formato ISO 8601 (yyyy-mm-ddTHH:mmZ);</li>
				 	</ul>
				 </p>
				 <hr />
				 <p>
				 	A busca retornará qualquer leitura efetuada antes da data e hora passados como parâmetro.
				 </p>
				 <p>
				 	<a href="http://54.232.207.63:8080/axis2/services/listServices" target="_blank">Clique aqui para acessar a página do WebService</a> 
				 </p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div>
	</div>
</div>