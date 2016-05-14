<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user -> runQuery('SELECT Targa FROM Veicolo_elettrico');
$stmt -> execute();
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
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/s/css/bootstrap-combined.min.css" rel="stylesheet">

		<link rel="stylesheet" href="/BasiDati/css/bootstrap-datetimepicker.min.css">
	</head>

	<body>
		 <div>
			<h1 align="center">Prenotazione Veicoli</h1>
			
			
			<form role="form"  id="PrenVeicolo" >
				<div class="form-group">
					<label for="targa">Targa Veicolo:</label>
					<select name="form-targa" class="form-control" id="form-targa">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["Targa"] ?>"><?php echo $userRow["Targa"] ?></option>
					<?php endwhile; ?>
					</select>	
				</div>
				<div id="datetimepicker" class="input-append date">
					<label for="date1">Data Inizio:</label>
					<input name="form-date1" data-format="yyyy-MM-dd hh:mm:ss" type="text" id="form-date1"> </input>
					<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"> </i> </span>
				</div>
				<div id="datetimepicker2" class="input-append date" class="form-group">
					<label for="date1">Data Fine:</label>
					<input name="form-date2" data-format="yyyy-MM-dd hh:mm:ss" type="text" id="form-date2"> </input>
					<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"> </i> </span>
				</div>
				<button type="submit" name="btn-invio" class="btn btn-primary">
					Invio
				</button>
			</form>
		</div>
		<script src="/BasiDati/js/jquery-1.11.1.min.js"></script>
		<script src="/BasiDati/js/bootstrap.min.js"></script>			
		<script src="/BasiDati/js/jquery-ui.js"></script>
		<script src="/BasiDati/js/prenVeicoli.js"></script>
		<script  src="/BasiDati/js/moment.js"></script>
		<script src="/BasiDati/js/bootstrap-datetimepicker.min.js"></script>
	</body>
	</html>