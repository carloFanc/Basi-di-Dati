<head>

	<link rel="stylesheet" href="/BasiDati/css/bootstrap-datetimepicker.min.css">

	<link rel="stylesheet" href="/BasiDati/css/nice-select.css">
	<style>
		.top-buffer {
			margin-top: 10px;
		}
		.top-buffer-more {
			margin-top: 30px;
		}

	</style>
</head>
<body>
	<h1 align="center">Prenota Colonnina di Ricarica</h1>
	<div class="container-fluid" style=" clear:both"  >

		<form role="form"  id="prenColonnina" onsubmit="return false">
			<div class="row top-buffer " >
				<div class="col-md-6">
					<h4>Indirizzo Colonnina:</h4>
				</div>

			</div>
			<div class="row top-buffer "   >
				<div class=" col-md-12"   >
					<div id="indirizzi"   ></div>
				</div>
			</div>
			<div class="row top-buffer "  >
				<div class="col-md-6">
					<h4>Giorno Prenotazione:</h4>
				</div>
			</div>
			<div class="row top-buffer " >
				<div class="input-group date col-md-6" id="datetimepicker" style="padding-left:15px; padding-right:15px" >

					<input type='text' class="form-control ">
					</input>
					<span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span>
				</div>
			</div>
			<div class="row top-buffer ">

				<div  id="slotDisponibiliInizio" class="col-md-6">

				</div>

				<div  id="slotDisponibiliFine" class="col-md-6">

				</div>
			</div>
			<div class="row top-buffer-more ">
				<div class="col-md-12" align="center">
					<button id="bottone" name="btn-invio" class="btn btn-primary" style="visibility: hidden">
						Invio
					</button>
				</div>
			</div>
		</form>
	</div>

	<script  src="/BasiDati/js/moment.js"></script>
	<script src="/BasiDati/js/bootstrap-datetimepicker.min.js"></script>
	<script src="/BasiDati/js/jquery.nice-select.js"></script>
		<script src="/BasiDati/js/prenColonnine.js"></script>

</body>
