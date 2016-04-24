<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaPisteCiclabili()');
	$stmt->execute();
	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Piste Ciclabili</title>
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
			<h1>Piste Ciclabili</h1> 
			<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
            	<div class="container">
  						           
  						<table class="table table-striped table-bordered">
    					<thead class="personale">
      					<tr>
      					  <th>Id</th>
      					  <th>Chilometri</th>
      					  <th>Pendenza Media</th>
      					  <th>Latitudine</th>
      					  <th>Longitudine</th>
     					 </tr>
    					</thead>
  		  						<tbody>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Id']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Chilometri']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Pendenza_Media']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Latitudine']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Longitudine']; ?></td>
     							 </tr>
      						  </tbody>
  						</table>
			   </div>
            <?php endwhile; ?>
          </div>
</body>
</html>
