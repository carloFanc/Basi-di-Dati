	$('form').submit(function(event) {
		$('#name + .throw_error').empty();
		
		$('#success').empty();

		var postForm = {
			'nome' : $('input[name=form-nome]').val() ,
			'sito' : $( 'input[name=form-sito]' ).val(),
			'email' : $('input[name=form-email]').val() ,
			'tel' : $('input[name=form-tel]').val(),
			'ind' : $('input[name=form-ind]').val(),
			'lat' : $('input[name=form-lat]').val() ,
			'long' : $('input[name=form-long]').val()
		};

		$.ajax({
			type : 'POST', 
			url : '/BasiDati/function/InsPuntiNoleggio.php', 
			data : postForm, 
			dataType : 'json',
			success : function(data) {
				if (!data.success) {
					if (data.errors) {
						alert("Errore");
						cambiaContenuto('nuovopuntonoleggio');
					}
				} else {
					alert("Punto Noleggio Inserito");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
	});
//});