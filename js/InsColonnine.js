$('#datetimepicker').datetimepicker({
	format : 'YYYY-MM-DD'
});

	$('form').submit(function(event) {
		$('#name + .throw_error').empty();
		
		$('#success').empty();

		

		var postForm = {
			'ind' : $('input[name=form-ind]').val() ,
			'ente' : $( 'input[name=form-ente]' ).val(),
			'max' : $('input[name=form-max]').val() ,
			'data' : $('input[name=form-data]').val(),
			'lat' : $('input[name=form-lat]').val() ,
			'long': $('input[name=form-long]').val()
		};
		$.ajax({
			type : 'POST', 
			url : '/BasiDati/function/InsColonnine.php', 
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
									cambiaContenuto('nuovacolonnina');
								}
							}]
						});
					}
				} else {
					BootstrapDialog.show({
							title : 'Colonnina Inserita',
							message : 'Colonnina Inserita',
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
