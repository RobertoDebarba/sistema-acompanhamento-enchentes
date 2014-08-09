package AnaliseArea;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

import org.json.JSONObject;

import GoogleMaps_API.HTTP_request;
import GoogleMaps_API.JSON_elevation;
import Principal.LeitorElevacao;

public class Loop_area {
	
	private HTTP_request httpRequest = new HTTP_request();
	private JSON_elevation jsonElevation = new JSON_elevation();
	
	//3ª casa decimal aumenta 2 unidade
	private final double variacao = 0.001;
	

	public PontoMapa[][] varrerArea(double[] pontoIni, double[] pontoFin) {
		
		//Verifica quantidade de pontos VERTICAIS		
		int qtdPontoVer = 0;
		for (double i = Math.min(pontoIni[0], pontoFin[0]); i <= Math.max(pontoIni[0], pontoFin[0]); i += variacao) {
			
			qtdPontoVer++;
		}
		
		//Veridica quantidade de ponto HORIZONTAIS
		int qtdPontoHor = 0;
		for (double i = Math.min(pontoIni[1], pontoFin[1]); i <= Math.max(pontoIni[1], pontoFin[1]); i += variacao) {
			
			qtdPontoHor++;
		}
		
		//Verifica quantidade maxima de pontos
		int qtdPontosGeral = qtdPontoHor * qtdPontoVer;
		System.out.println(qtdPontosGeral + " pontos analisados.");
		if (qtdPontosGeral > 25000) {
			System.err.println("A quantidade de pontos analisados supera o limite de utilização gratuita do Google Maps Elevation API.");
			System.exit(0);
		}
		
		//Cria Array que receberá os dados
		PontoMapa[][] pontos = new PontoMapa[qtdPontoVer][qtdPontoHor];
		
		//Varre area alimentando array
		int pontoHor = 0;
		int pontoVer = 0;
		int pontoAtual = 0;
		//List<double[]> listaPontos = new ArrayList<>();
		DecimalFormat df = new DecimalFormat("#.00");
		
		
		List<double[]> listaPontos = new ArrayList<>();
		for (double i = Math.min(pontoIni[0], pontoFin[0]); i <= Math.max(pontoIni[0], pontoFin[0]); i += variacao) {
			
			for (double z = Math.min(pontoIni[1], pontoFin[1]); z <= Math.max(pontoIni[1], pontoFin[1]); z += variacao) {
						
				//Monta uma lista gigante com todos os pontos
				//Depois desse loop monta quantas requisiçoes forem precisas, separando as linha pelo contador qtdPontoVer
				
				
				double[] ponto = {i,z};
				listaPontos.add(ponto);
				
				
				
				
//				JSONObject json = httpRequest.sendGetElevation(listaPontos);
//			
//				//Adiciona informações ao array
//				pontos[pontoVer][pontoHor] = new PontoMapa(jsonElevation.getElavacao(json), 
//						jsonElevation.getLat(json), jsonElevation.getLng(json));
//				
//				//Mostra progresso
//				System.out.println(df.format(((double)pontoAtual / qtdPontosGeral)*100) + "%");
//				System.out.println("Tempo decorrido: "+((System.currentTimeMillis() - KMS_gerador_alagamento.tempoInicial)*1000)+" segundos");

				pontoAtual++; //Usado apenas para % de processamento
				pontoHor++;
			}
			
			pontoHor = 0;
			pontoVer++;
		}
		
		int contPonto = 0;
		List<double[]> listaPontosReq = new ArrayList<>();
		List<PontoMapa> listaRespostaPontos = new ArrayList<>();
		for (int i = 0; i < listaPontos.size(); i++) {
			
			if ((contPonto < 511) && (contPonto+1 < listaPontos.size())) {
				//Lista recebe +1
				listaPontosReq.add(listaPontos.get(contPonto));
				contPonto++;
			} else {
				//Lista recebe +1
				listaPontosReq.add(listaPontos.get(contPonto));
				
				//Envia requisição
				JSONObject json = httpRequest.sendGetElevation(listaPontosReq);
				
				//Adiciona informações ao array
//				pontos[pontoVer][pontoHor] = new PontoMapa(jsonElevation.getElavacao(json), 
//						jsonElevation.getLat(json), jsonElevation.getLng(json));
				//Adiciona
				List<PontoMapa> retornoPontos = jsonElevation.getPontosMapa(json);
				
				//Adiciona retorno a lista principal de resposta
				for (int j = 0; j < retornoPontos.size(); j++) {
					listaRespostaPontos.add(retornoPontos.get(j));
				}
				//Leitor de Json devolve uma lista
				//Essa lista é adicionada a uma lista de PontoMapa
				
				listaPontosReq.removeAll(listaPontosReq);
				contPonto = 0;
			}
		}
		
		//Organiza lista pontoMapa em double [][] e retorna
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
		
		
		
	
		return pontos;
	}
}
