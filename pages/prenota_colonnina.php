
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Prenotazioni Veicoli</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="stylesheet" href="/BasiDati/css/bootstrap-datetimepicker.min.css"> 
		<link rel="stylesheet" href="/BasiDati/css/bootstrap.min.css"> 
		<link rel="stylesheet" href="/BasiDati/css/nice-select.css">
		
	</head>
	<body>
		<div style=" clear:both"  >
			<h1>Prenota Colonnina di Ricarica</h1>
			<form role="form"  id="prenColonnina" >
				<h4>Indirizzo Colonnina:</h4>
				<div class="form-group"style="clear:both">
					 <div id="indirizzi" style="width: 50%;"></div>
				</div> 
				
				
					
				 <div class="input-group date" id="datetimepicker" style="clear:both">
				 	<h4>Giorno Prenotazione:</h4>
				 	
                    <input type='text' class="form-control "></input>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                
                
                <div  id="slotDisponibiliInizio">
                	
                </div>
                
                <div  id="slotDisponibiliFine">
                	
                	
                </div>
				
				<butt-on type="submit" id="bottone" name="btn-invio" class="btn btn-primary" style="visibility: hidden">
					Invio
				</button>
			
			</form>
		</div>
	<script type='text/javascript' language='javascript'>

</script>
        <script  src="/BasiDati/js/moment.js"></script>
		<script src="/BasiDati/js/bootstrap-datetimepicker.min.js"></script>
	    <script src="/BasiDati/js/prenColonnine.js"></script> 
	    <script src="/BasiDati/js/jquery.nice-select.js"></script>
	</body>
</html>