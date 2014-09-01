package Arduino;

import java.util.Date;

/**
 * Classe de transporte de dados de leituras.<br>
 * 
 * @author roberto
 */
public class Leitura {
	
	private Date dataHora;
	private double nivelRio;
	private int nivelChuva;
	
	/**
	 * Retorna DataHora da leitura.<br>
	 * 
	 * @return dataHora
	 * 
	 * @author roberto
	 */
	public Date getDataHora() {
		return dataHora;
	}
	
	/**
	 * Seta DataHora da leitura.<br>
	 * 
	 * @param dataHora
	 * 
	 * @author roberto
	 */
	public void setDataHora(Date dataHora) {
		this.dataHora = dataHora;
	}
	
	/**
	 * Retorna NivelRio da leitura.<br>
	 * 
	 * @return nivelRio
	 * 
	 * @author roberto
	 */
	public double getNivelRio() {
		return nivelRio;
	}
	
	/**
	 * Seta NivelRio da leitura.<br>
	 * 
	 * @param nivelRio
	 * 
	 * @author roberto
	 */
	public void setNivelRio(double nivelRio) {
		this.nivelRio = nivelRio;
	}
	
	/**
	 * Retorna NivelChuva da leitura.<br>
	 * 
	 * @return nivelChuva
	 * 
	 * @author roberto
	 */
	public int getNivelChuva() {
		return nivelChuva;
	}
	
	/**
	 * Seta NivelChuva da leitura.<br>
	 * 
	 * @param nivelChuva
	 * 
	 * @author roberto
	 */
	public void setNivelChuva(int nivelChuva) {
		this.nivelChuva = nivelChuva;
	}

}
