package GoogleMaps_API;

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

public class HTTP_request {

	private final String USER_AGENT = "Mozilla/5.0";
	private final String urlElevation = "http://maps.googleapis.com/maps/api/elevation/json";

	public JSONObject sendGetElevation(List<double[]> lista) {
 
		//Verifica tamnho maximo de localizações (512)
		if (lista.size() > 512) {
			System.err.println("O tamanho máximo de localizações por requesição é 512.");
			System.exit(0);
		}
		
		//Monta URL de requisição
		StringBuilder url = new StringBuilder();
		url.append(urlElevation + "?locations=");
		for (int i = 0; i < lista.size(); i++) {
			url.append(lista.get(i)[0] + "," + lista.get(i)[1]);
			if (i != lista.size() -1) {
				try {
					url.append(URLEncoder.encode("|", "UTF-8"));
				} catch (UnsupportedEncodingException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}
		}
		url.append("&sensor=false");
		HttpClient client = HttpClientBuilder.create().build();
		HttpGet request = new HttpGet(url.toString());
 
		request.addHeader("User-Agent", USER_AGENT);
 
		JSONObject json = null;
		try {
			HttpResponse response = client.execute(request);
			
			System.out.println("Mandando requisição GET para : \"" + url + "\"");
			System.out.println("Codigo de resposta : " + response.getStatusLine().getStatusCode());
	 
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
