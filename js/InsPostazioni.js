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
						BootstrapDialog.show({
							title : 'Errore',
							message : 'Errore',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('nuovapostazione');
								}
							}]
						});
					}
				} else {
					BootstrapDialog.show({
							title : 'Postazione Inserita',
							message : 'Postazione Inserita',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('vuoto');
								}
							}]
						});
				}
			}
		});
		event.preventDefault();
	});
//});