<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL ClassificaPrenBici()');
	$stmt->execute();
	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Classifica Prenotazioni Bici</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
	</head>

	<body>
		<div >
			<h1>Classifica in base alle prenotazioni Bici</h1> 
			<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
            	<div class="container">
  						           
  						<table class="table table-bordered">
    					<thead>
      					<tr>
      					  <th>Email Utente</th>
      					  <th>Numero_Prenotazioni_Bici</th>
     					 </tr>
    					</thead>
  		  						<tbody>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['EmailUtente']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Prenotazioni_Bici']; ?></td>
     							 </tr>
      						  </tbody>
  						</table>
			   </div>
            <?php endwhile; ?>
          </div>
</body>
</html>
