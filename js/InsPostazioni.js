	$('form').submit(function(event) {
		$('#name + .throw_error').empty();
		$('#success').empty();


		var postForm = {//Fetch form data
			'ind' : $('input[name=form-ind]').val() ,
			'num1' : $( 'input[name=form-num1]' ).val(),
			'num2' : $('input[name=form-num2]').val(),  
			'lat' : $('input[name=form-lat]').val() ,
			'long' : $('input[name=form-long]').val()
		};

		$.ajax({
			type : 'POST', 
			url : '/BasiDati/function/InsPostazioni.php', 
			data : postForm, 
			dataType : 'json',
			success : function(data) {
				if (!data.success) {
					if (data.errors) {
						alert("Errore");
						cambiaContenuto('nuovapostazione');
					}
				} else {
					alert("Postazione Inserita");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
	});
//});