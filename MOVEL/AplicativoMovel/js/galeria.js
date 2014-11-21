var src;
var nomeImagem; //Nome da imagem retirado do link

function carregarImagensGaleria(links) {
    var cont; 
    var i = 1; //contador
    for (cont in links) {
        var itemgaleria = links[cont];
        $("#exibirImagens").append(
            "<img class='imgflex col-lg-2 col-md-3 col-sm-4 col-xs-6' src='http://54.232.207.63/Comum/galeria/thumbs/"+ itemgaleria + "'>");      
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
 * Busca nome da imagem no link e salva na var nomeImagem
 * @param {Object} src
 */
function getNomeImagem(src) {
    nomeImagem = src.substring(src.lastIndexOf('/')+1, src.length); 
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
            infoImagem = data;
            
            legenda = '';
            legenda = infoImagem['cidade'] +": "+infoImagem['bairro'] +" - Rua "+infoImagem['rua'];
            legenda += "  |  "+ infoImagem['data'] +" - "+ infoImagem['hora'];
            
            $('#legenda').html(legenda);
        }
    });
}


$(document).on('click', "img.imgflex", function() {      
    //start of new code new code
    var index = $(this).index();
     
    var html = '';
    html += '<img onload="imgload()" src="" class="img-responsive"/>';
    html += '<div style="height:47px;clear:both;display:block;">';
    html += '<div id="legenda"></div>';
    html += '<a id="' + (index + 1) + '" class="button button-positive controls next">próximo</a>';
    html += '<a id="' + (index - 1) + '" class="button button-positive controls previous">anterior</a>';
    html += '</div>';

    $('#myModal').modal();
    $('#myModal').on('shown.bs.modal', function() {
        $('#myModal .modal-body').html(html);
        abrirImgModal(index); 
    });
});

var elem;
//Novo código
$(".modal-body").on('click', "a.button", function(event) {        
    elem = $(event.target);
    
    var id = $(elem).attr("id");
    
    abrirImgModal(id);
});
    
function abrirImgModal(index) { 
    $("img.img-responsive").hide();
      
    src = $('#exibirImagens img:eq(' + index + ')').attr('src');
    
    //Altera URL da imagem de thumbs para imagens
    src = src.replace("thumbs", "imagens");
    
    //Salva nome da imagem na var nomeImagem
    getNomeImagem(src);
    
    //Atualiza legenda
    atualizarLegenda();
    
    var anteriorIndex = parseInt(index) - 1;
    var proximoIndex = parseInt(index) + 1;

    if ($(elem).hasClass('previous')) {
        $('a.previous').attr('id', anteriorIndex);
        $('a.next').attr('id', index);
    } else {
        $(".a.next").attr('id', proximoIndex);
        $('a.previous').attr('id', index);
    }

    var total = $('#exibirImagens img').length-1;
    
    $('a.next').show();
    $('a.previous').show();
    
    //Esconde botão Próximo
    if (index === total) {
        $('a.next').hide();
    }
    //Esconde botão Anterior
    if (index === 0) {
        $('a.previous').hide();

    }
    
    $("img.img-responsive").attr('src',src);
}


function imgload(){
    $("img.img-responsive").show();
}
