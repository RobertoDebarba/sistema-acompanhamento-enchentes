package Principal;

import MapasGoogle.LeitorMapa;
import MapasGoogle.PontoMapa;
import SaidaDados.GravacaoDados;


/*
 * Limites:
 * 2.500 solicitações
 * 512 locais por solicitação
 * 25.000 locais no total
 * 2048 caracteres por URL
 * 
 * https://developers.google.com/maps/documentation/elevation/?hl=pt-BR
 */
public class LeitorElevacao {
	
	/*
	 * Realiza uma oparação exemplo.
	 */
	public static void main(String[] args) {
		
		LeitorMapa loop = new LeitorMapa();
		
		//Teste
//		double[] pontoSW = {-26.810,-49.287};
//		double[] pontoNO = {-26.804,-49.279};
		//Timbó
		double[] pontoSW = {-26.8739997,-49.30561066};
		double[] pontoNO = {-26.78959779,-49.23316956};
		
		PontoMapa[][] result = loop.getElevacaoPontosArea(pontoSW, pontoNO, 0.001);
		
		//Grava dados
		GravacaoDados arqTxt = new GravacaoDados();
		
		System.out.println("Gravado pontos em arquivo TXT...");
		arqTxt.gravarTXT(result, "Resultado.txt");
		System.out.println("Informações gravadas com sucesso!");
		
		System.out.println("Gravado dados binarios em arquivo TXT...");
		arqTxt.gravarTXTbinario(result, 70, "ResultadoBinario.txt");
		System.out.println("Informações gravadas com sucesso!");
	}
}
