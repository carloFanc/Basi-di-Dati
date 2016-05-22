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
							alert("veicolo non prenotabile");
							cambiaContenuto('prenveicoli');
						} else {
							alert("Errore connessione al database");
							cambiaContenuto('prenveicoli');
						}
					}
				} else {
					alert("Veicolo Prenotato");
					cambiaContenuto('vuoto');

				}
			}
		});
		event.preventDefault();
	});
});
