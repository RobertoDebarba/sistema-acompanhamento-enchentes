package SaidaDados;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

import AnaliseArea.PontoMapa;

public class ArquivoTexto {

	public void gravarTXTbinario(PontoMapa[][] pontos, float elevacao) {
		
		FileWriter fw;
		try {
			fw = new FileWriter("ResultadoBinario.txt");
			
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
	
	public void gravarTXT(PontoMapa[][] pontos) {
		
		FileWriter fw;
		try {
			fw = new FileWriter("Resultado.txt");
			
			BufferedWriter bw = new BufferedWriter(fw);
	        
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
