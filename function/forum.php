<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaForum()');
	$stmt->execute();
	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Inbox</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
	</head>

	<body>
		<div >
			<h1>Messaggi Forum</h1> 
			
            <?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
            	<div class="container">
  						           
  						<table class="table table-striped table-bordered table-hover table-condensed">
    					<thead>
      					<tr>
      					  <th>Email Mittente</th>
      					  <th>Titolo</th>
      					  <th>Testo Messaggio</th>
      					  <th>Data Inserimento</th>
     					 </tr>
    					</thead>
    						<tbody>
     							 <tr>
     							   <td align="left" class="col-md-3"><?php echo $userRow['EmailUtente']; ?></td>
      								  <td align="left" class="col-md-3"><?php echo $userRow['Titolo']; ?></td>
      							      <td align="left" class="col-md-3"><?php echo $userRow['Testo_Messaggio']; ?></td>
       								  <td align="left" class="col-md-3"><?php echo $userRow['Data_Inserimento']; ?></td>
      							 </tr>
                            </tbody>
                        </table>
                </div>
             <?php endwhile; ?>
          </div>
     </body>
</html>