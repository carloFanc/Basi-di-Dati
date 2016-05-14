
// upload foto
$(document).ready(function(e) {
	$("#uploadimage").on('submit', (function(e) {
		e.preventDefault();
		$.ajax({
			url : "/BasiDati/function/InputFoto.php", // Url to which the request is send
			type : "POST", // Type of request to be send, called as method
			data : new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType : false, // The content type used when sending data to the server.
			cache : false, // To unable request pages to be cached
			processData : false, // To send DOMDocument or non processed data file it is set to false
			success : function()// A function to be called if request succeeds
			{
				var postForm = {//Fetch form data
					'targa' : $('input[name=form-targa]').val(),
					'puntonoleggio' : $("#form-punti option:selected").text(),
					'tipologia' : $("#form-tipo option:selected").text(),
					'nomemodello' : $('input[name=form-modello]').val(),
					'colore' : $('input[name=form-colore]').val(),
					'costorario' : $('input[name=form-costo]').val(),
					'cilindrata' : $('input[name=form-cilindrata]').val(),
					'autonomia' : $('input[name=form-autonomia]').val(),
					'passeggeri' : $('input[name=form-passeggeri]').val(),
					'chilometri' : $('input[name=form-chilometri]').val(),
					'foto' : $('input[name=file]').val() ,

				};
				$.ajax({//Process the form using $.ajax()
					type : 'POST', //Method type
					url : '/BasiDati/function/InsVeicoli.php',
					data : postForm, //Forms name
					dataType : 'json',
					success : function(data) {
						if (!data.success) {
							if (data.errors) {
								alert(data.errors);
								alert("Errore");
								cambiaContenuto('nuovoveicolo');
							}
						} else {
							alert("Complimenti dati inseri!");
							cambiaContenuto("vuoto");
						}
					}
				});
			}
		});
	}));
});
  
