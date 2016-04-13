<?php
	
	//require_once('../session.php');
	   require_once(dirname(dirname(__FILE__)).'/class.user.php');
	   $user = new USER();
	  $stmt =  $user->runQuery('INSERT INTO Messaggio_Personale(Email_Mittente,Email_Destinatario,Testo_Messaggio,DataInvio) VALUES (\'pippo@gmail.com\',\'carlo@gmail.com\',\'ciao ciao come va?\',\'2016-06-24 03:44:22\');');
	  $stmt ->execute();	
		if(isset($_POST['btn-invio-messaggio'])){
	    $mailm = $_SESSION['user_email'];
	    $maild = strip_tags($_POST['form-email']);
	    $text = strip_tags($_POST['form-txt']);
	    $data=date("Y-m-d H:i:s");
		try
		{
			//$stmt = $user->runQuery("SELECT Email FROM Utente WHERE Email=:umail");
			//$stmt->execute(array(':umail'=>$maild));
			//$row=$stmt->fetch(PDO::FETCH_ASSOC);
         // $user->Insertmsg($mailm,$maild,$text,$data);
			
					echo '<script type="text/javascript">alert("Messaggio inviato correttamente"); </script>';	
				
		}
		catch(PDOException $e)
		{
			echo $e->getMessage('Error');
			echo '<script type="text/javascript">alert("Messaggio inviato asdasd"); </script>';
		}
		}
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Invio Messaggio Personale</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="../BasiDati/css/bootstrap.min.css">
        <link rel="stylesheet" href="../BasiDati/fonts/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../BasiDati/css/form-elementsLogin.css">
        <link rel="stylesheet" href="../BasiDati/css/styleLogin.css">
       <link rel="stylesheet" href="../BasiDati/css/jquery-ui.css">
		
	</head>

	<body>
		<div >
			<h1>Invia Messaggio Personale</h1> 
			
			 <form role="form" action="" method="post">
				<div class="form-group">
					<label for="email">Indirizzo Email:</label>
					<input name="form-email" type="email" class="form-control" id="form-email">
				</div>
				<div class="form-group">
					<label for="text">Testo Messaggio:</label>
					<input name="form-txt" type="text" class="form-control" id="form-text">
				</div>
				<button type="submit" name="btn-invio-messaggio" class="btn btn-default">
					Invio
				</button>
			</form>

			</div>
			<script src="../BasiDati/js/jquery-1.11.1.min.js"></script>
         <script src="../BasiDati/js/jquery-ui.js"></script>
        <script src="../BasiDati/js/bootstrap.min.js"></script>
</body>
</html>
