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