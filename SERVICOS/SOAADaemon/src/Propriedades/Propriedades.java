package Propriedades;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Properties;

/**
 * Grava e resgata dados de arquivo de propriedades<br>
 * <b>Estrutura:</b><br>
 * <code>
 * reguaHost=
 * reguaPorta=
 * mongoHost=
 * mongoPorta=
 * mongoDB=
 * timerExec=
 * dirImg=
 * </code>
 * 
 * @version 1.0
 * @author roberto
 */
public class Propriedades {
	
	//Diretorio do arquivo de propriedades
	private final String arqProp = System.getProperty("user.home") + "/.SOAADaemon.cfg";
	
	
	/**
	 * Se arquivo de propriedades não existir, cria e grava prop vazias.
	 * 
	 * @author roberto
	 */
	public Propriedades() {
		
		Properties prop = new Properties();
		
		File file = new File(arqProp);
		if (!file.exists()) {
			
			System.out.println("Arquivo de propriedades não encontrado."+
					" Um novo arquivo será criado em " + arqProp);
			
			try {
				
				//Cria arquivo
				file.createNewFile();
				
				//Grava valores iniciais
				FileInputStream fileIS = new FileInputStream(file);
				prop.load(fileIS);
				
				prop.setProperty("reguaHost", "");
				prop.setProperty("reguaPorta", "");
				prop.setProperty("mongoHost", "");
				prop.setProperty("mongoPorta", "");
				prop.setProperty("mongoDB", "");
				prop.setProperty("timerExec", "miliseconds");
				prop.setProperty("dirImg", "");
				prop.setProperty("diffGerador", "cm");
				
				prop.store(new FileOutputStream(arqProp), null);
				
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
	}
	
	/**
	 * Grava propriedade em arquivo prop.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>setProp("prop", "valor")</code>
	 * </p>
	 * 
	 * @param propriedade Propriedade a ser setada
	 * @param valor Valor da propriedade
	 * 
	 * @author roberto
	 */
	public void setProp(String propriedade, String valor) {
		
		Properties prop = new Properties();
		
		File file = new File(arqProp);
		
		try {
			FileInputStream fileIS = new FileInputStream(file);
			
			prop.load(fileIS);
			
			prop.setProperty(propriedade, valor);
			prop.store(new FileOutputStream(arqProp), null);
			
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Retorna propriedade de arquivo prop.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>getProp("prop")</code>
	 * </p>
	 * 
	 * @param propriedade Propriedade a ser retornada
	 * @return Valor da propriedade
	 * 
	 * @author roberto
	 */
	public String getProp(String propriedade) {
	
		Properties prop = new Properties();
		String result = "";
		
		File file = new File(arqProp);
			
		try {
			FileInputStream fileIS = new FileInputStream(file);
			
			prop.load(fileIS);
			
			result = prop.getProperty(propriedade);
			
		} catch (IOException e) {
			e.printStackTrace();
		}

		return result;
	}
	
}
