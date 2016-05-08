<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaColonnine();');
	$stmt->execute();
	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Visualizza Colonnine</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<style type="text/css">
			DIV.container {
				width: inherit;
				text-align: center;
			}
			table, thead, tr, tbody, th, td {
				text-align: center;
			}

			.table td {
				text-align: center;
			}
		</style>
	</head>

	<body>
		<div >
			<h1>Colonnine</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div class="container">
  						           
  						<table class="table table-striped">
    					<thead class="personale">
      					<tr>
      					  <th>Indirizzo</th>
      					  <th>Ente Fornitore</th>
      					  <th>Max KWH</th>
      					  <th>Data Inserimento</th>
      					  <th>Latitudine</th>
     					  <th>Longitudine</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Indirizzo']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Ente_Fornitore']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Max_KWH']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Data_Inserimento']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Latitudine']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Longitudine']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
</body>
</html>
