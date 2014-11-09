$(document).ready(function() {
	$('li img').on('click', function() {
		var src = $(this).attr('src');
		//Altera URL da imagem de thumbs para imagens
		try {
			src = src.replace("thumbs", "imagens");
		} catch(err) {
			//Este catch corrige problema ao passar muitas vezes por essa linha
		}
		
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
			//Novo código
			$('a.controls').trigger('click');
		})
		$('#myModal').on('hidden.bs.modal', function() {
			$('#myModal .modal-body').html('');
		});

	});

})

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
		$('a.next').show()
	}
	//Esconde botão Anterior
	if (newPrevIndex === 0) {
		$('a.previous').hide();
	} else {
		$('a.previous').show()
	}

	return false;
}); 