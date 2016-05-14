<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaPuntiNoleggio()');
	$stmt->execute();
	

?>
<body>
		<div >
			<h1 align="center">Punti Noleggio</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div>
  						           
  						<table class="table table-striped">
    					<thead class="personale">
      					<tr>
      					  <th>Nome</th>
      					  <th>Numero Scooter</th>
      					  <th>Numero Auto</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Nome']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Scooter']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Auto']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
</body>
