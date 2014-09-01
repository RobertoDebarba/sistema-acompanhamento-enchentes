package SaidaDados;

import java.net.UnknownHostException;

import MapasGoogle.PontoMapa;

import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.MongoClient;
import com.mongodb.WriteResult;

/**
 * utilizado na gravação de pontos no banco de dados MongoDB<br>
 * 
 * @author roberto
 * @version 1.0
 * @see PontoMapa.java
 */
public class SaidaMongoDB {

	/**
	 * Insere um PontoMapa[][] no MongoDB<br>
	 * Os documentos gerados possui a estrutura {"elevacao": 10, "lat": 10, "lng": 10}<br>
	 * <p>
	 * <b>Exemplo:</p><br>
	 * <code>gravarMongoDB(pontos, true);</code>
	 * </p>
	 * @param pontos PontoMapa[][] com os pontos
	 * @param limparCollection limpar Collection antes de inserir os pontos
	 * 
	 * @see http://www.tutorialspoint.com/mongodb/mongodb_java.htm
	 * @see https://api.mongodb.org/java/2.12/
	 * 
	 * @author roberto
	 */
	public void gravarMongoDB(PontoMapa[][] pontos, boolean limparCollection) {
			
        MongoClient mongoClient;
		try {
			//Conecta ao MongoDB
			mongoClient = new MongoClient( "localhost" , 27017 ); //TODO prop
			
			//Conecta ao banco selecionado 
	        DB db = mongoClient.getDB("mydb"); //TODO prop

	        //Conecta à collection
			DBCollection coll = db.getCollection("pontosMapa"); //TODO prop
	        
			//Se informado, limpa collection antes de adicionar pontos
			if (limparCollection) {
				coll.remove(new BasicDBObject());
			}
			
			//Prepara array de documentos
			BasicDBObject[] listaDoc = new BasicDBObject[pontos.length * pontos[0].length];
			int contPontos = 0;
			for (int i = 0; i < pontos.length; i++) {
				for (int j = 0; j < pontos[i].length; j++) {
					
					listaDoc[contPontos] = new BasicDBObject("elevacao", pontos[i][j].getElevacao()).
							append("lat", pontos[i][j].getLat()).
							append("lng", pontos[i][j].getLng());
							
					contPontos++;
				}
			}
			
			//Insere array de documentos
	        WriteResult result = coll.insert(listaDoc);
	        
	        if (result.getField("ok").toString().equals("1.0")) {
	        	System.out.println("Ponto gravado com sucesso!");
	        }
	        
		} catch (UnknownHostException e) {
			System.err.println("Falha ao conectar ao banco de dados!");
			e.printStackTrace();
		}    
	}
}
