package Mongo;

import java.net.UnknownHostException;

import Arduino.Leitura;
import Propriedades.Propriedades;

import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.MongoClient;
import com.mongodb.WriteResult;

/**
 * Realiza operações com a collection "leituras" do MongoDB<br>
 * 
 * @version 1.0
 * @author roberto
 */
public class MongoLeitura {
	
	Propriedades prop = new Propriedades();
	
	/**
	 * Grava nova leitura no banco.<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>setNovaLeitura(leitura)</code>
	 * </p>
	 * 
	 * @param leitura Leitura à gravar
	 * 
	 * @author roberto
	 */
	public void setNovaLeitura(Leitura leitura) throws UnknownHostException {

		// Conecta ao banco de dados
		MongoClient mongoClient = 
				new MongoClient(prop.getProp("mongoHost"), Integer.parseInt(prop.getProp("mongoPorta")));
																		
		DB db = mongoClient.getDB(prop.getProp("mongoDB"));
		DBCollection coll = db.getCollection("leituras");
		
		//Cria objeto para gravação
		BasicDBObject obj = new BasicDBObject("dataHora", leitura.getDataHora()).
				append("nivelRio", leitura.getNivelRio()).
				append("nivelChuva", leitura.getNivelChuva());
		
		//Grava objeto
		WriteResult wResult = coll.insert(obj);
		
		//Veridica resultado da gravação
		if (wResult.getField("ok").toString().equals("1.0")) {
			System.out.println("Nova leitura gravada com sucesso!");
		} else {
			throw new RuntimeException(
					"Erro ao gravar nova leitura no banco de dados.");
		}
	}

//	public Leitura getUltimaLeitura() throws UnknownHostException {
//
//		// db.leituras.find().sort({dataHora:-1}).limit(1)
//
//		// Conecta ao banco de dados
//		MongoClient mongoClient = new MongoClient("localhost", 27017);
//																		
//		DB db = mongoClient.getDB("mydb");
//		DBCollection coll = db.getCollection("leituras");
//
//		
//		BasicDBObject querySort = new BasicDBObject("ISODate(dataHora)", -1);
//		DBCursor cursor = coll.find().sort(querySort).limit(1);
//
//		
//		Leitura leitura = new Leitura();
//		DBObject doc = cursor.next();
//		leitura.setDataHora((Date) doc.get("dataHora"));
//		leitura.setNivelRio((double) doc.get("nivelRio"));
//		leitura.setNivelChuva((int) doc.get("nivelChuva"));
//		

////		Calendar calendar = Calendar.getInstance();
////		calendar.setTime(data);
////		System.out.println(calendar.getTime());
//		

//		return leitura;
//	}

}
