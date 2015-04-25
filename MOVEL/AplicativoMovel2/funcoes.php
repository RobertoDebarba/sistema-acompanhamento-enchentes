<?php
	function MongoConnect(){
		date_default_timezone_set('America/Sao_Paulo');
		global $collectionLeituras;
		global $collectionEnchentes;
		global $collectionAlturaRio;
		$con = new MongoClient("mongodb://localhost/mydb");
		$db = $con->selectDB("mydb");
		
		$collectionEnchentes = new MongoCollection($db, 'enchentes');
		
		$collectionLeituras = new MongoCollection($db, 'leituras');
		
		$collectionAlturaRio = new MongoCollection($db, 'alturaRio');
	}
		
	if (isset($_GET["getLeituras"])) {
		header('content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");
		
		//MongoConnect();
		
		echo json_encode(getLeituras($_GET['qtdLeituras']));        
    }
	
	if (isset($_GET['getEstadoAlerta'])) {
		header('content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");	
		
		//MongoConnect(); 
		
        echo json_encode(getEstadoAlerta());
    }
	
	if (isset($_GET['getEnchentes'])) {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");   
		
		MongoConnect();
		
        echo $_GET["getEnchentes"].' ('.json_encode(getEnchentes()).")";
    }
	
	if (isset($_GET['getAlturaRio'])) {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");   
		
		MongoConnect();
		
        echo $_GET["getAlturaRio"].' ('.json_encode(getAlturaRio()).")";
    }

	if (isset($_GET['getDadosCeops'])) {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");   
		
        echo json_encode(getDadosCeops($_GET['getDadosCeops']));
    }
	
	/*
	 * Executa ao enviar POST do formulario da page-galeria.php
	 */
	if (isset($_REQUEST['cidade'])) {
	    header('Access-Control-Allow-Origin: *');
	
	    header('Access-Control-Allow-Methods: GET, POST');
	
	    header("Access-Control-Allow-Headers: X-Requested-With");
		
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
				printAlert("Erro: Tamanho do arquivo maior que 2014 * 2014!");
			#Envia arquivo
			} else {
				#Seta caminhos
				$pastaImg = '/opt/lampp/htdocs/jonathan/Projeto Web/final/galeria/imagens/';
				$pastaThumbs = '/opt/lampp/htdocs/jonathan/Projeto Web/final/galeria/thumbs/';
				#Pega extenção da imagem
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $_FILES['imagem']['name'], $ext);
	    		$ext_imagem = $ext[1];
				#Gera um nome único para a imagem
				$nome_imagem = md5(uniqid(time()));
	    		
				#Redimenciona e move para pastas
				#http://www.verot.net/php_class_upload.htm
				include "lib/class.upload.php";
				
				$handle = new upload($_FILES['imagem']);
			    if ($handle->uploaded) {
			    	#Salva arquivo original
			    	$handle->file_new_name_body   = $nome_imagem;
			    	$handle->process($pastaImg);
			        if ($handle->processed) {
			        	
			            #Redimencio e salva arquivo Thumbs
						$handle->file_new_name_body   = $nome_imagem;
				        $handle->image_resize         = true;
				        $handle->image_x              = 250;
				        $handle->image_y      		  = 170;
				        $handle->process($pastaThumbs);
				        if ($handle->processed) {
							#Enviado com sucesso
				            $handle->clean();
							
							#Salva no banco de dados
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
								echo $_REQUEST.' ('.json_encode($nome_imagem).")";
								
							} else {
								printAlert("Erro desconhecido ao enviar imagem!");
							}
				        } else {
				        	printAlert("Erro desconhecido ao enviar imagem!");
				            echo 'error : ' . $handle->error;
				        }
			        } else {
			        	printAlert("Erro desconhecido ao enviar imagem!");
			            echo 'error : ' . $handle->error;
			        }	
			    }		
			}
		} else {
			$erro = 'Erro ao enviar arquivo';
		}
	}

	//********* FIM DOS GETS ***********	
	
	/**
	 * busca as enchente ocorridas na historia 
	 * @return array[2]
	 * @return [0] d: ata
	 * @return [1] : nivel
	 */
	function getEnchentes () {
		global $collectionEnchentes;
		
		$array = array();
		$i = 0;
		foreach ($collectionEnchentes as $obj) {
			$array[$i][0] = $obj['Data'];
			$array[$i][1] =  $obj['NivelRio'];
			$i++;
		}
		
		return $array;		
	}
	
	/**
	 * Verifica nivel do rio na ultima leitura e avisos no site da Defesa Civil de SC
	 * 
	 * @return array[4]
	 * @return [0] = Nivel do Rio: 0- Normal, 1- Alerta, 2- Inundação
	 * @return [1] = Defesa Civil: 0- Nada encontrado, 1- Aviso encontrado
	 * @return [2] = nivel do Rio;
	 * @return [3] = chuva;
	 */	 
	function getEstadoAlerta() {
		global $collectionLeituras;
		global $nivelEnchente;
		$nivelEnchente = 5.35;
		
		/**
		 * Verifica avisos no site da Defesa Civil de SC e busca por palavras chave
		 * 
		 * @return boolean: true= avisos encontrados, false= nada encontrado
		 * @see http://simplehtmldom.sourceforge.net/manual.htm 
		 */
		function verificarEstadoDefesaCivil() {
			
			#Converte erros em exceções
			function exception_error_handler($errno, $errstr, $errfile, $errline) {
				throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
			}
			set_error_handler("exception_error_handler");
			
			try {
				#Palavras chave de pesquisa
				$palavrasChave = array('Timbó', 'Blumenau', 'médio vale');
				
				#Busca quadro de informações no site da defesa civil
				#include "./Comum/php/lib/simple_html_dom.php";
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
		$nivelRioAlerta = $nivelEnchente / 2;
		$nivelRioInundacao = $nivelEnchente;

		#Busca ultimo dado valido
		$dados = getLeituras(1);
		
		$val = $dados[0];
		$nivelRio = $val['vlr_nivel'];//QG testes**********************
		$chuva = $val['vlr_precipitacao'];//QG testes**********************
		
		#Avalia resultados
		$retorno = array('0','0','0','0');
		$retorno['2'] = $nivelRio;
		$retorno['3'] = $chuva;
		
		if (($nivelRio >= $nivelRioAlerta) & ($nivelRio < $nivelRioInundacao)) {
			$retorno['0'] = '1';
		} else if ($nivelRio >= $nivelRioInundacao) {
			$retorno['1'] = '2';
		}
		if (verificarEstadoDefesaCivil()) {
			$retorno['1'] = '1';
		}
		
		return $retorno;
	}

	/**
	 * Busca a quantidade definida de leituras no banco de dados
	 * 
	 * @param qtdLeituras = quantidade de leituras a retornar
	 * @param leiturasValidas = se true, retorna apenas leituras validas (nuvel <> 'null')
	 * @return array[][] = 0: numero da leitura, 1= valor (0-dataHora, 1-nivelRio, 2-nivelChuva)
	 */
	function getLeituras($qtdLeituras, $leiturasValidas = true) {
		global $collectionLeituras;
		
		return getDadosCeops($qtdLeituras); //QG testes**************
		
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
		$i = '1';
		foreach ($cursor as $document) {
			$Hora = date(DATE_ISO8601, $document["dataHora"] -> sec);
			
			$leituras[$i]['0'] = date("d/m", strtotime($Hora));
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
	
	function getAlturaRio() {
		global $collectionAlturaRio;
		$cursor = $collectionAlturaRio -> find();
		foreach ($cursor as $document) {
			$altura = $document["alturaRio"];
		}
		return $altura;
	}
		
	/**
	 * busca os dados do ceops
	 * 
	 * retorna json
	 * 
	 * Indexes do json:	  
	 * cd_estação: numero da estação
	 * ds_cidade: nome da cidade
	 * data: data e hora da leitura
	 * vlr_nivel: nivel atual do rio
	 * vlr_precipitação: chuva(acredito que seja % de chance de chuva)
	 * ds_ativo_nivel: status do senso nivel
	 * ds_ativo_chuva: status do senso chuva
	 * status : status das leituras = normal, alerta, perigo 
	 */
	function getDadosCeops($qtd) {
		$prejson = file_get_contents('http://ceops.furb.br/restrito/SisCeops/controllers/controller_pg.php?action=tabela_dados&cd_estacao=7315');
		
		$json = json_decode($prejson, true);
		
		$cont = 1;
		foreach ($json as $reg => $dados) {
			if ($cont > $qtd){
				unset($json[$reg]);
				continue;
			}
						
			foreach ($dados as $key => $value) {				
				if ($key == 'data'){
					$dados[$key] = DateTime::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d')
					."T".DateTime::createFromFormat('d/m/Y H:i', $value)->format('H:i:s');
				}
			}	
			$json[$reg] = $dados;	

			$cont++;								
		}	
		//echo json_encode($json);
		return $json;				
	}
	
?>