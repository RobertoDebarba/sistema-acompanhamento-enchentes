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
		
//		double[] pontoIni = {-26.804,-49.279};
//		double[] pontoFin = {-26.810,-49.287};
		double[] pontoIni = {-26.80185606,-49.29616928};
		double[] pontoFin = {-26.856695,-49.243126};
//		double[] pontoFin = {-28.856695,-51.243126};
		
		PontoMapa[][] result = loop.getElevacaoPontosArea(pontoIni, pontoFin, 0.001);
		
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
