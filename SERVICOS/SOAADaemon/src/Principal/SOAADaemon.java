package Principal;

import java.net.UnknownHostException;

public class SOAADaemon {

	public static void main(String[] args) throws UnknownHostException {
		
		TimerExecucao execucao = new TimerExecucao();
		
		System.out.println("Iniciada execução de tarefas.");
		execucao.executar();
	}

}
