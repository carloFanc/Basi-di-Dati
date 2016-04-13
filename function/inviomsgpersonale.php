<?php
	
	//require_once('../session.php');
	require_once('../class.user.php');
	  //  $user = new USER();
		if(isset($_POST['btn-invio']))
		{
	    $mailm = $_SESSION['user_email'];
	    $maild = strip_tags($_POST['form-email']);
	    $text = strip_tags($_POST['form-txt']);
	    $data=date("Y-m-d H:i:s");
		try
		{
			//$stmt = $user->runQuery("SELECT Email FROM Utente WHERE Email=:umail");
			//$stmt->execute(array(':umail'=>$maild));
			//$row=$stmt->fetch(PDO::FETCH_ASSOC);

				if($user->Insertmsg($mailm,$maild,$text,$data)){
					echo '<script type="text/javascript">alert("Messaggio inviato correttamente");
					window.location = \'index.php\'</script>';	
				}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage('Error');
		}
		}
		// /*try
		// {
		// /*$stmt = $auth_user->runQuery("SELECT Email FROM Utente WHERE Email=:umail");
		// $stmt->execute(array(':umail' =>$maild));
		// $row=$stmt->fetch(PDO::FETCH_ASSOC);*/
// 
		// //if($row['Email']==$maild) {
			// //$stmt = $auth_user->runQuery("INSERT INTO Messaggio_Personale(Email_Mittente,Email_Destinatario,Testo_Messaggio,DataInvio) VALUES (:mailm,:maild,:text,:data)");
			// //$stmt -> execute(array(':mailm'=>$mailm,':maild'=>$maild,':text'=>$text,':data'=>$data));
			// $stmt =$thi->runQuery("INSERT INTO Messaggio_Personale(Email_Mittente,Email_Destinatario,Testo_Messaggio,DataInvio) VALUES (:mailm,:maild,:text,:data)");
				// /*	$stmt -> bindParam(":mailm", $mailm);
					// $stmt -> bindParam(":maild", $maild);
					// $stmt -> bindParam(":text", $text);
					// $stmt -> bindParam(":data", $data);
					// $stmt->execute();*/
			// $stmt -> execute(array(':mailm'=>$mailm,':maild'=>$maild,':text'=>$text,':data'=>$data));
					// echo '<script type="text/javascript">alert("Messaggio inviato correttamente");
					// window.location = \'index.php\'</script>';
// 						
		// /*else
				// {
			// echo ' <script type="text/javascript"> alert("email inesistente"); window.location = \'inviomsgpersonale.php\'</script>';	}*/
		// }
		// catch(PDOException $e)
		// {
		// echo $e->getMessage('Error');
		// }
		// }
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
				<button type="submit" name="btn-invio" class="btn btn-default">
					Invio
				</button>
			</form>

			</div>
</body>
</html>
