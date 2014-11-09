<?php
include 'header.php';
$meta = array();

$meta['pag_inicial'] = false;
$meta['pagina'] = 'Galeria';
$meta['descricao'] = 'Galeria Colaborativa';
$meta['css'] = array('css/page-galeria.css');
$meta['menuAtivo'] = 0;

printHeader($meta);
?>
<style>
	ul {
		padding: 0 0 0 0;
		margin: 0 0 0 0;
	}

	ul li {
		list-style: none;
		margin-bottom: 1px;
		margin-top: 1px;
	}

	ul li img {
		cursor: pointer;
	}

	.modal-body {
		padding: 5px !important;
	}

	.modal-content {

	}

	.modal-dialog img {
		text-align: center;
		margin: 0 auto;
	}

	.controls {
		width: 50px;
		display: block;
		font-size: 11px;
		padding-top: 8px;
		font-weight: bold;
	}

	.next {
		float: right;
		text-align: right;
	}

	/*override modal for demo only*/
	.modal-dialog {
		max-width: 500px;
		padding-top: 90px;
	}

	@media screen and (min-width: 768px) {
		.modal-dialog {
			width: 500px;
			padding-top: 90px;
		}
	}

	@media screen and (max-width: 1500px) {
		#ads {
			display: none;
		}
	}

	.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
		padding-right: 1px;
		padding-left: 1px;
	}

	body {
		background-color: black;
	}

	li .img-responsive {
		clip: rect(0px,100px,100px,0px);
	}

</style>

<div class="container">
	<ul class="row">
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/2.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-174908-rocking-the-night-away-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-287182-blah-blah-blah-yellow-road-sign-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-460760-colors-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-461673-retro-party-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-514834-touchscreen-technology-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-916206-legal-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-1062948-nature-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-1471528-insant-camera-kid-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-2255072-relaxed-man-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-2360379-colors-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-2360571-jump-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-2361384-culture-for-business-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-2441670-spaghetti-with-tuna-fish-and-parsley-s.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-2943363-budget-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-3444921-street-art-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-3552322-insurance-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-3807845-food-s.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-3835655-down-office-worker-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-4619216-ui-control-knob-regulators-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-5771958-health-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-268693-businesswoman-using-laptop-outdoors-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-352207-search-of-code-s.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-247190-secret-email-xs.jpg">
		</li>
		<li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<img class="img-responsive" src="images/photodune-682990-online-search-xs.jpg">
		</li>
	</ul>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('li img').on('click', function() {
			var src = $(this).attr('src');
			var img = '<img src="' + src + '" class="img-responsive"/>';

			//start of new code new code
			var index = $(this).parent('li').index();

			var html = '';
			html += img;
			html += '<div style="height:25px;clear:both;display:block;">';
			html += '<a class="controls next" href="' + (index + 2) + '">next &raquo;</a>';
			html += '<a class="controls previous" href="' + (index) + '">&laquo; prev</a>';
			html += '</div>';

			$('#myModal').modal();
			$('#myModal').on('shown.bs.modal', function() {
				$('#myModal .modal-body').html(html);
				//new code
				$('a.controls').trigger('click');
			})
			$('#myModal').on('hidden.bs.modal', function() {
				$('#myModal .modal-body').html('');
			});

		});

	})
	//new code
	$(document).on('click', 'a.controls', function() {
		var index = $(this).attr('href');
		var src = $('ul.row li:nth-child(' + index + ') img').attr('src');

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
		//hide next button
		if (total === newNextIndex) {
			$('a.next').hide();
		} else {
			$('a.next').show()
		}
		//hide previous button
		if (newPrevIndex === 0) {
			$('a.previous').hide();
		} else {
			$('a.previous').show()
		}

		return false;
	});

</script>

<!-- FACEBOOK
<script>
window.fbAsyncInit = function() {
FB.init({
appId : '586048604832464',
xfbml : true,
version : 'v2.1'
});
}; ( function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) {
return;
}
js = d.createElement(s);
js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div id="fb-root"></div>
<script>
( function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id))
return;
js = d.createElement(s);
js.id = id;
js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=586048604832464&version=v2.0";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<div id="facebook">
<!-- LIKE SHARE --
<div
class="fb-like"
data-share="true"
data-width="450"
data-show-faces="true"></div>

<!-- LOGIN --
<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>

</div>
-->
<?php
include 'footer.php';
printFooter();
?>