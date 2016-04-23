	$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data
			
			'id' : $( "#form-piste option:selected" ).text(),
			'titolo' : $('input[name=form-titolo]').val() ,
			'testo' : $('input[name=form-testo]').val()  //Store name fields value
		};

		$.ajax({//Process the form using $.ajax()
			type : 'POST', //Method type
			url : '/BasiDati/function/InsSegnalaz.php', //Your form processing file URL
			data : postForm, //Forms name
			dataType : 'json',
			success : function(data) {
				if (!data.success) {//If fails
					if (data.errors) {
						alert("Errore connessione al database");
						cambiaContenuto('inssegalaz');
					}
				} else {
					alert("Segnalazione Inviata");
					cambiaContenuto('vuoto');
					//$('#success').fadeIn(1000).append('<p>' + data.posted + '</p>');
					//If successful, than throw a success message
				}
			}
		});
		event.preventDefault();
		//Prevent the default submit
	});
//});
