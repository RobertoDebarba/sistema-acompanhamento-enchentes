package GoogleMaps_API;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import AnaliseArea.PontoMapa;


/*
 * http://www.devmedia.com.br/trabalhando-com-json-em-java-o-pacote-org-json/25480
 */
public class JSON_elevation {
	
	public void printJSON(JSONObject json) {
		
		System.out.println(json.toString());
	}
	
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
