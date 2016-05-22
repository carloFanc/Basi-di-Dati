$(document).ready(function(e) {
	$("#uploadimage").on('submit', (function(e) {
		e.preventDefault();
		$.ajax({
			url : "/BasiDati/function/InputFotoRegistrazione.php",
			type : "POST",
			data : new FormData(this),
			contentType : false,
			cache : false,
			processData : false,
			success : function() {
				var postForm = {
					'name' : $('input[name=form-first-name]').val(),
					'surname' : $('input[name=form-last-name]').val(),
					'mail' : $('input[name=form-email]').val(),
					'pass' : $('input[name=form-pass]').val(),
					'data' : $('input[name=form-date]').val(),
					'luogo' : $('input[name=form-luogo]').val(),
					'res' : $('input[name=form-resid]').val(),
					'tel' : $('input[name=form-tel]').val(),
					'foto' : $('input[name=file]').val()
				};
				$.ajax({
					type : 'POST',
					url : '/BasiDati/function/InsSignUp.php',
					data : postForm,

					success : function(data) {
						if (data == 'ok') {
							BootstrapDialog.show({
								title : 'Registrazione effettuata',
								message : 'Sei stato registrato correttamente',
								buttons : [{
									label : 'Ok',
									action : function(dialog) {

										window.location.href = "index.php";
									}
								}]
							});
						} else {
							BootstrapDialog.show({
								title : 'Registrazione BLOCCATA',
								message : 'Email gia registrata!',
								buttons : [{
									label : 'Chiudi',
									action : function(dialog) {
										dialog.close();
									}
								}]
							});

						}

					}
				});
			}
		});
	}));
});
$('#datetimepicker').datetimepicker({
	format : 'YYYY-MM-DD',
	locale : 'it'
});
