<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaColonnine();');
	$stmt->execute();
	

?>
<body>
		<div >
			<h1>Colonnine</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div>
  						           
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
