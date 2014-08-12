package Excecoes;

/**
 * Exceção de erro da API Google Maps Elevation.<br>
 * 
 * @author roberto
 * @version 1.0
 */
public class ElevationAPIException extends RuntimeException {

	private static final long serialVersionUID = 1L;
	
	/**
	 * Dispara a exceção de API Google Maps Elevation.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>throw new ElevationAPIException("Numero de pontos maior que o suportado");</code>
	 * </p>
	 * 
	 * @param msg
	 */
	public ElevationAPIException(String msg) {
		super(msg);
	}

}
