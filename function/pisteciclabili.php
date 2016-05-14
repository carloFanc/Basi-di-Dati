<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaPisteCiclabili()');
	$stmt->execute();
	

?>
	<body>
		<div >
			<h1 align="center">Piste Ciclabili</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div >
  						           
  						<table class="table table-striped ">
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
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Id']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Chilometri']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Pendenza_Media']; ?></td>
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
