$('#datetimepicker').datetimepicker({
	format : 'YYYY-MM-DD'
});

	$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data
			'ind' : $('input[name=form-ind]').val() ,
			'ente' : $( 'input[name=form-ente]' ).val(),
			'max' : $('input[name=form-max]').val() ,
			'data' : $('input[name=form-data]').val(),
			'lat' : $('input[name=form-lat]').val() ,
			'long': $('input[name=form-long]').val()
		};
		$.ajax({//Process the form using $.ajax()
			type : 'POST', //Method type
			url : '/BasiDati/function/InsColonnine.php', 
			data : postForm, //Forms name
			dataType : 'json',
			success : function(data) {
				if (!data.success) {
					if (data.errors) {
						alert("Errore");
						cambiaContenuto('nuovacolonnina');
					}
				} else {
					alert("Colonnina Inserita");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
	});
//});