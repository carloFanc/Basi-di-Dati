	$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data
			'nome' : $('input[name=form-nome]').val() ,
			'sito' : $( 'input[name=form-sito]' ).val(),
			'email' : $('input[name=form-email]').val() ,
			'tel' : $('input[name=form-tel]').val(),
			'ind' : $('input[name=form-ind]').val(),
			'lat' : $('input[name=form-lat]').val() ,
			'long' : $('input[name=form-long]').val()
		};

		$.ajax({//Process the form using $.ajax()
			type : 'POST', //Method type
			url : '/BasiDati/function/InsPuntiNoleggio.php', 
			data : postForm, //Forms name
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