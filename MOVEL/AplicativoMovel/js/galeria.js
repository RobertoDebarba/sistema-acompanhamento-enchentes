var src; //caminhoo do imagen
var nomeImagem; //Nome da imagem retirado do link
var elem; //arqmazena o botao clicado na imagem

function carregarImagensGaleria(links) {
    var cont;
    var itemgaleria;
    for (cont in links) {
        itemgaleria = links[cont];
        $("#exibirImagens").append(
            "<img class='imgflex col-lg-2 col-md-3 col-sm-4 col-xs-6' src='http://54.232.207.63/Comum/galeria/thumbs/" + itemgaleria + "'>");
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

/**
 * Atualiza a legenda da imagem com base na var nomeImagem
 */
function atualizarLegenda() {
    $.ajax({
        url: "http://54.232.207.63/Comum/php/funcoes.php?getInfoImagem=?",
        data: { 'nomeImagem' : nomeImagem},
        dataType:'jsonp',
        crossDomain: true,

        //Ao finalizar request executa o resto da pagina
        success: function(data){            
            var legenda = '';
            
            legenda = data['cidade'] + ": " + data['bairro'] + " - Rua " + data['rua'];
            legenda += "  |  " + data['data'] + " - " + data['hora'];
            
            $('#legenda').html(legenda);
        }
    });
}

/**
 * abre o modal que exibe a imagem
 */    
function abrirImgModal(index) { 
    
    src = $('#exibirImagens img:eq(' + index + ')').attr('src');
    
    //Altera URL da imagem de thumbs para imagens
    src = src.replace("thumbs", "imagens");
    
    //Salva nome da imagem na var nomeImagem
    nomeImagem = src.substring(src.lastIndexOf('/') + 1, src.length); 
    
    //Atualiza legenda
    atualizarLegenda();  
    
    var anteriorIndex = parseInt(index, 10) - 1;
    var proximoIndex = parseInt(anteriorIndex, 10) + 2;
     
    if ($(elem).hasClass('previous')) {
        $(elem).attr('id', anteriorIndex);
        $('a.next').attr('id', proximoIndex);
    } else {
        $(elem).attr('id', proximoIndex);
        $('a.previous').attr('id', anteriorIndex);
    }
    
    var total = $('#exibirImagens img').length - 1;//qtd de <img> na div 
    
    $('a.next').show();
    $('a.previous').show();
    
    //Esconde botão Próximo
    if (index == total) {
        $('a.next').hide();
    }
    //Esconde botão Anterior
    if (index == 0) {
        $('a.previous').hide();
    }
    
    $("img.img-responsive").attr('src',src);
}
 

/***
 * evento do clic das imagens
 */
$(document).on('click', "img.imgflex", function() {      
    //start of new code new code
    var index = $(this).index();
    
    var html = '';
    html += '<img src="" class="img-responsive"/>';
    html += '<div style="height:40px;clear:both;">';
    html += '<div id="legenda"></div>';
    html += '<a id="' + (index + 1) + '" class="btn btn-primary controls next"> Próximo >> </a>';
    html += '<a id="' + (index - 1) + '" class="btn btn-primary controls previous"> << Anterior </a>';
    html += '</div>';

    $('#myModal').modal();
    $('#myModal').on('shown.bs.modal', function() {
        $('#myModal .modal-body').html(html);
        abrirImgModal(index); 
    });
});

/**
 * evento de click dos botoe proximo e anterior
 * pega a id do que foi clicado
 */
$(".modal-body").on('click', "a.btn", function(event) {        
    elem = $(event.target);
    
    var id = $(elem).attr("id");
    abrirImgModal(id);
});
