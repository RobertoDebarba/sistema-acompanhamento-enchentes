package Principal;

import java.io.IOException;
import java.util.Timer;
import java.util.TimerTask;

import Arduino.Leitura;
import Arduino.Regua;
import Mapa.GeradorImagemMapa;
import Mongo.MongoLeitura;
import Propriedades.Propriedades;

/**
 * Execução de operação sequencial<br>
 * 
 * @version 1.0
 * @author roberto
 */
public class TimerExecucao {

	/**
	 * Executa leitura, gravação no banco e geração de imagem sequencialmente.<br>
	 * A imagem será gerada apenas se a diferença foi maior que a estipulada no arq de prop.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>executar()</code>
	 * </p>
	 * 
	 * @author roberto
	 */
	public void executar() {
		
		Propriedades prop = new Propriedades();
		
		//Intervalo de execução
		int intervalo = Integer.parseInt(prop.getProp("timerExec"));

		Regua regua = new Regua();
		MongoLeitura mongoLeitura = new MongoLeitura();
		GeradorImagemMapa geradorImagem = new GeradorImagemMapa();
		
		Timer timer = new Timer();

		timer.scheduleAtFixedRate(new TimerTask() {
			
			double nivelRioAnterior = 0;
			
			public void run() {
				
				try {
					//Efetua leitura
					System.out.println("Efetuando leitura...");
					Leitura leitura = regua.efetuarLeitura();
					
					//Grava valores no banco
					System.out.println("Gravando leitura no banco...");
					mongoLeitura.setNovaLeitura(leitura);
					
					//Verifica diferença entre leitura atual e anterior
					double diff = leitura.getNivelRio() - nivelRioAnterior;
					//Se a diferença for negativa multipica por -1
					diff = (diff < 0) ? (diff * -1) : diff;
					
					//Se a diferença for maior que o estipulado, gera imagem
					if (diff >= Double.parseDouble(prop.getProp("diffGerador"))) {
						
						System.out.println("Gerando imagem de inundação...");
						geradorImagem.gerarImagemMongoDB(leitura);
					}
					
					nivelRioAnterior = leitura.getNivelRio();

				} catch (IOException e) {
					System.err.println("Erro em execução do Timer!");
					e.printStackTrace();
				}
				
			}
		}, 100, intervalo);

	}

}
