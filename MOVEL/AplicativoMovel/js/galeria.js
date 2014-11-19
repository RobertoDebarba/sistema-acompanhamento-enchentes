function carregarImagensGaleria(links) {
    var cont; //contador
    for (cont in links) {
        var itemgaleria = links[cont];
        $("#exibirImagens").append(
            "<li><img class='img-responsive' src='http://54.232.207.63/Comum/galeria/thumbs/"+ itemgaleria + "'></li>");
    }
}

/**
 * obtem as imagems da galeria
 * */
function getImagensGaleria() {
    $.ajax({
        url : "http://54.232.207.63/Comum/php/funcoes.php/?getImagensGaleria=?",
        dataType : 'jsonp',
        crossDomain : true,

        success : function (data) {
            carregarImagensGaleria(data);
        }
    });
}

//Array com informações da imagem
var infoImagem;

$(document).ready(function() {
	$('li img').on('click', function() {
		var src = $(this).attr('src');
		//Altera URL da imagem de thumbs para imagens
		try {
			src = src.replace("thumbs", "imagens");
		} catch(err) {
			//Este catch corrige problema ao passar muitas vezes por essa linha
		}
		
		//Busca informações da imagem no banco
		nomeImagem = src.substring(src.lastIndexOf('/')+1, src.length);		

		$.ajax({
	        url: "http://localhost/roberto/SAEnchentes/WEB/ProjetoWeb2/Comum/php/funcoes.php?getInfoImagem=?",
			data: { 'nomeImagem' : nomeImagem},
		    dataType:'jsonp',
	        crossDomain: true,
	
			//Ao finalizar request executa o resto da pagina
	        success: function(data){
	        	infoImagem = data;
	        	var img = '<img src="' + src + '" class="img-responsive"/>';

				//start of new code new code
				var index = $(this).parent('li').index();
		
				var legenda = '';
				legenda = infoImagem['cidade'] +": "+infoImagem['bairro'] +" - Rua "+infoImagem['rua'];
				legenda += "  |  "+ infoImagem['data'] +" - "+ infoImagem['hora'];
				var html = '';
				html += img;
				html += '<div style="height:47px;clear:both;display:block;">';
				html += '<div id="legenda">'+(legenda)+'</div>';
				html += '<a class="controls next" href="' + (index + 2) + '">próximo &raquo;</a>';
				html += '<a class="controls previous" href="' + (index) + '">&laquo; anterior</a>';
				html += '</div>';
		
				$('#myModal').modal();
				$('#myModal').on('shown.bs.modal', function() {
					$('#myModal .modal-body').html(html);
					//Novo código
					$('a.controls').trigger('click');
				});
				$('#myModal').on('hidden.bs.modal', function() {
					$('#myModal .modal-body').html('');
				});
	        }
	    });
	});
});

//Novo código
$(document).on('click', 'a.controls', function() {
	
	var index = $(this).attr('href');
	var src = $('ul.row li:nth-child(' + index + ') img').attr('src');
	//Altera URL da imagem de thumbs para imagens
	try {
		src = src.replace("thumbs", "imagens");
	} catch(err) {
		//Este catch corrige problema ao passar muitas vezes por essa linha
	}

	$('.modal-body img').attr('src', src);

	var newPrevIndex = parseInt(index) - 1;
	var newNextIndex = parseInt(newPrevIndex) + 2;

	if ($(this).hasClass('previous')) {
		$(this).attr('href', newPrevIndex);
		$('a.next').attr('href', newNextIndex);
	} else {
		$(this).attr('href', newNextIndex);
		$('a.previous').attr('href', newPrevIndex);
	}

	var total = $('ul.row li').length + 1;
	//Esconde botão Próximo
	if (total === newNextIndex) {
		$('a.next').hide();
	} else {
		$('a.next').show();
	}
	//Esconde botão Anterior
	if (newPrevIndex === 0) {
		$('a.previous').hide();
	} else {
		$('a.previous').show();
	}

	return false;
}); 