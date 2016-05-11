<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL ClassificaPrenVeicoli()');
	$stmt->execute();
	

?>
<body>
		<div >
			<h1>Classifica in base alle prenotazioni Veicoli</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div>
  						           
  						<table class="table table-striped table-hover table-condensed">
    					<thead class="personale">   
      					<tr>
      					  <th>Email Utente</th>
      					  <th>Numero Prenotazioni Veicoli</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['EmailUtente']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Prenotazioni_Veicoli']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
</body>
