	<div id="graficoRio" class="row">
		<script type="text/javascript">
		loadchart();
		</script>
	</div>
  	<div class="row">
		<table id="tabela" class="table table-bordered">
			<thead class="tituloTabela">
				<tr>
					<td>Hora</td>
					<td>Nivel do Rio</td>
					<td>Estado da Chuva</td>
				</tr>
			</thead>
			<tbody>
				<?php
				include "../Comum/php/funcoes.php";
				
				$leituras = getLeituras(12, true);
		
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