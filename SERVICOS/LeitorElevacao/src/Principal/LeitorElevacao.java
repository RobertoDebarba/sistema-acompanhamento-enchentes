package Principal;

import SaidaDados.ArquivoTexto;
import AnaliseArea.Loop_area;
import AnaliseArea.PontoMapa;

/*
 * 2.500 solicitações
 * 512 locais por solicitação
 * 25.000 locais no total
 * Ex: locations=39.7391536,-104.9847034|36.455556,-116.866667
 * 
 * https://developers.google.com/maps/documentation/elevation/?hl=pt-BR
 */
public class LeitorElevacao {
	
	//Timer
	public static long tempoInicial = System.currentTimeMillis();

	public static void main(String[] args) {
		
		Loop_area loop = new Loop_area();
		
//		double[] pontoIni = {-26.804,-49.279};
//		double[] pontoFin = {-26.810,-49.287};
		double[] pontoIni = {-26.80185606,-49.29616928};
		double[] pontoFin = {-26.856695,-49.243126};
//		double[] pontoFin = {-28.856695,-51.243126};
		
		PontoMapa[][] result = loop.varrerArea(pontoIni, pontoFin);
		
		for (int i = 0; i < result.length; i++) {
			for (int z = 0; z < result[i].length; z++) {
				System.out.println(result[i][z].getElevacao());
			}
		}
		
		System.out.println("Gravado dados em arquivo...");
		ArquivoTexto arqTxt = new ArquivoTexto();
		
		arqTxt.gravarTXT(result);
		System.out.println("Informações gravadas com sucesso!");
		
		arqTxt.gravarTXTbinario(result, 70);
		System.out.println("Arquivo binario gravado com sucesso!");

		System.out.println(((System.currentTimeMillis() - tempoInicial) < 1000) 
				? ((System.currentTimeMillis() - tempoInicial) + "milisegundos") 
						: (((System.currentTimeMillis() - tempoInicial)/1000)+" segundos"));
	}

}
