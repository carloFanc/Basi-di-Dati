<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaPostazioni()');
	$stmt->execute();
	

?>
<body>
		<div >
			<h1 align="center">Postazioni Prelievo</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div>
  						           
  						<table class="table table-striped">
    					<thead class="personale">
      					<tr>
      					  <th>Indirizzo</th>
      					  <th>Numero Bici Disponibili</th>
      					  <th>Numero Bici Totali</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Indirizzo']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Bici_Disponibili']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Bici_Totale']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
</body>