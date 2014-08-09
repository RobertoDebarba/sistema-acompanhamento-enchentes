package AnaliseArea;

public class PontoMapa {

	private double elevacao;
	private double lat;
	private double lng;
	
	public PontoMapa(double elevacao, double lat, double lng) {
		
		this.elevacao =  elevacao;
		this.lat = lat;
		this.lng = lng;
	}
	
	public double getElevacao() {
		
		return this.elevacao;
	}
	
	public double getLat() {
		
		return this.lat;
	}
	
	public double getLng() {
	
	return this.lng;
	}
}
