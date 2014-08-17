package SaidaDados;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

import MapasGoogle.PontoMapa;

/**
 * Utilitario de gravação de saida de dados.<br>
 * Utiliza parametros de Arrays bidimencionais de PontoMapa<br>
 * 
 * @author roberto
 * @version 1.0
 * @see PontoMapa.java
 */
public class GravacaoDados {

	/**
	 * Grava um arquivo de saida de dados .txt.<br>
	 * As informações sao gravadas em forma binária, onde 0 
	 * representa os pontos acima da elevação informada e 1 abaixo.<br>
	 * <p>
	 * <b>Formato:</b><br>
	 * 000000000111100000<br>
	 * 000000011111100000<br>
	 * 000000000011111000<br>
	 * </p>
	 * <p>
	 * <b>Exemplo:</p><br>
	 * <code>gravarTXT(pontosMapa, "\home\roberto\Documentos\arq.txt");</code>
	 * </p>
	 * @param pontos PontoMapa[][]
	 * @param elevacao valor dividor de pontos acima e abaixo do alagamento
	 * @param dirSaida Diretorio do arquivo a ser gerado
	 */
	public void gravarTXTbinario(PontoMapa[][] pontos, double elevacao, String dirSaida) {
		
		FileWriter fw;
		try {
			fw = new FileWriter(dirSaida);
			
			BufferedWriter bw = new BufferedWriter(fw);
			
	        for (int i = 0; i < pontos.length; i++) {
				for (int z = 0; z < pontos[i].length; z++) {
					if (pontos[i][z].getElevacao() < elevacao) {
						bw.write("1");
					} else {
						bw.write("0");
					}	
				}
				
				bw.newLine();
			}
	        
	        bw.close();
	        
		} catch (IOException e) {
			e.printStackTrace();
		}  
	}
	
	/**
	 * Grava um arquivo de saida de dados .txt<br>
	 * <p>
	 * <b>Formato:</b><br>
	 * elevaçao,latitude,longitude<br>
	 * elevaçao,latitude,longitude<br>
	 * </p>
	 * <p>
	 * <b>Exemplo:</p><br>
	 * <code>gravarTXT(pontosMapa, "\home\roberto\Documentos\arq.txt");</code>
	 * </p>
	 * @param pontos PontoMapa[][]
	 * @param dirSaida Diretorio do arquivo a ser gerado
	 */
	public void gravarTXT(PontoMapa[][] pontos, String dirSaida) {
		
		FileWriter fw = null;
		BufferedWriter bw = null;
		try {
			fw = new FileWriter(dirSaida);
			
			bw = new BufferedWriter(fw);
	        
			bw.write("Elevação;Latitude;Longitude");
			bw.newLine();
			
	        for (int i = 0; i < pontos.length; i++) {
				for (int z = 0; z < pontos[i].length; z++) {
					bw.write(pontos[i][z].getElevacao()+";"+pontos[i][z].getLat()+";"+pontos[i][z].getLng());
		        	bw.newLine();
				}
			}
	        
	        bw.close();
	        
		} catch (IOException e) {
			e.printStackTrace();
		}
		
	}	
	
}
