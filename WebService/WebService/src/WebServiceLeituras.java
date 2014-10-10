import java.net.UnknownHostException;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
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
	 * Método que retorna uma String no formato JSON, com as leituras retiradas
	 * do Banco de Dados;</br>
	 * <p>
	 * <p>
	 * <br>
	 * Exemplo: </br>
	 * </p>
	 * <code> getDados exemplo = new getDados(int quantidade de leituras) </code>
	 * </p>
	 *
	 * @param quantidadeLeituras
	 *            quantidade de leituras que serão retornadas;
	 * @return arquivo JSON
	 *
	 * @author luan
	 */

	public String leituras(int quantidadeRegistros, String dataHora) {

		if (quantidadeRegistros > 15) {
			
			return "{“erro”: true, “descricao”: “numero max de leituras = 15”}";
			
		} else {
			// json que será retornado pelo metodo
			JSONObject jsonFinal = new JSONObject();

			// array para concatenar os valores dos níveis altura do rio
			JSONArray arrayRio = new JSONArray();

			// array para concatenar os valores dos niveis de chuva
			JSONArray arrayChuva = new JSONArray();

			// array para concatenar as datas e horas das leituras
			JSONArray arrayDataHora = new JSONArray();

			// ----------------------------------------------------
			// Métodos para setar o formato da data (ISO 8601)
			DateFormat dateFormater = new SimpleDateFormat(
					"yyyy-MM-dd'T'HH:mm:ss.SSS'Z'");
			dateFormater.setTimeZone(TimeZone.getTimeZone("UTC"));
			// ----------------------------------------------------
			try {
				// Conexão com o MongoDB
				mongoClient = new MongoClient("localhost", 27017);
				// ----------------------------------------------------
				// Seta a base e collections para a busca
				DB database = mongoClient.getDB("mydb");
				DBCollection collection = database.getCollection("leituras");
				// ----------------------------------------------------

				Date data = dateFormater.parse(dataHora);
				BasicDBObject range = new BasicDBObject("dataHora",
						new BasicDBObject("$lte", data));

				// ----------------------------------------------------
				// Seta a ordenação da busca, em ordem de data decrescente
				DBObject ordem = new BasicDBObject();
				ordem.put("dataHora", -1);
				// ----------------------------------------------------

				// Busca no banco de dados
				DBCursor cursor = collection.find(range).sort(ordem).limit(quantidadeRegistros);
				
				
				if(!cursor.hasNext()){
					return "{“erro”: true, “descricao”: “nenhum registro encontrado”}";
				
				} else {
					try {

						// Enquanto existir registros a seguir no cursor
						while (cursor.hasNext()) {

							// Passa para o proximo registro
							DBObject tempObj = cursor.next();
							// Se o valor do nivel do rio e o valor do nivel da
							// chuva
							// forem
							// diferentes de null
							if ((!tempObj.get("nivelRio").equals("null"))
									|| (!tempObj.get("nivelChuva").equals("null"))) {

								// Adiciona os valores das leituras para os arrays
								// setados
								arrayRio.put(tempObj.get("nivelRio"));
								arrayChuva.put(tempObj.get("nivelChuva"));
								arrayDataHora.put(dateFormater.format(tempObj
										.get("dataHora")));

							}
						}

						// ----------------------------------------------------
						// Passa para o JSON final os valores das leituras
						jsonFinal.put("dataHora", arrayDataHora);
						jsonFinal.put("nivelChuva", arrayChuva);
						jsonFinal.put("nivelRio", arrayRio);

						// ----------------------------------------------------
						
					} catch (JSONException e) {
						e.printStackTrace();
					} finally {
						cursor.close();
					}
				}


			} catch (UnknownHostException e) {

				e.printStackTrace();
			} catch (ParseException e1) {
				e1.printStackTrace();
			}
			
			// Retorna o JSON final
			return jsonFinal.toString();
		}
	}
}
