package Arduino;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.Date;

import org.json.JSONObject;

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
	 * <b>Exemplo:></b><br>
	 * <code>efetuarLeitura()</code>
	 * </p>
	 * 
	 * @return Leitura com os valores
	 * @throws UnknownHostException
	 * @throws IOException
	 * 
	 * @author roberto
	 */	
	public Leitura efetuarLeitura() throws IOException {
		
		Propriedades prop = new Propriedades();
		
		Socket socketRegua = null;
		Leitura leitura = null;
		try {
			socketRegua = new Socket(prop.getProp("reguaHost"), Integer.parseInt(prop.getProp("reguaPorta")));
			
			BufferedReader in;
			DataOutputStream out;
			
			//Envia dados para iniciar leitura
			out = new DataOutputStream(socketRegua.getOutputStream());
			out.writeBytes(".");
			
			//Recebe leitura
			in = new BufferedReader(new InputStreamReader(socketRegua.getInputStream()));
			String sLeitura = in.readLine();
			
			JSONObject jsonLeitura = new JSONObject(sLeitura);
			
			leitura = new Leitura();
			leitura.setDataHora(new Date());
			leitura.setNivelChuva(jsonLeitura.getInt("nivelChuva"));
			leitura.setNivelRio(jsonLeitura.getDouble("nivelRio"));
			
		} finally {
			socketRegua.close();
		}
		
		return leitura;
	}

}
