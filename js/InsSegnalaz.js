	$('form').submit(function(event) {
		$('#name + .throw_error').empty();
		
		$('#success').empty();
		var postForm = {
			
			'id' : $( "#form-piste option:selected" ).text(),
			'titolo' : $('input[name=form-titolo]').val() ,
			'testo' : $('input[name=form-testo]').val()  
		};

		$.ajax({
			type : 'POST', 
			url : '/BasiDati/function/InsSegnalaz.php', 
			data : postForm, 
			dataType : 'json',
			success : function(data) {
				if (!data.success) {
					if (data.errors) {
						alert("Errore connessione al database");
						cambiaContenuto('inssegalaz');
					}
				} else {
					alert("Segnalazione Inviata");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
		
	});
//});
