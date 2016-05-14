<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	$tipo = $_SESSION['user_tipologia'];
	
	if($tipo=="Amministratore"){
		$stmt = $auth_user->runQuery('CALL VisualizzaPrenotazioniTotaliinCorso()');
		$stmt->execute();
	}
	else{
	$stmt = $auth_user->runQuery('CALL VisualizzaPrenotazioninCorso(:umail)');
	$stmt->execute(array(":umail"=>$umail));
	}

?>

	<body>
		<div >
			<h1 align="center">Prenotazioni in Corso</h1> 
			
			<?php if ($stmt->rowCount()!=0): ?>
                <h2>Prenotazioni Bici</h2>
            	<div >
  						           
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
			   <?php endif; ?>
            <?php $stmt->nextRowset();?>
            
                <?php if ($stmt->rowCount()!=0): ?>
                <h2>Prenotazioni Veicoli</h2>
            	<div >
  						           
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
			   <?php endif; ?>
            
          <?php if ($tipo == 'Premium' || $tipo== 'Amministratore'): ?>
           <?php $stmt->nextRowset();?>
          
            	<?php if ($stmt->rowCount()!=0): ?>
                <h2>Prenotazioni Colonnine</h2>
            	<div>
  						           
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
			   <?php endif; ?>
            
            <?php endif; ?>
            
          </div>
</body>