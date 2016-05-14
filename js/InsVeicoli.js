$('form').submit(function(event) {//Trigger on form submit
		$('#name + .throw_error').empty();
		//Clear the messages first
		$('#success').empty();

		//Validate fields if required using jQuery

		var postForm = {//Fetch form data
			'targa' : $('input[name=form-targa]').val() ,
			'puntonoleggio' : $( "#form-punti option:selected" ).text(),
			'tipologia' : $("#form-tipo option:selected").text(),  
			'nomemodello' : $('input[name=form-modello]').val() ,
			'colore' : $('input[name=form-colore]').val(),
			'costorario' : $('input[name=form-costo]').val() ,
			'cilindrata' : $('input[name=form-cilindrata]').val(),
			'autonomia' : $('input[name=form-autonomia]').val(),  
			'passeggeri' : $('input[name=form-passeggeri]').val() ,
			'chilometri' : $('input[name=form-chilometri]').val(),
			'foto' : $('input[name=form-foto]').val() ,
			
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
					alert("Veicolo Inserito");
					cambiaContenuto('vuoto');
				}
			}
		});
		event.preventDefault();
	});
//});