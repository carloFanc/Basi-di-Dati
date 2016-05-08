<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM Utente WHERE Email=:umail");
	$stmt->execute(array(":umail"=>$umail));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>

	<head>
		
		<title>profilo</title>
		
		
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

