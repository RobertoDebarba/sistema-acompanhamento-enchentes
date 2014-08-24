package Propriedades;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Properties;

public class Propriedades {
	
	private final String arqProp = "";
	
	/**
	 * 
	 * @param propriedade
	 * @param valor
	 * @throws IOException
	 */
	public void setProp(String propriedade, String valor) throws IOException {
		
		Properties prop = new Properties();
		
		File file = new File(arqProp);
		if (file.exists()) {
			
			FileInputStream fileIS = new FileInputStream(file);
			prop.load(fileIS);
		}
		
		prop.setProperty(propriedade, valor);
		prop.store(new FileOutputStream(arqProp), null);
	}
	
	/**
	 * 
	 * @param propriedade
	 * @return
	 * @throws IOException
	 */
	public String getProp(String propriedade) throws IOException {
	
		Properties prop = new Properties();
		String result = "";
		
		File file = new File(arqProp);
		if (file.exists()) {
			
			FileInputStream fileIS = new FileInputStream(arqProp);
			prop.load(fileIS);
		}
		
		result = prop.getProperty(propriedade); //TODO testar com prop nao existente
		
		return result;
	}
}
