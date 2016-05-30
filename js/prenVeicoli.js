jQuery(document).ready(function() {

	$('#datetimepicker1').datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss',
		locale:'it'
	});
	$('#datetimepicker2').datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss',
		locale:'it'
	});

	
});

$('select').niceSelect();

$('form').submit(function(event) {
		$('#name + .throw_error').empty();
		$('#success').empty();

		var postForm = {

			'Targa' : $("#form-targa option:selected").text(),
			'date1' : $('input[name=form-date1]').val(),
			'date2' : $('input[name=form-date2]').val()
		};

		$.ajax({
			type : 'POST', 
			url : '/BasiDati/function/prenveicoli.php', 
			data : postForm,
			dataType : 'json',
			success : function(data) {
				if (!data.success) {
					if (data.errors) {
						var typeError1 = "prenotabile";
						if (data.errors.indexOf(typeError1) > -1) {
							BootstrapDialog.show({
							title : 'Veicolo non prenotabile',
							message : 'Veicolo non prenotabile',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('prenveicoli');
								}
							}]
						});
						} else {
							BootstrapDialog.show({
							title : 'Errore',
							message : 'Errore connessione al database',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('prenveicoli');
								}
							}]
						});
						}
					}
				} else {
					BootstrapDialog.show({
							title : 'Veicolo Prenotato!',
							message : 'Veicolo Prenotato!',
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