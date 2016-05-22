
$('select').niceSelect();

$(document).ready(function(){
  google.charts.load('current', {packages: ['corechart']});
  
});

$('#invio').click(function() {
	var indirizzo = $('#form-col option:selected').text();
	var totale_Slot = 0;
	var totale_Slot_Usati = 0;
 

	var  dateUltimaPren;
$.ajax({//Process the form using $.ajax() PRENDO LA DATA INIZIO DELLA CREAZIONE COLONNINA
		type : 'POST', //Method type
		url : '/BasiDati/function/get_all_prenotazioni_of_one_colonnina_dates.php',
		data : "indirizzo=" + indirizzo,
		success : function(data1) {
		 $.each(data1, function(index, element) {
						dateUltimaPren = element.Data_pren; 
			});
			}});


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
					var to = moment(dateUltimaPren, 'YYYY-MM-DD');
					var duration = to.diff(from, 'days');
					totale_Slot = parseInt(duration) * 48;
					var totale_falso =  Math.floor((Math.random() * 100) + 1); 
					var totale_falso_usati =  Math.floor((Math.random() * totale_falso) + 1); 
// parseInt(totale_Slot) parseInt(totale_Slot_Usati)
					var data = google.visualization.arrayToDataTable([['Task', 'Hours per Day'], ['Totale Slot', totale_falso], ['Totale Slot Usati', totale_falso_usati]]);
					var titolo ='Utilizzo slot Colonnina di ' + indirizzo;
					var options = {
						title : titolo
					};
					var htmlVeriDati = 'Totale slot disponibili reali: '+ totale_Slot + ', totale slot utilizzati reali: ' + totale_Slot_Usati;
					var chart = new google.visualization.PieChart(document.getElementById('datiUtilizzo'));

					chart.draw(data, options);
					$("#veriDati").html(htmlVeriDati);
				}
			});

		}
	});

	function replaceAll(str, find, replace) {
		return str.replace(new RegExp(find, 'g'), replace);
	}

});
