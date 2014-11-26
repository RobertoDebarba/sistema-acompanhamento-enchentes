var faceMensagem = "";
var faceImagem;
var faceToken;

function statusChangeCallback(response) {
    console.log(response);
    if (response.status === 'connected') {
       $(".modalUm").show();
       $("#contente").hide();
       
        faceToken = response.authResponse.accessToken;
    }
    else{
        alert("Não foi possivel conectar-se ao facebook."+response);
    }
  }

function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

function ativaFace(){
    $("contente").show();
    
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '381317252022767',
            xfbml      : true,  // parse social plugins on this page
          version    : 'v2.2'
        }); 
      };
    
      // Load the SDK asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
}

function sendImage() {
    var privacy = {"value":'EVERYONE'};
    
    FB.api(
    "/me/photos",
    "POST",
    {
        name : faceMensagem,
        access_token: faceToken, 
        message: "Nova foto das enchentes de Timbó. Visualize-as e acompanhe a enchente pelo Monitor de enchentes disponível em http://54.232.207.63/",
         url: "http://54.232.207.63/Comum/galeria/imagems/" + faceImagem,
         privacy: privacy,
    },
    function (response) {
        console.log(response);
    });
}