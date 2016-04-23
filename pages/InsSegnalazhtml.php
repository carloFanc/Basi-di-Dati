<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user -> runQuery('SELECT id FROM Pista_Ciclabile');
$stmt -> execute();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Inserimento Segnalazione</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<link rel="stylesheet" href="/BasiDati/fonts/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="/BasiDati/css/form-elementsLogin.css">
		<link rel="stylesheet" href="/BasiDati/css/styleLogin.css">
	</head>

	<body>
		 <div>
			<h1>Inserimento Segnalazione</h1>
			
			
			<form role="form"  id="InsSegn" >
				<div class="form-group">
					<label for="bici">Piste Ciclabili:</label>
					<select name="form-piste" class="form-control" id="form-piste">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["id"] ?>"><?php echo $userRow["id"] ?></option>
					<?php endwhile; ?>
					</select>	
				</div>
				<div class="form-group">
					<label for="text">Titolo:</label>
					<input name="form-titolo" type="text" class="form-control" id="form-titolo">

				</div>
				<div class="form-group">
					<label for="text">Testo Messaggio:</label>
					<input name="form-testo" type="text" class="form-control" id="form-testo">

				</div>
				<button type="submit" name="btn-invio" class="btn btn-default">
					Invio
				</button>
			</form>
		</div>
		<script src="/BasiDati/js/jquery-1.11.1.min.js"></script>
		<script src="/BasiDati/js/bootstrap.min.js"></script>			
		<script src="/BasiDati/js/jquery-ui.js"></script>
		<script src="/BasiDati/js/InsSegnalaz.js"></script>
		
	</body>
	</html>