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
						BootstrapDialog.show({
							title : 'ERRORE',
							message : 'Errore',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('nuovabici');
								}
							}]
						});
					}
				} else {
					BootstrapDialog.show({
							title : 'Bici Inserita',
							message : 'Bici Inserita',
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