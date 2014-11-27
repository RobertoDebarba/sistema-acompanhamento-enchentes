<?php
	#Call do app mobile -> Leituras
	if (isset($_GET["getLeituras"])) {
		header('content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");
		
		echo $_GET["getLeituras"].' ('.json_encode(getLeituras($_GET['qtdLeituras'], true)).')';        
    }
	
	#Call do app mobile -> EstadoAlerta
	if (isset($_GET['getEstadoAlerta'])) {
		header('content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");	
		
        echo $_GET["getEstadoAlerta"].' ('.json_encode(getEstadoAlerta()).")";
    }
	
	#Call do app mobile -> Enchentes
	if (isset($_GET['getEnchentes'])) {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");   
		
        echo $_GET["getEnchentes"].' ('.json_encode(getEnchentes($_GET['elevAtual'])).")";
    }
	
	#Call do app mobile -> ImagensGaleria
	if (isset($_GET['getImagensGaleria'])) {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");   
		
        echo $_GET["getImagensGaleria"].' ('.json_encode(getImagensGaleria()).")";
    }
	
	#Call do app mobile -> InfoImagem
	if (isset($_GET['getInfoImagem'])) {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");   
		
        echo $_GET["getInfoImagem"].' ('.json_encode(getInfoImagem($_GET['nomeImagem'])).")";
    }
    
    #Call do app mobile -> AlturaRio
	if (isset($_GET['getAlturaRio'])) {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");   
		
        echo $_GET["getAlturaRio"].' ('.json_encode(getAlturaRio()).")";
    }
	
	/**
	 * Verifica nivel do rio na ultima leitura e avisos no site da Defesa Civil de SC
	 * 
	 * @return array[2]
	 * @return [0] = Nivel do Rio: 0- Normal, 1- Alerta, 2- Inundação
	 * @return [1] = Defesa Civil: 0- Nada encontrado, 1- Aviso encontrado
	 */
	function getEstadoAlerta() {
		
		#Conecta ao MongoDB
		$m = new MongoClient();
		$db = $m -> mydb;
		$collectionLeituras = $db -> leituras;
		
		/**
		 * Verifica avisos no site da Defesa Civil de SC e busca por palavras chave
		 * 
		 * @return boolean: true= avisos encontrados, false= nada encontrado
		 * @see http://simplehtmldom.sourceforge.net/manual.htm 
		 */
		function verificarEstadoDefesaCivil() {
			
			try {
				#Palavras chave de pesquisa
				$palavrasChave = array('Timbó', 'Blumenau', 'Litoral Norte');
				
				#Busca quadr de informações no site da defesa civil
				include "lib/simple_html_dom.php";
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
			} catch (Exception $e) {
				#echo 'Cuaght exception: ', $e -> getMessage(), "\n";
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

	/**
	 * Busca a quantidade definida de leituras no banco de dados
	 * 
	 * @param qtdLeituras = quantidade de leituras a retornar
	 * @param leiturasValidas = se true, retorna apenas leituras validas (nuvel <> 'null')
	 * @return array[][] = 0: numero da leitura, 1: valor (0-data, 1-hora, 2-nivelRio, 3-nivelChuva)
	 */
	function getLeituras($qtdLeituras, $leiturasValidas = true) {
		
		#Conecta ao MongoDB
		$m = new MongoClient();
		$db = $m -> mydb;
		$collectionLeituras = $db -> leituras;
		
		#Busca ultimas leituras
		if ($leiturasValidas) {
			$query = array('nivelRio' => array('$ne' => 'null'));
			$cursor = $collectionLeituras -> find($query);
		} else {
			$cursor = $collectionLeituras -> find();
		}
		$cursor -> sort(array('dataHora' => -1));
		$cursor -> limit($qtdLeituras);

		#Insere leituras no array
		$leituras = array();
		$i = 0;
		foreach ($cursor as $document) {
			$Hora = date(DATE_ISO8601, $document["dataHora"] -> sec);
			
			$leituras[$i]['0'] = date("d/m/Y", strtotime($Hora));
			$leituras[$i]['1'] = date("H:i", strtotime($Hora));
			$leituras[$i]['2'] = strval($document["nivelRio"]);
			switch ($document["nivelChuva"]) {
				case 0:	
					$leituras[$i]['3'] = 'Nula';
					break;
				case 1:
					$leituras[$i]['3'] = 'Moderada';
					break;
				case 2:
					$leituras[$i]['3'] = 'Forte';
					break;
				default:
					$leituras[$i]['3'] = 'null';
					break;
			}
			
			$i++;
		}
		
		return $leituras;
	}
	
	/**
	 * Retorna todas enchentes cujo pico for maior ou igual ao informado.
	 * 
	 * @param elevAtual = Elevação atual.
	 * @return array[][] = 0: numero da enchente, 1: ->(0: Data, 1: Nivel de pico do rio)
	 */
	function getEnchentes($elevAtual) {
		
		#Conecta ao MongoDB
		$m = new MongoClient();
		$db = $m -> mydb;
		$collectionEnchentes = $db -> enchentes;
		
		$query = array('NivelRio' => array('$gte' => (double) $elevAtual));
		$cursor = $collectionEnchentes -> find($query);
		
		$enchentes = array();
		$i = 0;
		foreach ($cursor as $document) {
			$enchentes[$i][0] = $document['Data'];
			$enchentes[$i][1] =  $document['NivelRio'];
			$i++;
		}
		
		return $enchentes;		
	}
	
	/**
	 * Retorna todas as imagens da galeria
	 * 
	 * @return array[]
	 */
	function getImagensGaleria() {
		
		#Conecta ao MongoDB
		$m = new MongoClient();
		$db = $m -> mydb;
		$collectionGaleria = $db -> galeria;
		
		$cursor = $collectionGaleria -> find() -> fields(array('imagem' => true));
		
		$galeria = array();
		$i = 0;
		foreach ($cursor as $document) {
			$galeria[$i] = $document['imagem'];
			$i++;
		}
		
		return $galeria;	
	}
	
	/**
	 * Retorna todas as informações de uma imagem
	 * 
	 * @param nomeImagem Nome da Imagem salva no banco
	 * @return array[] contendo 'imagem', 'cidade', 'bairro', 'rua', 'data', 'hora'
	 */
	function getInfoImagem($nomeImagem) {
		
		#Conecta ao MongoDB
		$m = new MongoClient();
		$db = $m -> mydb;
		$collectionGaleria = $db -> galeria;
		
		$query = array('imagem' => $nomeImagem);
		$cursor = $collectionGaleria -> find($query);
		
		$imagem = array();
		foreach ($cursor as $document) {
			$imagem['imagem'] = $document['imagem'];
			$imagem['cidade'] = $document['cidade'];
			$imagem['bairro'] =  $document['bairro'];
			$imagem['rua'] =  $document['rua'];
			$imagem['data'] =  $document['data'];
			$imagem['hora'] =  $document['hora'];
		}
	  
	    return $imagem;
	}
	
	/**
	 * Retorna a altura do rio em relação ao nivel do mar
	 * 
	 * @return double com altura
	 */
	function getAlturaRio() {
		#Conecta ao MongoDB
		$m = new MongoClient();
		$db = $m -> mydb;
		$collectionAlturaRio = $db -> alturaRio;
		
		$cursor = $collectionAlturaRio -> find();
		foreach ($cursor as $document) {
			$altura = $document["alturaRio"];
		}
		return $altura;
	}
	
	/**
	 * Rotina invoda no metodo POST do formulario de envio de imagens da page-galeria.php
	 */
	if (isset($_POST['action'])) {
		switch ($_POST['action']) {
			case 'envia_imagem' :
				$tiposPermitidos = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
				$tamanhoMaximo = 1024 * 1024 * 2;
			
				$arqNome = $_FILES['imagem']['name'];
				$arqType = $_FILES['imagem']['type'];
				$arqSize = $_FILES['imagem']['size'];
				$arqTemp = $_FILES['imagem']['tmp_name'];
				$arqError = $_FILES['imagem']['error'];
				
				function printAlert($mensagem) {
					echo "<script>alert('" . $mensagem . "')</script>";
				}
			
				if ($arqError == 0) {
					#Verifica tipo de arquivo
					if (!in_array($arqType, $tiposPermitidos)) {
						printAlert("Erro: Tipo de arquivo inválido!");
					#Verifica tamanho de arquivo
					} else if ($arqSize > $tamanhoMaximo) {
						printAlert("Erro: Tamanho do arquivo maior que 1024 * 1024!");
					#Envia arquivo
					} else {
						try {
							#Seta caminhos
							$pastaImg = dirname(dirname(__FILE__)) . '/galeria/imagens/';
							$pastaThumbs = dirname(dirname(__FILE__)) . '/galeria/thumbs/';
							#Pega extenção da imagem
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $_FILES['imagem']['name'], $ext);
				    		$ext_imagem = $ext[1];
							#Gera um nome único para a imagem
							$nome_imagem = md5(uniqid(time()));
				    		
							/*
							 * Biblioteca de manipulação de imagens
							 * http://www.codeforest.net/upload-crop-and-resize-images-with-php
							 * 
							 * Só mexa nessa rotina se quiser se encomodar.
							 */
							require_once('lib/ImageManipulator.php');
			
					        $manipulator = new ImageManipulator($_FILES['imagem']['tmp_name']);
							#Salva imagem original
							$manipulator->save("$pastaImg/$nome_imagem.$ext_imagem");
					        
							#Redimensiona e salva imagem thumbs
					        $manipulator->resample(250, 170, false);
					        $manipulator->save("$pastaThumbs/$nome_imagem.$ext_imagem");
			
							/*
							 * Salva informações no banco de dados
							 */
							$cidade = $_REQUEST['cidade'];
							$bairro = $_REQUEST['bairro'];
							$rua = $_REQUEST['rua'];
							$data = $_REQUEST['data'];
							$hora = $_REQUEST['hora'];
				
							$m = new MongoClient();
							$db = $m -> mydb;
							$collectionGaleria = $db -> galeria;
								
							$query = array('imagem' => $nome_imagem . "." . $ext_imagem, 'cidade' => $cidade, 'bairro' => $bairro,
								'rua' => $rua, 'data' => $data, 'hora' => $hora);
							
							$result = $collectionGaleria->insert($query);
							if ($result['ok']) {
								printAlert("Imagem enviada com sucesso!");
							} else {
								printAlert("Erro desconhecido ao enviar imagem!");
								print_r($result);
								break;
							}
						} catch(Exception $e) {
							printAlert("Erro ao salvar imagem!");
							echo $e->getMessage();
							break;
						}
					}
				} else {
					printAlert("Erro ao enviar imagem!");
				}
				
			break;
		}
	}
?>