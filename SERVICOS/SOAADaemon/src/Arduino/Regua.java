package Arduino;

import java.io.IOException;
import java.net.Socket;
import java.net.UnknownHostException;

import Propriedades.Propriedades;

/**
 * Conecta à regua automatizada via Socket.<br>
 * 
 * @author roberto
 */
public class Regua {
	
	/**
	 * Efetua leitura dos valores da regua via conexão socket<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>efetuarLeitura()</code>
	 * </p>
	 * 
	 * @return Leitura com os valores
	 * @throws UnknownHostException
	 * @throws IOException
	 * 
	 * @author roberto
	 */
	public Leitura efetuarLeitura() throws UnknownHostException, IOException {
		
		Propriedades prop = new Propriedades();
		
		Socket socketRegua = new Socket(prop.getProp("reguaHost"), Integer.parseInt(prop.getProp("reguaPorta")));
		
		//TODO finalizar
		return null;
	}

}
