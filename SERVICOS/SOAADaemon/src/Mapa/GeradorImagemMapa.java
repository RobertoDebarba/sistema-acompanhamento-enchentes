package Mapa;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.net.UnknownHostException;
import java.util.Iterator;
import java.util.List;

import javax.imageio.IIOImage;
import javax.imageio.ImageIO;
import javax.imageio.ImageWriteParam;
import javax.imageio.ImageWriter;
import javax.imageio.plugins.jpeg.JPEGImageWriteParam;
import javax.imageio.stream.ImageOutputStream;

import Arduino.Leitura;
import Propriedades.Propriedades;

import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.DBObject;
import com.mongodb.MongoClient;

/**
 * Gera imagem PNG para utilizar no Google Maps<br>
 * <br>
 * Baseado em: Edmon Begoli<br>
 * 
 * @author roberto.debarba
 * @version 1.0
 * @see http://it.toolbox.com/blogs/lim/how-to-generate-jpeg-images-from-java-41449  
 */
public class GeradorImagemMapa{
	
	private final String formatoImagem = "png";
	private final float opacidadeBloco = 0.3f; //Opacidade dos blocos visiveis
	
	Propriedades prop = new Propriedades();

	
	/**
	 * Gera imagem PNG tranparente com os pontos da collection do MongoDB<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>gerarImagemMongoDB(60)</code>
	 * </p>
	 * @param nivelRio nivel atual do rio
	 * 
	 * @author roberto
	 */
	public void gerarImagemMongoDB(Leitura leitura) throws UnknownHostException {
		
		int x, y = 0;

        //Tamanho dos blocos a serem preenchidos
        int tamBloco = 1;

        //Conecta ao MongoDB
        MongoClient mongoClient = 
        		new MongoClient(prop.getProp("mongoHost"), Integer.parseInt(prop.getProp("mongoPorta")));
		
		//Conecta ao banco selecionado 
        DB db = mongoClient.getDB(prop.getProp("mongoDB"));

        //Conecta à collection
		DBCollection coll = db.getCollection("pontosMapa");
		DBCollection collAlturaRio = db.getCollection("alturaRio");
		
		//Pega altura 0 do rio
		DBCursor cursor = collAlturaRio.find();
		double alturaRioZero = 0;
        while (cursor.hasNext()) { 
           DBObject doc = cursor.next();
           alturaRioZero = Double.parseDouble(doc.get("alturaRio")+"");
        }
		
		//Captura quantidade de pontos de latitude
		//Comando no MongoDB = db.pontosMapa.distinct('lat').length
		List<?> listaLat = coll.distinct("lat");
		int sizeLat = listaLat.size();
		
		//Captura quantidade de pontos de latitude
		//Comando no MongoDB = db.pontosMapa.distinct('lng').length
		List<?> listaLng = coll.distinct("lng");
		int sizeLng = listaLng.size();
		
		//Prepara tamanho do arquivo
        int X = sizeLng;
        int Y = sizeLat;
		
		double[] elevacoes = new double[X * Y];
		
		//Preenche um array com as elevações
		cursor = coll.find();
		int cont = 0;
        while (cursor.hasNext()) { 
           DBObject doc = cursor.next();
           elevacoes[cont] = Double.parseDouble(doc.get("elevacao")+"");
           
           cont++;
        }

        //Prepara imagem de saida
        BufferedImage image = new BufferedImage(tamBloco * X, tamBloco * Y, BufferedImage.TYPE_INT_ARGB);
        Graphics g = image.getGraphics();

        //Varre o array de elevacoes preenchendo o mapa
        cont = 0;
        for(int i =0; i < Y; i++){

            for(int j =0; j < X; j++){

                x = i * tamBloco;
                y = j * tamBloco;
                
                //Define cor do bloco
                if (elevacoes[cont] > (alturaRioZero + leitura.getNivelRio())) {
                	
                	g.setColor(new Color(0, 0, 0, 0));
                } else {
                	
                	g.setColor(new Color(0, 0, 1, opacidadeBloco));
                }

                //Pinta bloco
                g.fillRect(y, x, tamBloco, tamBloco);
                
                cont++;
            }
        }

        g.dispose();

        salvarImagem(image); 
	}
	
    /**
     * Salva BufferedImage no arquivo informado na prop<br>
     * <p>
	 * <b>Exemplo:></p><br>
	 * <code>salvarImagem(img)</code>
	 * </p>
     * 
     * @param img BufferedImage a ser salva
     * @author roberto
     */
    private void salvarImagem(BufferedImage img) {

    	ImageWriter writer = null;
        Iterator<ImageWriter> iter = ImageIO.getImageWritersByFormatName(formatoImagem);

        if( iter.hasNext() ){

            writer = (ImageWriter)iter.next();
        }

        ImageOutputStream ios;
		try {
			
			ios = ImageIO.createImageOutputStream(new File(prop.getProp("dirImg")));
			writer.setOutput(ios);

	        ImageWriteParam param = new JPEGImageWriteParam( java.util.Locale.getDefault() );
	        param.setCompressionMode(ImageWriteParam.MODE_EXPLICIT) ;
	        param.setCompressionQuality(1);

	        writer.write(null, new IIOImage( img, null, null ), param);
	        
		} catch (IOException e) {
			e.printStackTrace();
		}
    }
}
