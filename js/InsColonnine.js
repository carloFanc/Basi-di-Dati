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
						alert("Errore");
						cambiaContenuto('nuovacolonnina');
					}
				} else {
					alert("Colonnina Inserita");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
	});
