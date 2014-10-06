<?php
	
	#Conecta ao MongoDB
	$m = new MongoClient();
	$db = $m -> mydb;
	$collectionLeituras = $db -> leituras;
	
	
	/**
	 * Verifica nivel do rio na ultima leitura e avisos no site da Defesa Civil de SC
	 * 
	 * @return array[2]
	 * @return [0] = Nivel do Rio: 0- Normal, 1- Alerta, 2- Inundação
	 * @return [1] = Defesa Civil: 0- Nada encontrado, 1- Aviso encontrado
	 */
	function getEstadoAlerta() {
		
		global $collectionLeituras;
		
		/**
		 * Verifica avisos no site da Defesa Civil de SC e busca por palavras chave
		 * 
		 * @return boolean: true= avisos encontrados, false= nada encontrado
		 * @see http://simplehtmldom.sourceforge.net/manual.htm 
		 */
		function verificarEstadoDefesaCivil() {
			
			#Palavras chave de pesquisa
			$palavrasChave = array('Timbó', 'Blumenau', 'Litoral Norte');
			
			#Busca quadr de informações no site da defesa civil
			include "./Comum/php/lib/simple_html_dom.php";
			$html = file_get_html('http://www.defesacivil.sc.gov.br/');
			
			#Filtra dados			
			$html =  $html -> getElementById("user5");
			$html = $html -> find("p");
			
			#Varre dados em busca de palavras chave
			$cont = 0;
			$achouSemAviso = false;
			$achouPalavra = false;
			foreach ($html as $key => $value) {
				if ($cont != 0) {
					
					#Procura por "Sem aviso."
					if (strpos($value,'Sem aviso.') !== false) {
					    $achouSemAviso = true;
					}
					
					#Procura por palavras Chave
					foreach ($palavrasChave as $key => $palavraChave) {
						if (strpos($value, $palavraChave) !== false) {
						    $achouPalavra = true;
						}
					}	
				}
				$cont++;
			}
			
			#Se não achou "Sem aviso" e achou palavra chave
			if (!$achouSemAviso & $achouPalavra) {
				return true;
			} else {
				return false;
			}
			
		}
		
		#Define constantes
		$nivelRioAlerta = 7;
		$nivelRioInundacao = 10;

		#Busca ultimo dado valido
		$query = array('nivelRio' => array('$ne' => 'null'));
		$cursor = $collectionLeituras -> find($query);
		$cursor -> sort(array('dataHora' => -1));
		$cursor -> limit(1);
	
		foreach ($cursor as $document) {
			$nivelRio = $document["nivelRio"];
		}
		
		#Avalia resultados
		$retorno = array(0, 0);
		
		if (($nivelRio >= $nivelRioAlerta) & ($nivelRio < $nivelRioInundacao)) {
			$retorno[0] = 1;
		} else if ($nivelRio >= $nivelRioInundacao) {
			$retorno[0] = 2;
		}
		if (verificarEstadoDefesaCivil()) {
			$retorno[1] = 1;
		}
		
		return $retorno;		
	}

	/*
	 * Em construção
	 */
	function getLeituras($qtdLeituras, $leiturasValidas = true) {
		
		global $collection;
		
		#Busca ultimas leituras
		if ($leiturasValidas) {
			$query = array('nivelRio' => array('$ne' => 'null'));
			$cursor = $collection -> find($query);
		} else {
			$cursor = $collection -> find();
		}
		$cursor -> sort(array('dataHora' => -1));
		$cursor -> limit($qtdLeituras);

		#Monta array
		$leituras[] = array();

		#Imprime leituras na tabela
		foreach ($cursor as $document) {
			$Hora = date(DATE_ISO8601, $document["dataHora"] -> sec);

			echo "<tr>";
			echo "<td>" . date("d/m/Y", strtotime($Hora)) . ", " . date("h:i:sa", strtotime($Hora)) . "</td>";
			echo "<td>" . $document["nivelRio"] . "</td>";
			echo "<td>" . $document["nivelChuva"] . "</td>";
			echo "</tr>";
		}
	}
?>