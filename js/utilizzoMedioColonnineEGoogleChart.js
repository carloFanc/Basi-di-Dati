
$('select').niceSelect();

$(document).ready(function(){
  google.charts.load('current', {packages: ['corechart']});
  google.charts.setOnLoadCallback(drawChart);
});

$('#invio').click(function() {
	var indirizzo = $('#form-col option:selected').text();
	var totale_Slot = 0;
	var totale_Slot_Usati = 0;
	var currentTime = new Date();
	var day = currentTime.getDate();
	var month = currentTime.getMonth() + 1;
	var year = currentTime.getFullYear();

	if (day < 10) {
		day = "0" + day;
	}

	if (month < 10) {
		month = "0" + month;
	}

	var today_date = year + "-" + month + "-" + day;

	$.ajax({//Process the form using $.ajax() PRENDO LA DATA INIZIO DELLA CREAZIONE COLONNINA
		type : 'POST', //Method type
		url : '/BasiDati/function/get_date_colonnina_start.php',
		data : "indirizzo=" + indirizzo,
		success : function(data1) {
			data1 = replaceAll(data1, "\"", "");

			$.ajax({//Process the form using $.ajax() PRENDO TUTTE LE PRENOTAZIONI DI UNA COLONNINA E TROVO GLI SLOT TOTALI
				type : 'POST', //Method type
				url : '/BasiDati/function/get_all_prenotazioni_of_one_colonnina.php',
				data : "indirizzo=" + indirizzo,

				success : function(dati) {

					$.each(dati, function(index, element) {
						totale_Slot_Usati = parseInt(element.Slot_Fine) - parseInt(element.Slot_Inizio) + totale_Slot_Usati;
					});
					var from = moment(data1, 'YYYY-MM-DD');
					var to = moment(today_date, 'YYYY-MM-DD');
					var duration = to.diff(from, 'days');
					totale_Slot = parseInt(duration) * 48;

					var data = google.visualization.arrayToDataTable([['Task', 'Hours per Day'], ['Totale Slot', parseInt(totale_Slot)], ['Totale Slot Usati', parseInt(totale_Slot_Usati)]]);
					var titolo ='Utilizzo slot Colonnina di ' + indirizzo;
					var options = {
						title : titolo
					};

					var chart = new google.visualization.PieChart(document.getElementById('datiUtilizzo'));

					chart.draw(data, options);

				}
			});

		}
	});

	function replaceAll(str, find, replace) {
		return str.replace(new RegExp(find, 'g'), replace);
	}

});
