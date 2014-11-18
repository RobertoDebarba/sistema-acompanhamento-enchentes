/**
 * Verifica se a pagina ativa é o index e chama o simulador
 */
function ativarSimulador() {
    paginaAtiva = document.URL;
    
    //Verifica se pagina atual é index
    if (paginaAtiva.search("index") != -1) {
        //Chama simulador
        passarImg('show');
    } else {
        //redireciona para index passando parametro
        window.location.replace("index.php?simulador=true");
    }
}
