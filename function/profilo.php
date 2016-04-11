<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM Utente WHERE Email=:umail");
	$stmt->execute(array(":umail"=>$umail));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>profilo</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
	</head>

	<body>
		<div >
			<h1>Dati Profilo</h1>
			
		 <div class="list-group">
  			<a  class="list-group-item"><b>Nome: </b><?php echo $userRow['Nome']; ?></a>
  			<a  class="list-group-item"><b>Cognome: </b><?php echo $userRow['Cognome']; ?></a>
  			<a  class="list-group-item"><b>Password: </b><?php echo $userRow['password']; ?></a>
  			<a  class="list-group-item"><b>Tipologia: </b><?php echo $userRow['Tipologia']; ?></a>
  			<a  class="list-group-item"><b>Data Nascita: </b><?php echo $userRow['Data_Nascita']; ?></a>
  			<a  class="list-group-item"><b>Luogo Nascita: </b><?php echo $userRow['Luogo_Nascita']; ?></a>
  			<a  class="list-group-item"><b>Indirizzo Residenza: </b><?php echo $userRow['Indirizzo_Residenza']; ?></a>
  			<a  class="list-group-item"><b>Telefono: </b><?php echo $userRow['Telefono']; ?></a>
		 </div>
		 </div>
</body>
</html>
