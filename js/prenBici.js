jQuery(document).ready(function() {

	$('#datetimepicker1').datetimepicker({
		format : 'YYYY-MM-DD hh:mm:ss'
	});
	$('#datetimepicker2').datetimepicker({
		format : 'YYYY-MM-DD hh:mm:ss'
	});

	$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data

			'id' : $("#form-bici option:selected").text(),
			'date1' : $('input[name=form-date1]').val(),
			'date2' : $('input[name=form-date2]').val() //Store name fields value
		};

		$.ajax({//Process the form using $.ajax()
			type : 'POST', //Method type
			url : '/BasiDati/function/prenbici.php', //Your form processing file URL
			data : postForm, //Forms name
			dataType : 'json',
			success : function(data) {
				if (!data.success) {//If fails
					if (data.errors) {
						var typeError1 = "prenotabile";
						var typeError2 = "prenotare";
						//Returned if any error from process.php
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
					//$('#success').fadeIn(1000).append('<p>' + data.posted + '</p>');
					//If successful, than throw a success message
				}
			}
		});
		event.preventDefault();
		//Prevent the default submit
	});
});
