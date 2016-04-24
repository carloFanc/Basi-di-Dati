<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<title>Google Maps</title>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/get_distance.js"></script>
		<script type="text/javascript">
			window.initMap = function() {
				var bounds = new google.maps.LatLngBounds();
				var myLatlng = new google.maps.LatLng(41.8929, 12.4843);
				var myOptions = {
					zoom : 5,
					center : myLatlng,
					mapTypeId : google.maps.MapTypeId.ROADMAP
				}
				var distanzaUtente;
				var latitudineUtente;
				var longitudineUtente;
				var flag = false;
				var origine;
				var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
				$.ajaxSetup({
					cache : false
				})
				$.get('function/sessionToAjaxDistanza.php', function(data) {
					distanzaUtente = data.replace(/\"/g, "");
				}).done(function() {

					$.ajaxSetup({
						cache : false
					});
					$.get('function/sessionToAjax.php', {
						requested : 'origine'
					}, function(data) {
						origine = data.replace(/\"/g, "");
					});

					$.ajaxSetup({
						cache : false
					})
					$.get('function/sessionToAjaxLat.php', function(data) {
						latitudineUtente = data.replace(/\"/g, "");
					}).done(function() {
						$.ajaxSetup({
							cache : false
						})
						$.get('function/sessionToAjaxLong.php', function(data) {
							longitudineUtente = data.replace(/\"/g, "");
						}).done(function() {
							switch(origine) {
							case "getDistanceLatLongBici":
							$('#titolo').html("<h1>Visualizza Postazioni Prelievo disponibili</h1>");
							$.ajax({
								url : 'function/get_postazioni.php',
								success : function(data) {
									//oop through each location.
									$.each(data, function() {
										var marker;
										var contenuto = '<p><b>' + this.Indirizzo + '</p></b><br>' + 'Numero Bici Totali: ' + this.Numero_Bici_Totale + '<br>' + 'Numero Bici Disponibili: ' + this.Numero_Bici_Disponibili + '<br>';
										var infowindow = new google.maps.InfoWindow({
											content : contenuto
										});
										//Plot the location as a marker

										var pos = new google.maps.LatLng(this.Latitudine, this.Longitudine);

										var titolo = this.Indirizzo;
										if (getDistanceFromLatLonInKm(latitudineUtente, longitudineUtente, this.Latitudine, this.Longitudine, distanzaUtente)) {

											marker = new google.maps.Marker({
												position : pos,
												map : map,
												title : titolo
											});
											bounds.extend(pos);
											marker.addListener('click', function() {
												infowindow.open(map, marker);
											});
											flag = true;
										}
									});
									if (flag) {
										map.fitBounds(bounds);
									} else {
										map.setCenter(new google.maps.LatLng(41.8929, 12.4843));
										map.setZoom(5);
										alert("Nessuna posizione trovata");
									}
								}
							});



							break;
							
							
							 case "getDistanceLatLongPisteCiclabili":
							$('#titolo').html("<h1>Visualizza Piste Ciclabili disponibili</h1>");
							$.ajax({
								url : 'function/get_piste_ciclabili.php',
								success : function(data) {
									//oop through each location.
									$.each(data, function() {
										var marker;
										var contenuto = '<p><b>' + this.Indirizzo + '</p></b><br>' + 'Numero Bici Totali: ' + this.Numero_Bici_Totale + '<br>' + 'Numero Bici Disponibili: ' + this.Numero_Bici_Disponibili + '<br>';
										var infowindow = new google.maps.InfoWindow({
											content : contenuto
										});
										//Plot the location as a marker

										var pos = new google.maps.LatLng(this.Latitudine, this.Longitudine);

										var titolo = this.Indirizzo;
										if (getDistanceFromLatLonInKm(latitudineUtente, longitudineUtente, this.Latitudine, this.Longitudine, distanzaUtente)) {

											marker = new google.maps.Marker({
												position : pos,
												map : map,
												title : titolo
											});
											bounds.extend(pos);
											marker.addListener('click', function() {
												infowindow.open(map, marker);
											});
											flag = true;
										}
									});
									if (flag) {
										map.fitBounds(bounds);
									} else {
										map.setCenter(new google.maps.LatLng(41.8929, 12.4843));
										map.setZoom(5);
										alert("Nessuna posizione trovata");
									}
								}
							});
							break;
							
							case "getDistanceLatLongPuntiNoleggio":
							$('#titolo').html("<h1>Visualizza Punti Noleggio disponibili</h1>");
							$.ajax({
								url : 'function/get_punti_noleggio.php',
								success : function(data) {
									//oop through each location.
									$.each(data, function() {
										var marker;
										var contenuto = '<p><b>' + this.Indirizzo + '</p></b><br>' + 'Numero Bici Totali: ' + this.Numero_Bici_Totale + '<br>' + 'Numero Bici Disponibili: ' + this.Numero_Bici_Disponibili + '<br>';
										var infowindow = new google.maps.InfoWindow({
											content : contenuto
										});
										//Plot the location as a marker

										var pos = new google.maps.LatLng(this.Latitudine, this.Longitudine);

										var titolo = this.Indirizzo;
										if (getDistanceFromLatLonInKm(latitudineUtente, longitudineUtente, this.Latitudine, this.Longitudine, distanzaUtente)) {

											marker = new google.maps.Marker({
												position : pos,
												map : map,
												title : titolo
											});
											bounds.extend(pos);
											marker.addListener('click', function() {
												infowindow.open(map, marker);
											});
											flag = true;
										}
									});
									if (flag) {
										map.fitBounds(bounds);
									} else {
										map.setCenter(new google.maps.LatLng(41.8929, 12.4843));
										map.setZoom(5);
										alert("Nessuna posizione trovata");
									}
								}
							});
							break;
							
							case "getDistanceLatLongColonnine":
							$('#titolo').html("<h1>Visualizza Colonnine disponibili</h1>");
							$.ajax({
								url : 'function/get_colonnine.php',
								success : function(data) {
									//oop through each location.
									$.each(data, function() {
										var marker;
										var contenuto = '<p><b>' + this.Indirizzo + '</p></b><br>' + 'Numero Bici Totali: ' + this.Numero_Bici_Totale + '<br>' + 'Numero Bici Disponibili: ' + this.Numero_Bici_Disponibili + '<br>';
										var infowindow = new google.maps.InfoWindow({
											content : contenuto
										});
										//Plot the location as a marker

										var pos = new google.maps.LatLng(this.Latitudine, this.Longitudine);

										var titolo = this.Indirizzo;
										if (getDistanceFromLatLonInKm(latitudineUtente, longitudineUtente, this.Latitudine, this.Longitudine, distanzaUtente)) {

											marker = new google.maps.Marker({
												position : pos,
												map : map,
												title : titolo
											});
											bounds.extend(pos);
											marker.addListener('click', function() {
												infowindow.open(map, marker);
											});
											flag = true;
										}
									});
									if (flag) {
										map.fitBounds(bounds);
									} else {
										map.setCenter(new google.maps.LatLng(41.8929, 12.4843));
										map.setZoom(5);
										alert("Nessuna posizione trovata");
									}
								}
							});
							break;
							 
							}

							
						});

					});
				});

			}
		</script>
	</head>

	<body>
		<div id="titolo"></div>
		<div id="map_canvas" style="width:900px; height:500px"></div>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8bBvuhva38_N5T8ZZb2JetjgBITIKrwI&callback=initMap&v=3"  type="text/javascript"></script>
	</body>
</html>