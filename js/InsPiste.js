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
						BootstrapDialog.show({
							title : 'Errore',
							message : 'Errore',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('nuovapista');
								}
							}]
						});
					}
				} else {
					BootstrapDialog.show({
							title : 'Pista Ciclabile Inserita',
							message : 'Pista Ciclabile Inserita',
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