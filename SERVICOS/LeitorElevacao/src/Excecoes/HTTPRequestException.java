package Excecoes;

/**
 * Exceção de erro de requisição HTTP.<br>
 * 
 * @author roberto
 * @version 1.0
 */
public class HTTPRequestException extends RuntimeException {

	private static final long serialVersionUID = 1L;
	
	/**
	 * Dispara a exceção de requisição HTTP.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>throw new HTTPRequestException("URL muito longa.");</code>
	 * </p>
	 * 
	 * @param msg
	 */
	public HTTPRequestException(String msg) {
		super(msg);
	}

}
