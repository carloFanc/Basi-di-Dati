jQuery(document).ready(function() {

	$('#datetimepicker').datetimepicker({
		language : 'it',
		pick12HourFormat : false,
		pickTime : true
	});

	$('#datetimepicker2').datetimepicker({
		language : 'it',
		pick12HourFormat : false,
		pickTime : true
	});

	$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data
			
			'Targa' : $( "#form-targa option:selected" ).text(),
			'date1' : $('input[name=form-date1]').val() ,
			'date2' : $('input[name=form-date2]').val()  //Store name fields value
		};

		$.ajax({//Process the form using $.ajax()
			type : 'POST', //Method type
			url : '/BasiDati/function/prenveicoli.php', //Your form processing file URL
			data : postForm, //Forms name
			dataType : 'json',
			success : function(data) {
				if (!data.success) {//If fails
					if (data.errors) {
						var typeError1 = "prenotabile";
					//Returned if any error from process.php
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
					//$('#success').fadeIn(1000).append('<p>' + data.posted + '</p>');
					//If successful, than throw a success message
				}
			}
		});
		event.preventDefault();
		//Prevent the default submit
	});
});