<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('SELECT * FROM Veicolo_elettrico;');
	$stmt->execute();
	

?>
<body>
		<div >
			<h1 align="center">Veicoli</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div>
  						           
  						<table class="table table-striped ">
    					<thead class="personale">
      					<tr>
      					  <th>Targa</th>
      					  <th>Punto Noleggio</th>
      					  <th>Tipologia</th>
      					  <th>Nome Modello</th>
      					  <th>Colore</th>
      					  <th>Costo orario</th>
      					  <th>Cilindrata</th>
      					  <th>Autonomia km</th>
      					  <th>Max Passeggeri</th>
      					  <th>Chilometraggio Attuale</th>
      					  <th>Foto</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Targa']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Punto_Noleggio']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Tipologia']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Nome_Modello']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Colore']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Costo_orario']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Cilindrata']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Autonomia_km']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Max_Passeggeri']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Chilometraggio_Attuale']; ?></td>
     						      <td><img src="/uploads/jpg;base64,<?php echo base64_encode($userRow['Foto']); ?>" /></td>
     						      
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
</body>