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
						BootstrapDialog.show({
							title : 'Errore',
							message : 'Errore',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('inssegalaz');
								}
							}]
						});
					}
				} else {
					BootstrapDialog.show({
							title : 'Segnalazione Inviata',
							message : 'Segnalazione Inviata',
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
	$('select').niceSelect();