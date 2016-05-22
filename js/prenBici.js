$('select').niceSelect();
jQuery(document).ready(function() {

	$('#datetimepicker1').datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss',
		locale:'it'
	});
	$('#datetimepicker2').datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss',
		locale:'it'
	});

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
							alert("Bici non prenotabile");
							cambiaContenuto('prenbici');
						} else if (data.errors.indexOf(typeError2) > -1) {
							alert("Non si puo prenotare per piu di 12 ore");
							cambiaContenuto('prenbici');
						} else {
							alert("Errore connessione al database");
							cambiaContenuto('prenbici');
						}
					}
				} else {
					alert("Bici Prenotata");
					cambiaContenuto('vuoto');

				}
			}
		});
		event.preventDefault();
	});
});

