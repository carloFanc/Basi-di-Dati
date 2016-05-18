
// upload foto
$(document).ready(function(e) {
	$("#uploadimage").on('submit', (function(e) {
		e.preventDefault();
		$.ajax({
			url : "/BasiDati/function/InputFoto.php", 
			type : "POST", 
			data : new FormData(this), 
			contentType : false, 
			cache : false, 
			processData : false, 
			success : function()
			{
				var postForm = {
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
				$.ajax({
					type : 'POST', 
					url : '/BasiDati/function/InsVeicoli.php',
					data : postForm, 
					dataType : 'json',
					success : function(data) {
						if (!data.success) {
							if (data.errors) {
								alert(data.errors);
								alert("Errore");
								cambiaContenuto('nuovoveicolo');
							}
						} else {
							alert("Veicolo inserito!");
							cambiaContenuto("vuoto");
						}
					}
				});
			}
		});
	}));
});
  
