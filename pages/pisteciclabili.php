<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	$tipo = $_SESSION['user_tipologia'];
	$stmt = $auth_user->runQuery('CALL VisualizzaPisteCiclabili()');
	$stmt->execute();
	

?>
<head>
<link href="css/bootstrap-dialog.min.css" rel="stylesheet"> 
</head>
	<body>
		<div >
			<h1 align="center">Piste Ciclabili</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
				<?php if($tipo=="Amministratore"): ?>
				<div>
					<h4>Per cancellare una Pista Ciclabile  <button type="button" id="Cancella" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">CLICCA QUI</button></h4>
		 
				</div>
				<?php endif;?>
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
     							 <?php $stmt->closeCursor(); $stmt2 = $auth_user->runQuery('SELECT Id FROM Pista_Ciclabile;'); $stmt2->execute();		?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
          <script type='text/javascript' language='javascript'>
$('#Cancella').click(function() {
				var $textAndPic = $('<div></div>');
			$textAndPic.append('<p>Scegli Pista che vuoi cancellare:</p>  <div>  	<select name="form-pis" class="form-control" id="form-pis">	<?php while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC)): ?><option  value="<?php echo $userRow["Id"]; ?>"><?php echo $userRow["Id"]; ?></option><?php endwhile; ?>
					</select></div> </div>');
					BootstrapDialog.show({
					title: 'Cancella Pista',
					message : $textAndPic,
					buttons: [{
					label: 'Cancella',
					action: function(dialog) {
					var id=  $( "#form-pis option:selected" ).text();
					
					$.ajax({
					url : '/BasiDati/function/EliminaPista.php',
					type : 'POST',
					data : "Id=" + id
					}).done(function() {
					alert("Pista Eliminata con successo!");
					dialog.close();
					cambiaContenuto('pisteciclabili');
					});
					}
					}, {
					label: 'Chiudi',
					action: function(dialog) {
					dialog.close();
					}
					}]
					});
					});
</script>
<script src="js/bootstrap-dialog.min.js"></script>
</body>
