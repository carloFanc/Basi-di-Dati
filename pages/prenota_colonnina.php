<?php

require_once("../session.php");

require_once("../class.user.php");
$auth_user = new USER();

$umail = $_SESSION['user_email'];

$stmt = $auth_user->runQuery('SELECT * FROM Colonnina_Elettrica;');
$stmt->execute();

?>
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
		<div style="text-align: center; clear:both"  >
			<form role="form"  id="prenColonnina" >
				<div class="form-group"style="clear:both">
					<label for="colonninaa" id="colonninaa">Numero Colonnina:</label>
					 <div id="indirizzi" style="width: 50%;"></div>
				</div> </br>
				 <div class='input-group date' id='datetimepicker' style="clear:both">
                    <input type='text' class="form-control " />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <div id="slotDisponibiliInizio">
                	
                </div>
                <div id="slotDisponibiliFine"></div>
				<button type="submit" id="bottone" name="btn-invio" class="btn btn-primary" style="visibility: hidden">
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