<?php
	require_once("../session.php");
	require_once("../class.user.php");
	$auth_user = new USER();
	$umail = $_SESSION['user_email'];
    $tipo = $_SESSION['user_tipologia'];
	$stmt = $auth_user->runQuery('CALL VisualizzaColonnine();');
	$stmt->execute();
   
	

?>
<head>
<link href="css/bootstrap-dialog.min.css" rel="stylesheet"> 
</head>
<body>
		<div >
			<h1 align="center">Colonnine</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
				<?php if($tipo=="Amministratore"): ?>
				<div>
					<h4>Per cancellare una Colonnina Elettrica  <button type="button" id="Cancella" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">CLICCA QUI</button></h4>
				</div><?php else:?> <div id="Cancella"></div>
				<?php endif;?>
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
     						<?php $stmt->closeCursor(); $stmt2 = $auth_user->runQuery('SELECT Indirizzo FROM Colonnina_Elettrica;'); $stmt2->execute();		?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
          <script type='text/javascript' language='javascript'>
$('#Cancella').click(function() {
				var $textAndPic = $('<div></div>');
			$textAndPic.append('<p>Scegli Colonnina che vuoi cancellare:</p>  <div>  	<select name="form-col" class="form-control" id="form-col">	<?php while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC)): ?><option  value="<?php echo $userRow["Indirizzo"]; ?>"><?php echo $userRow["Indirizzo"]; ?></option><?php endwhile; ?>
					</select></div> </div>');
					BootstrapDialog.show({
					title: 'Cancella Colonnina',
					message : $textAndPic,
					buttons: [{
					label: 'Cancella',
					action: function(dialog) {
					var id=  $( "#form-col option:selected" ).text();
					
					$.ajax({
					url : '/BasiDati/function/EliminaCol.php',
					type : 'POST',
					data : "Id=" + id
					}).done(function() {
					alert("Colonnina Eliminata con successo!");
					dialog.close();
					cambiaContenuto('viscolonnine');
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
</body>
