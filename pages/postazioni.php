<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	$tipo = $_SESSION['user_tipologia'];
	$stmt = $auth_user->runQuery('CALL VisualizzaPostazioni()');
	$stmt->execute();
	

?>
<head>
<link href="css/bootstrap-dialog.min.css" rel="stylesheet"> 
</head>
<body>
		<div >
			<h1 align="center">Postazioni Prelievo</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
				<?php if($tipo=="Amministratore"): ?>
				<div>
					<h4>Per cancellare una Postazione Prelievo  <button type="button" id="Cancella" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">CLICCA QUI</button></h4>
		 
				</div>
				<?php endif; ?>
            	<div>
  						           
  						<table class="table table-striped">
    					<thead class="personale">
      					<tr>
      					  <th>Indirizzo</th>
      					  <th>Numero Bici Disponibili</th>
      					  <th>Numero Bici Totali</th>
      					  <th>Latitudine</th>
      					  <th>Longitudine</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Indirizzo']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Bici_Disponibili']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Bici_Totale']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Latitudine']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Longitudine']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
     							 <?php $stmt->closeCursor(); $stmt2 = $auth_user->runQuery('SELECT Indirizzo FROM Postazione_Prelievo;'); $stmt2->execute();		?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
          <script type='text/javascript' language='javascript'>
$('#Cancella').click(function() {
				var $textAndPic = $('<div></div>');
			$textAndPic.append('<p>Scegli Postazione che vuoi cancellare:</p>  <div>  	<select name="form-pos" class="form-control" id="form-pos">	<?php while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC)): ?><option  value="<?php echo $userRow["Indirizzo"]; ?>"><?php echo $userRow["Indirizzo"]; ?></option><?php endwhile; ?>
					</select></div> </div>');
					BootstrapDialog.show({
					title: 'Cancella Postazione Prelievo',
					message : $textAndPic,
					buttons: [{
					label: 'Cancella',
					action: function(dialog) {
					var id=  $( "#form-pos option:selected" ).text();
					
					$.ajax({
					url : '/BasiDati/function/EliminaPostazione.php',
					type : 'POST',
					data : "Id=" + id
					}).done(function() {
					alert("Postazione Eliminata con successo!");
					dialog.close();
					cambiaContenuto('postazioni');
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