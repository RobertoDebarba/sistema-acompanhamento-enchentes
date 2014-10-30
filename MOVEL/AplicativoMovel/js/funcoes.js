function Alterar_div(){
   	$('#resposta').load("./php/webServiceAcesso.php", {'texto': $('#entrada').val()});
};

function Alterar_div_json(){
	$.getJSON("./php/webServiceAcesso.php",{'texto=': $('#entrada').val()}, function(info){
	    	var valor = info.result;
	    	if(valor != null){
	    		$('#resposta').html(valor);
	    	}
	    	else{
	    		alert("tete");
	    	}
	   });
}