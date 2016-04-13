<?php
	
	   require_once(dirname(dirname(__FILE__)).'/session.php');
	   require_once(dirname(dirname(__FILE__)).'/class.user.php');
	   
	    $user = new USER();
		if(isset($_POST['btn-invio-messaggio'])){
		try
		{
		$mailm = $_SESSION['user_email'];
	    $maild = strip_tags($_POST['form-email']);
	    $text = strip_tags($_POST['form-txt']);
	    $data=date("Y-m-d H:i:s");
			//$stmt = $user->runQuery("SELECT Email FROM Utente WHERE Email=:umail");
			//$stmt->execute(array(':umail'=>$maild));
			//$row=$stmt->fetch(PDO::FETCH_ASSOC);
         // $user->Insertmsg($mailm,$maild,$text,$data);
			if($user->Insertmsg($mailm,$maild,$text,$data)){
					echo '<script type="text/javascript">alert("Messaggio inviato correttamente"); </script>';	
			}
				
		}
		catch(PDOException $e)
		{
			echo $e->getMessage('Error');
			echo '<script type="text/javascript">alert("Messaggio inviato asdasd"); </script>';
		}
		}
	?>