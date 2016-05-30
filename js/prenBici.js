jQuery(document).ready(function() {

	$('#datetimepicker1').datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss',
		locale : 'it'
	});
	$('#datetimepicker2').datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss',
		locale : 'it'
	});

});
$('select').niceSelect();

$('form').submit(function(event) {
	$('#name + .throw_error').empty();

	$('#success').empty();

	var postForm = {

		'id' : $("#form-bici option:selected").text(),
		'date1' : $('input[name=form-date1]').val(),
		'date2' : $('input[name=form-date2]').val()
	};

	$.ajax({
		type : 'POST',
		url : '/BasiDati/function/prenbici.php',
		data : postForm,
		dataType : 'json',
		success : function(data) {
			if (!data.success) {
				if (data.errors) {
					var typeError1 = "prenotabile";
					var typeError2 = "prenotare";

					if (data.errors.indexOf(typeError1) > -1) {
						BootstrapDialog.show({
							title : 'Bici non prenotabile',
							message : 'Bici non prenotabile',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('prenbici');

								}
							}]
						});
 
					} else if (data.errors.indexOf(typeError2) > -1) {
						BootstrapDialog.show({
							title : 'Non si puo prenotare per piu di 12 ore',
							message : 'Non si puo prenotare per piu di 12 ore',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('prenbici');
								}
							}]
						});
 
					} else {
						BootstrapDialog.show({
							title : 'Errore connessione al database',
							message : 'Errore connessione al database',
							buttons : [{
								label : 'Chiudi',
								action : function(dialog) {
									dialog.close();
									cambiaContenuto('prenbici');
								}
							}]
						});
 
					}
				}
			} else {
				BootstrapDialog.show({
					title : 'Bici Prenotata',
					message : 'Bici Prenotata',
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
