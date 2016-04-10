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
		<?php

		require_once("session.php");
	
		require_once("class.user.php");
		$auth_user = new USER();
	
	
		$umail = $_SESSION['user_session'];
	
		$stmt = $auth_user->runQuery("SELECT * FROM Utente WHERE Email=:umail");
		$stmt->execute(array(":umail"=>$umail));
	
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		

?>

</body>
</html>
