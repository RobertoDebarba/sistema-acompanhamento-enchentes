import java.net.UnknownHostException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.TimeZone;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.DBObject;
import com.mongodb.MongoClient;


public class WebServiceLeituras {

	static MongoClient mongoClient;
	
	/**
	* Método que retorna uma String no formato JSON, com as leituras retiradas do Banco de Dados;</br>
	* <p>
	* <p><br>Exemplo: </br></p>
	* <code> getDados exemplo = new getDados(int quantidade de leituras) </code>
	*</p>
	*
	*@param quantidadeLeituras quantidade de leituras que serão retornadas;
	*@return arquivo JSON
	*
	*@author luan
	*/
	
	public String getDados (int quantidadeLeituras) {
		//json que será retornado pelo metodo
		JSONObject jsonFinal = new JSONObject();
		
		//array para concatenar os valores dos níveis altura do rio
		JSONArray arrayRio = new JSONArray();
		
		//array para concatenar os valores dos niveis de chuva
		JSONArray arrayChuva = new JSONArray();
		
		//array para concatenar as datas e horas das leituras
		JSONArray arrayDataHora = new JSONArray();
		
		//----------------------------------------------------
		//Métodos para setar o formato da data (ISO 8601)
		TimeZone tz = TimeZone.getTimeZone("UTC");
		DateFormat df = new SimpleDateFormat(
				"yyyy-MM-dd'T'HH:mm:ss.SSS'Z'");
		df.setTimeZone(tz);
		//----------------------------------------------------
		try {
			//Conexão com o MongoDB
			mongoClient = new MongoClient("localhost", 27017);
			//----------------------------------------------------
			//Seta a base e collections para a busca
			DB db = mongoClient.getDB("mydb");
			DBCollection coll = db.getCollection("leituras");
			//----------------------------------------------------
			
			//----------------------------------------------------
			//Seta a ordenação da busca, em ordem de data decrescente
			DBObject obj = new BasicDBObject();
			obj.put("dataHora", -1);
			//----------------------------------------------------
			
			//Busca no banco de dados
			DBCursor cursor = coll.find().sort(obj).limit(quantidadeLeituras);

			try {
				
				//Enquanto existir registros a seguir no cursor
				while (cursor.hasNext()) {
					
					//Passa para o proximo registro
					DBObject tempObj = cursor.next();
					
					//Se o valor do nivel do rio e o valor do nivel da chuva forem
					//diferentes de null
					if ((!tempObj.get("nivelRio").equals("null"))
							|| (!tempObj.get("nivelChuva").equals("null"))) {
						
						//Adiciona os valores das leituras para os arrays setados
						arrayRio.put(tempObj.get("nivelRio"));
						arrayChuva.put(tempObj.get("nivelChuva"));
						arrayDataHora.put(df.format(tempObj.get("dataHora")));
					}
				}
				
				//----------------------------------------------------
				//Passa para o JSON final os valores das leituras
				jsonFinal.put("dataHora", arrayDataHora);
				jsonFinal.put("nivelChuva", arrayChuva);
				jsonFinal.put("nivelRio", arrayRio);
				//----------------------------------------------------
			} catch (JSONException e) {
			
				e.printStackTrace();
			} finally {
				cursor.close();
			}

		} catch (UnknownHostException e) {

			e.printStackTrace();
		}
		
		//Retorna o JSON final
		return jsonFinal.toString();
	}

}
