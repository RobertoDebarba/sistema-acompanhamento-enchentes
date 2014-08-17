package MapasGoogle;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.HttpClientBuilder;
import org.json.JSONObject;

import Excecoes.HTTPRequestException;

/**
 * Requisição HTTP para GoogleMaps Elevation API.<br>
 * 
 * @author roberto
 * @version 1.0
 */
public class HTTP_request {

	private final String USER_AGENT = "Mozilla/5.0";
	private final String urlElevation = "http://maps.googleapis.com/maps/api/elevation/json";

	/**
	 * Envia requisição GET para Google Maps Evelation API.<br>
	 * <p><b>Atenção:</b><br>
	 * Máximo caracteres por requisição: 2048;<br>
	 * Máximo pontos por requisição: 512;<br>
	 * Máximo requisições por dia: 2.500;<br>
	 * </p>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>JSONObject json = sendGetElevation(listaPontos);</code>
	 * </p>
	 * 
	 * @param lista Lista de pontos para requisição
	 * @return JSONObject
	 * @throws HTTPRequestException
	 * @author roberto
	 */
	public JSONObject sendGetElevation(List<double[]> lista) throws HTTPRequestException {
		
		//Verifica numero maximo de localizações (512)
		if (lista.size() > 512) {
			throw new HTTPRequestException("O número máximo de localizações por requesição não deve ser mais que 512.");
		}
		
		/*
		 * Monta URL da requisição.
		 * Formato:
		 * http://maps.googleapis.com/maps/api/elevation/json?locations=<lat>,<lng>|<lat>,<lng>&sensor=false
		 */
		StringBuilder url = new StringBuilder();
		url.append(urlElevation + "?locations=");
		for (int i = 0; i < lista.size(); i++) {
			url.append(lista.get(i)[0] + "," + lista.get(i)[1]);
			if (i != lista.size() -1) {
				try {
					//Utliza URL encoder por problema de reconhecimento do Google Maps
					//Necessario apenas para |
					url.append(URLEncoder.encode("|", "UTF-8"));
				} catch (UnsupportedEncodingException e) {
					e.printStackTrace();
				}
			}
		}
		url.append("&sensor=false");
		
		//Verifica o tamanho máximo da URL (2048)
		if (url.length() > 2048) {
			throw new HTTPRequestException("O tamanho máximo da URL não deve ser maior que 2048 caracteres.");
		}
		
		//Cria cliente e requisição
		HttpClient client = HttpClientBuilder.create().build();
		HttpGet request = new HttpGet(url.toString());
 
		request.addHeader("User-Agent", USER_AGENT);
 

		JSONObject json = null;
		try {
			
			System.out.println("Mandando requisição GET para : \"" + url + "\"");
			System.out.println("Quantidade de ponto na requisição: "+lista.size());
			System.out.println("Quantidade de caracteres na requisição: "+url.length());
			
			//Envia requisição
			HttpResponse response = client.execute(request);
			
			System.out.println("Codigo de resposta : " + response.getStatusLine().getStatusCode());
			if (response.getStatusLine().getStatusCode() != 200) {
				throw new HTTPRequestException("Códido de resposta diferente de 200");
			}
	 
			//Monta JSON com a resposta
			BufferedReader rd = new BufferedReader(
	                       new InputStreamReader(response.getEntity().getContent()));
	 
			StringBuilder result = new StringBuilder();
			String line = "";
			while ((line = rd.readLine()) != null) {
				result.append(line);
			}
			
			json = new JSONObject(result.toString());
			
		} catch (IOException e) {
			e.printStackTrace();
		}
		
		return json;
	}
}
