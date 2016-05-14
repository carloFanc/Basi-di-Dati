	$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data
			'id' : $('input[name=form-id]').val() ,
			'postazione' : $( "#form-post option:selected" ).text(),
			'marca' : $('input[name=form-marca]').val(),  
			'colore' : $('input[name=form-colore]').val() ,
			'anno' : $('input[name=form-anno]').val()
		};

		$.ajax({//Process the form using $.ajax()
			type : 'POST', //Method type
			url : '/BasiDati/function/InsBici.php', 
			data : postForm, //Forms name
			dataType : 'json',
			success : function(data) {
				if (!data.success) {
					if (data.errors) {
						alert("Errore");
						cambiaContenuto('nuovabici');
					}
				} else {
					alert("Bici Inserita");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
	});
//});