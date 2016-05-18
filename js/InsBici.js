	$('form').submit(function(event) {
		$('#name + .throw_error').empty();
		$('#success').empty();


		var postForm = {
			'id' : $('input[name=form-id]').val() ,
			'postazione' : $( "#form-post option:selected" ).text(),
			'marca' : $('input[name=form-marca]').val(),  
			'colore' : $('input[name=form-colore]').val() ,
			'anno' : $('input[name=form-anno]').val()
		};

		$.ajax({
			type : 'POST', 
			url : '/BasiDati/function/InsBici.php', 
			data : postForm, 
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