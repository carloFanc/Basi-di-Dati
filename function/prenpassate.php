<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	$tipo = $_SESSION['user_tipologia'];
	$stmt = $auth_user->runQuery('CALL VisualizzaPrenotazioniPassate(:umail)');
	$stmt->execute(array(":umail"=>$umail));
	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Prenotazioni Passate</title>
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
			<h1>Prenotazioni Passate</h1> 
			<h2>Prenotazioni Bici</h2>
			<?php if ($stmt->rowCount()!=0): ?>
            	<div class="container">
  						            
  						<table class="table table-striped">
    					<thead class="personale">
      					<tr>
      					  <th>Id</th>
      					  <th>Email</th>
      					  <th>Id Bici</th>
      					  <th>Data Inizio</th>
      					  <th>Data Fine</th>
     					 </tr>
    					</thead>
  		  						
      						  <tbody>
      						  	<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td align="left" class="col-md-3"><?php echo $userRow['Id']; ?></td>
     						      <td align="left" class="col-md-3"><?php echo $userRow['EmailUtente']; ?></td>
     						      <td align="left" class="col-md-3"><?php echo $userRow['IdBici']; ?></td>
        						  <td align="left" class="col-md-3"><?php echo $userRow['Data_Inizio']; ?></td>
     							  <td align="left" class="col-md-3"><?php echo $userRow['Data_Fine']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
			   <? else: ?>
			   <div>
			   	<h2>No Result</h2>
			   </div>
			   <?php endif; ?>
            <?php $stmt->nextRowset();?>
            <h2>Prenotazioni Veicoli</h2> 
            <?php if ($stmt->rowCount()!=0): ?>
            	<div class="container">
  						          
  						<table class="table table-striped table-hover table-condensed">
    					<thead>
      					<tr>
      					  <th>Id</th>
      					  <th>Email</th>
      					  <th>Veicolo</th>
      					  <th>Prezzo Prenotazione</th>
      					  <th>Data Inizio</th>
      					  <th>Data Fine</th>
     					 </tr>
    					</thead>
  		  						
      						  <tbody>
      						  	<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td align="left" class="col-md-3"><?php echo $userRow['Id']; ?></td>
     						      <td align="left" class="col-md-3"><?php echo $userRow['EmailUtente']; ?></td>
        						  <td align="left" class="col-md-3"><?php echo $userRow['Veicolo']; ?></td>
     							  <td align="left" class="col-md-3"><?php echo $userRow['Prezzo_Prenotazione']; ?></td>
     							  <td align="left" class="col-md-3"><?php echo $userRow['Data_Inizio']; ?></td>
     							  <td align="left" class="col-md-3"><?php echo $userRow['Data_Fine']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
			    <? else: ?>
			   <div>
			   	<h2>No Result</h2>
			   </div>
            <?php endif; ?>
          
          <?php if ($tipo == 'Premium' || $tipo== 'Amministratore'): ?>
           <?php $stmt->nextRowset();?>
          <h2>Prenotazioni Colonnina</h2> 
            <?php if ($stmt->rowCount()!=0): ?>
            	<div class="container">
  						          
  						<table class="table table-striped table-hover table-condensed">
    					<thead>
      					<tr>
      					  <th>Id</th>
      					  <th>Email</th>
      					  <th>Indirizzo</th>
      					  <th>Slot Inizio</th>
      					  <th>Slot Fine</th>
      					  <th>Data Prenotazione</th>
     					 </tr>
    					</thead>
  		  						
      						  <tbody>
      						  	<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td align="left" class="col-md-3"><?php echo $userRow['Id']; ?></td>
     						      <td align="left" class="col-md-3"><?php echo $userRow['EmailUtente']; ?></td>
        						  <td align="left" class="col-md-3"><?php echo $userRow['Indirizzo']; ?></td>
     							  <td align="left" class="col-md-3"><?php echo $userRow['Slot_Inizio']; ?></td>
     							  <td align="left" class="col-md-3"><?php echo $userRow['Slot_Fine']; ?></td>
     							  <td align="left" class="col-md-3"><?php echo $userRow['Data_pren']; ?></td>
     							 </tr>
     							 <?php endwhile; ?> 
      						  </tbody>
  						</table>
			   </div>
			    <?php else: ?>
			   <div>
			   	<h2>No Result</h2>
			   </div>
            <?php endif; ?>
          <?php endif; ?>
          </div>
</body>
</html>
