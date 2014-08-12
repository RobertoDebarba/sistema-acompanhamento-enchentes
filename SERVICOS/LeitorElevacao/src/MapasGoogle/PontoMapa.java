package MapasGoogle;

/**
 * Ponto do mapa contendo Elevação, Latitude e Longitude.<br>
 * <p>
 * <b>Exemplo:></p><br>
 * <code>PontoMapa ponto = new PontoMapa(10, 11, 12);</code>
 * </p>
 * 
 * @author roberto
 * @version 1.0
 * @see LeitorMapa.java
 */
public class PontoMapa {

	private double elevacao;
	private double lat;
	private double lng;
	
	/**
	 * Cria novo ponto mapa.
	 * @param elevacao Elevação
	 * @param lat Latitude
	 * @param lng Longitude
	 */
	public PontoMapa(double elevacao, double lat, double lng) {
		
		this.elevacao =  elevacao;
		this.lat = lat;
		this.lng = lng;
	}
	
	/**
	 * Retorna Elevação
	 * @return
	 */
	public double getElevacao() {
		
		return this.elevacao;
	}
	
	/**
	 * Retorna Latitude
	 * @return
	 */
	public double getLat() {
		
		return this.lat;
	}
	
	/**
	 * Retorna Longitude
	 * @return
	 */
	public double getLng() {
	
		return this.lng;
	}
}
