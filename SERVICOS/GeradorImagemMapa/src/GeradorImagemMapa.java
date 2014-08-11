import java.awt.Color;
import java.awt.Graphics;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Scanner;

import javax.imageio.IIOImage;
import javax.imageio.ImageIO;
import javax.imageio.ImageWriteParam;
import javax.imageio.ImageWriter;
import javax.imageio.plugins.jpeg.JPEGImageWriteParam;
import javax.imageio.stream.ImageOutputStream;

/**
 * Gera imagem PNG com base em informações binarias de arquivo TXT<br>
 * <br>
 * Baseado em: Edmon Begoli<br>
 * 
 * @author roberto.debarba
 * @version 1.1
 * @see http://it.toolbox.com/blogs/lim/how-to-generate-jpeg-images-from-java-41449  
 */
public class GeradorImagemMapa{
	
	private final String formatoImagem = "png";
	private final float opacidadeBloco = 0.3f; //Opacidade dos blocos visiveis

	/**
	 * Gera imagem PNG tranparente com os pontos informados no arquivo fonte<br>
	 * <p>
	 * <b>Exemplo:></p><br>
	 * <code>gerarImagem(base-teste.txt, imagem-teste.png)</code>
	 * </p>
	 * 
	 * @param dirArqFonte diretorio e nome do arquivo de base
	 * @param dirImgSaida diretorio e nome do arquivo imagem de saida
	 * @author roberto
	 */
    public void gerarImagem(String dirArqFonte, String dirImgSaida) {  	

        int x, y = 0;

        //Tamanho dos blocos a serem preenchidos
        int tamBloco = 1;

        //Carrega arquivo fonte
        List<String> listaArq =  getArquivoBase(dirArqFonte);

        //Le tamanho do arquivo
        int Y = listaArq.size();
        int X = listaArq.get(0).length();

        //Prepara imagem de saida
        BufferedImage image = new BufferedImage(tamBloco * X, tamBloco * Y, BufferedImage.TYPE_INT_ARGB);
        Graphics g = image.getGraphics();

        //Varre arquivo fonte preenchendo imagem
        for(int i =0; i < Y; i++){

            for(int j =0; j < X; j++){

                x = i * tamBloco;
                y = j * tamBloco;
                
                //Define cor do bloco
                if (listaArq.get(i).charAt(j) == '0') {
                	
                	g.setColor(new Color(0, 0, 0, 0));
                } else {
                	
                	g.setColor(new Color(0, 0, 1, opacidadeBloco));
                }

                //Pinta bloco
                g.fillRect(y, x, tamBloco, tamBloco);
            }
        }

        g.dispose();

        salvarImagem(image, dirImgSaida); 
    }

    /**
     * Salva BufferedImage no arquivo informado<br>
     * <p>
	 * <b>Exemplo:></p><br>
	 * <code>salvarImagem(img, imagem-teste.png)</code>
	 * </p>
     * 
     * @param img BufferedImage a ser salva
     * @param diretorio Caminho e nome do arquivo a ser salvo
     * @author roberto
     */
    private void salvarImagem(BufferedImage img, String diretorio) {

    	ImageWriter writer = null;
        Iterator<ImageWriter> iter = ImageIO.getImageWritersByFormatName(formatoImagem);

        if( iter.hasNext() ){

            writer = (ImageWriter)iter.next();
        }

        ImageOutputStream ios;
		try {
			
			ios = ImageIO.createImageOutputStream(new File(diretorio));
			writer.setOutput(ios);

	        ImageWriteParam param = new JPEGImageWriteParam( java.util.Locale.getDefault() );
	        param.setCompressionMode(ImageWriteParam.MODE_EXPLICIT) ;
	        param.setCompressionQuality(1);

	        writer.write(null, new IIOImage( img, null, null ), param);
	        
		} catch (IOException e) {
			e.printStackTrace();
		}
    }

    /**
     * Retorna Lista<String> contendo o arquivo de texto informado<br>
     * <p>
	 * <b>Exemplo:></p><br>
	 * <code>List<String> listaArquivo = getArquivoBase(base-teste.txt)</code>
	 * </p>
     * 
     * @param diretorio e nome do arquivo
     * @return List<String> contendo o arquivo
     * @author roberto
     */
    private List<String> getArquivoBase(String diretorio) {
    	
    	List<String> listaArquivo = new ArrayList<>();
    	try {
        	Scanner s = new Scanner(new File(diretorio));
        	while (s.hasNext()){
        	    listaArquivo.add(s.nextLine());
        	}
        	s.close();
            
        } catch (IOException e) {
            e.printStackTrace();
        }
    	
    	return listaArquivo;
    }
    
    
    public static void main( String args[] ) throws Exception {

    	GeradorImagemMapa jpgCreator = new GeradorImagemMapa();
       	jpgCreator.gerarImagem("base-teste.txt", "imagem-teste.png");
       	System.out.println("Operação completa!");
    } 
}
