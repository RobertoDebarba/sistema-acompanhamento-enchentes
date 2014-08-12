package MapasGoogle;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONObject;

import Excecoes.ElevationAPIException;
import Excecoes.HTTPRequestException;

/**
 * Leitor de propriedades de mapa.<br>
 * Google Maps API<br>
 * 
 * @author roberto
 * @version 1.0
 * @see PontoMapa.java
 */
public class LeitorMapa {
	
	private HTTP_request httpRequest = new HTTP_request();
	private JSON_elevation jsonElevation = new JSON_elevation();
	
	/**
	 * Retorna uma Array bidimencional de PontoMapa com os pontos analisados em uma área.<br>
	 * <p>
	 * <b>Importante:</b><br>
	 * Máximo pontos por dia: 25.000;<br>
	 * </p>
	 * <p>
	 * <b>Exemplo:</b><br>
	 * <code>PontoMapa[][] pontos = getElevacaoPontosArea(double[] pontoInicial, double[] pontoFinal, 0.001);</code>
	 * </p>
	 * 
	 * @param pontoIni double[] ponto inicial da varredura
	 * @param pontoFin double[] ponto final da varredira
	 * @param distPontos double distancia entre os pontos analisados
	 * @return PontoMapa[][] com as informações dos pontos analisados
	 * @throws ElevationAPIException
	 * 
	 * @author roberto
	 */
	public PontoMapa[][] getElevacaoPontosArea(double[] pontoIni, double[] pontoFin, double distPontos) throws ElevationAPIException {
		
		//Timer - marca o tempo de operação
		long tempoInicial = System.currentTimeMillis();
		
		
		//Verifica quantidade de pontos VERTICAIS		
		int qtdPontoVer = 0;
		for (double i = Math.min(pontoIni[0], pontoFin[0]); i <= Math.max(pontoIni[0], pontoFin[0]); i += distPontos) {
			
			qtdPontoVer++;
		}
		
		//Veridica quantidade de ponto HORIZONTAIS
		int qtdPontoHor = 0;
		for (double i = Math.min(pontoIni[1], pontoFin[1]); i <= Math.max(pontoIni[1], pontoFin[1]); i += distPontos) {
			
			qtdPontoHor++;
		}
		
		//Verifica quantidade maxima de pontos
		int qtdPontosGeral = qtdPontoHor * qtdPontoVer;
		System.out.println(qtdPontosGeral + " pontos analisados.");
		if (qtdPontosGeral > 25000) {
			throw new ElevationAPIException("A quantidade de pontos analisados supera o limite de utilização gratuita do Google Maps Elevation API.");
		}
		
		//Cria Array que receberá os dados
		PontoMapa[][] pontos = new PontoMapa[qtdPontoVer][qtdPontoHor];
		
		/*
		 * Adiciona todos os pontos a serem analisados à List<double[]> listaPontos.
		 */
		List<double[]> listaPontos = new ArrayList<>();
		for (double i = Math.min(pontoIni[0], pontoFin[0]); i <= Math.max(pontoIni[0], pontoFin[0]); i += distPontos) {
			
			for (double z = Math.min(pontoIni[1], pontoFin[1]); z <= Math.max(pontoIni[1], pontoFin[1]); z += distPontos) {

				double[] ponto = {i,z};
				listaPontos.add(ponto);
			}
		}
		
		/*
		 * 1- Monta requisições(em List<double[]> listaPontosReq) respeitando tamnhos maximos de pontos e caracteres;
		 * 2- Adiciona as respostas a List<PontoMapa> listaRespostaPontos;
		 */
		int contPonto = 0;
		int contNumCarac = 62;
		List<double[]> listaPontosReq = new ArrayList<>();
		List<PontoMapa> listaRespostaPontos = new ArrayList<>();
		for (int i = 0; i < listaPontos.size(); i++) {

			/*
			 * Se quantidade de pontos for menos que 511
			 * Se não é o ultimo item da lista de pontos para enviar
			 * Se tamanho de carac da requisição não pe maior de 2048 (considerando que mais uma ponto será adicionado)
			 */
			if ((contPonto < 511) && (contPonto+1 < listaPontos.size()) && (contNumCarac + 60 < 2048)) {
				//Lista para requisição recebe +1 ponto
				listaPontosReq.add(listaPontos.get(contPonto));
				contPonto++;
				
				//Adiciona o tamnho adicinal da url de requisição
				contNumCarac += (listaPontos.get(contPonto)[0]+"").length();
				contNumCarac += (listaPontos.get(contPonto)[1]+"").length();
				contNumCarac += 4; // | e ,
			
			/*
			 * 1- Adiciona o ultimo ponto à lista de requisição
			 * 2- Envia requisição
			 * 3- Adiciona os pontos da resposta à lista final List<PontoMapa> listaRespostaPontos
			 */
			} else {
				//Lista para requisição recebe +1 ponto
				listaPontosReq.add(listaPontos.get(contPonto));
				
				//Envia requisição
				JSONObject json = null;
				try {
					json = httpRequest.sendGetElevation(listaPontosReq);
				} catch (HTTPRequestException e) {
					e.printStackTrace();
					System.err.println("Erro na requisição de elevação");
				}
				

				//Adiciona pontos lidos do JSON a uma lista temporaria
				List<PontoMapa> retornoPontos = jsonElevation.getPontosMapa(json);
				
				//Mescla lista à lista de repostas final
				for (int j = 0; j < retornoPontos.size(); j++) {
					listaRespostaPontos.add(retornoPontos.get(j));
				}

				//Limpa lista de pontos para requisição
				//Ela será preenchida novamente no decorrer do loop
				listaPontosReq.removeAll(listaPontosReq);
				
				//Reseta contadores de maximo de pontos e maximo e de caracteres
				contPonto = 0;
				contNumCarac = 62;
			}
		}
		
		/*
		 * Transforma lista de pontos em Array[][] de double para retornar
		 * O double[][] é organizado respeitando a localização de cada ponto na matriz
		 */
		int contColuna = 0;
		int contLinha = 0;
		for (int i = 0; i < listaRespostaPontos.size(); i++) {
			
			if (contColuna < qtdPontoHor -1) {
				pontos[contLinha][contColuna] = listaRespostaPontos.get(i);
			} else {
				pontos[contLinha][contColuna] = listaRespostaPontos.get(i);
				contColuna = -1;
				contLinha++;
			}
			
			contColuna++;
		}

		//Timer - Imprime o tempo decorrido
		System.out.println(((System.currentTimeMillis() - tempoInicial) < 1000) 
				? ((System.currentTimeMillis() - tempoInicial) + "milisegundos") 
						: (((System.currentTimeMillis() - tempoInicial)/1000)+" segundos"));
		
		return pontos;
	}
}
