	$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data
			'km' : $('input[name=form-km]').val() ,
			'pend' : $( 'input[name=form-pend]' ).val(),
			'lat' : $('input[name=form-lat]').val() ,
			'long' : $('input[name=form-long]').val()
		};

		$.ajax({//Process the form using $.ajax()
			type : 'POST', //Method type
			url : '/BasiDati/function/InsPiste.php', 
			data : postForm, //Forms name
			dataType : 'json',
			success : function(data) {
				if (!data.success) {
					if (data.errors) {
						alert("Errore");
						cambiaContenuto('nuovapista');
					}
				} else {
					alert("Pista Ciclabile Inserita");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
	});
//});