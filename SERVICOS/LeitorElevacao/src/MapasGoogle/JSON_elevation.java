package MapasGoogle;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;


/**
 * Utilitario de manipulação de JSON Google Maps API.<br>
 * <p>
 * <b>Exemplo:></p><br>
 * <code>JSON_elevation ponto = new JSON_elevation();</code>
 * </p>
 * 
 * @author roberto
 * @version 1.0
 * @see http://www.devmedia.com.br/trabalhando-com-json-em-java-o-pacote-org-json/25480
 */
public class JSON_elevation {
	
	/**
	 * Imprime no console o json informado.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>printJSON(json);</code>
	 * </p>
	 * 
	 * @param json JSONObject
	 * @author roberto
	 */
	public void printJSON(JSONObject json) {
		
		System.out.println(json.toString());
	}
	
	/**
	 * Retorna um Array de double com as elevações do JSON informado.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>double[] elevacoes = getElevacao(json);</code>
	 * </p>
	 * 
	 * @param json JSONObject
	 * @return double[]
	 * @author roberto
	 */
	public double[] getElavacao(JSONObject json) {
		
		//Instancia Array de resultados
		JSONArray jsonResults =  json.getJSONArray("results");
		
		//Prepara Array de elevation para retorno
		double[] pontos = new double[jsonResults.length()];
		
		//Varre Array de resultados analisando cada localização retornada
		for (int i = 0; i < jsonResults.length(); i++) {
			
			//Instancia resultado da localição atual
			JSONObject jsonRes = new JSONObject(jsonResults.get(i).toString());
						
			//Adiciona à lista de retorno
			pontos[i] = jsonRes.getDouble("elevation");
		}
		
		return pontos;
	}
	
	/**
	 * Retorna um Array de double com as latitudes do JSON informado.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>double[] latitudes = getLat(json);</code>
	 * </p>
	 * 
	 * @param json JSONObject
	 * @return double[]
	 * @author roberto
	 */
	public double[] getLat(JSONObject json) {
		
		//Instancia Array de resultados
		JSONArray jsonResults =  json.getJSONArray("results");
		
		//Prepara Array de lat para retorno
		double[] pontos = new double[jsonResults.length()];
		
		//Varre Array de resultados analisando cada localização retornada
		for (int i = 0; i < jsonResults.length(); i++) {
			
			//Instancia resultado da localição atual
			JSONObject jsonRes = new JSONObject(jsonResults.get(i).toString());
			//Instancia resultado lat e lng atual
			JSONObject jsonLocation = jsonRes.getJSONObject("location");
						
			//Adiciona à lista de retorno
			pontos[i] = jsonLocation.getDouble("lat");
		}
		
		return pontos;
	}
	
	/**
	 * Retorna um Array de double com as longitudes do JSON informado.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>double[] longitudes = getLng(json);</code>
	 * </p>
	 * 
	 * @param json JSONObject
	 * @return double[]
	 * @author roberto
	 */
	public double[] getLng(JSONObject json) {
		
		//Instancia Array de resultados
		JSONArray jsonResults =  json.getJSONArray("results");
		
		//Prepara Array de lng para retorno
		double[] pontos = new double[jsonResults.length()];
		
		//Varre Array de resultados analisando cada localização retornada
		for (int i = 0; i < jsonResults.length(); i++) {
			
			//Instancia resultado da localição atual
			JSONObject jsonRes = new JSONObject(jsonResults.get(i).toString());
			//Instancia resultado lat e lng atual
			JSONObject jsonLocation = jsonRes.getJSONObject("location");
						
			//Adiciona à lista de retorno
			pontos[i] = jsonLocation.getDouble("lng");
		}
		
		return pontos;
	}
	
	/**
	 * Retorna uma List de PontoMapa com as informações do JSON.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>List<PontoMapa> = getPontosMapa(json);</code>
	 * </p>
	 * 
	 * @param json JSONObject
	 * @return List<PontoMapa>
	 * @author roberto
	 */
	public List<PontoMapa> getPontosMapa(JSONObject json) {
		
		//Prepara lista de pontos para retorno
		List<PontoMapa> listaPontos = new ArrayList<>();
		//Instancia Array de resultados
		JSONArray jsonResults =  json.getJSONArray("results");
		
		//Varre Array de resultados analisando cada localização retornada
		for (int i = 0; i < jsonResults.length(); i++) {
			
			//Instancia resultado da localição atual
			JSONObject jsonRes = new JSONObject(jsonResults.get(i).toString());
			//Instancia resultado lat e lng atual
			JSONObject jsonLocation = jsonRes.getJSONObject("location");
			
			//Carrega novo PontoMapa
			PontoMapa ponto = new PontoMapa(jsonRes.getDouble("elevation"),
					jsonLocation.getDouble("lat"), jsonLocation.getDouble("lng"));
			
			//Adiciona à lista de retorno
			listaPontos.add(ponto);
		}
		
		return listaPontos;
	}	
}
