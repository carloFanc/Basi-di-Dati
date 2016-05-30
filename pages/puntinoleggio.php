<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	$tipo = $_SESSION['user_tipologia'];
	$stmt = $auth_user->runQuery('CALL VisualizzaPuntiNoleggio()');
	$stmt->execute();
	

?>
<head>
<link href="css/bootstrap-dialog.min.css" rel="stylesheet"> 
</head>
<body>
		<div >
			<h1 align="center">Punti Noleggio</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
				<?php if($tipo=="Amministratore"): ?>
				<div>
					<h4>Per cancellare un Punto Noleggio  <button type="button" id="Cancella" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">CLICCA QUI</button></h4>
		 
				</div>
				<?php endif;?>
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
     							 <?php $stmt->closeCursor(); $stmt2 = $auth_user->runQuery('SELECT Nome FROM Punto_Noleggio;'); $stmt2->execute();		?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
          <script type='text/javascript' language='javascript'>
$('#Cancella').click(function() {
				var $textAndPic = $('<div></div>');
			$textAndPic.append('<p>Scegli Punto Noleggio che vuoi cancellare:</p>  <div>  	<select name="form-nol" class="form-control" id="form-nol">	<?php while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC)): ?><option  value="<?php echo $userRow["Nome"]; ?>"><?php echo $userRow["Nome"]; ?></option><?php endwhile; ?>
					</select></div> </div>');
					BootstrapDialog.show({
					title: 'Cancella Punto Noleggio',
					message : $textAndPic,
					buttons: [{
					label: 'Cancella',
					action: function(dialog) {
					var id=  $( "#form-nol option:selected" ).text();
					
					$.ajax({
					url : '/BasiDati/function/EliminaPuntoNoleggio.php',
					type : 'POST',
					data : "Id=" + id
					}).done(function() {
					alert("Punto Noleggio Eliminato con successo!");
					dialog.close();
					cambiaContenuto('puntinoleggio');
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
