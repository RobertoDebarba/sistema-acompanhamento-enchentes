<?php
include 'header.php';
$meta = array();

$meta['pag_inicial'] = true;
$meta['descricao'] = 'Sistema Online de Acompanhamento de Enchentes e Inundações';
$meta['css'] = array('css/index.css', 'css/mapa-index.css');
$meta['menuAtivo'] = 0;

printHeader($meta);
?>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '586048604832464',
      xfbml      : true,
      version    : 'v2.1'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=586048604832464&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div id="facebook">
	<!-- LIKE SHARE -->
	<div
	  class="fb-like"
	  data-share="true"
	  data-width="450"
	  data-show-faces="true">
	</div>
	
	<!-- LOGIN -->
	<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>
	
</div>



<?php
include 'footer.php';
printFooter();
?>