	$('form').submit(function(event) {
		$('#name + .throw_error').empty();
		
		$('#success').empty();

		

		var postForm = {
			'km' : $('input[name=form-km]').val() ,
			'pend' : $( 'input[name=form-pend]' ).val(),
			'lat' : $('input[name=form-lat]').val() ,
			'long' : $('input[name=form-long]').val()
		};

		$.ajax({
			type : 'POST', 
			url : '/BasiDati/function/InsPiste.php', 
			data : postForm, 
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