<?php
require_once ("../session.php");

require_once ("../class.user.php");
$auth_user = new USER();

$umail = $_SESSION['user_email'];
$tipo = $_SESSION['user_tipologia'];
$stmt = $auth_user -> runQuery('SELECT * FROM Bici;');
$stmt -> execute();
$stmt2 = $auth_user -> runQuery('SELECT Id FROM Bici;');
$stmt2 -> execute();
?>
<head><link href="css/bootstrap-dialog.min.css" rel="stylesheet"> </head>
<body>
		<div >
			<h1 align="center">Bici</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
				<?php if($tipo=="Amministratore"): ?>
				<div>
					<h4>Per cancellare una Bici  <button type="button" id="Cancella" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">CLICCA QUI</button></h4>
				</div>
				<?php endif;  ?>
				
            	<div>
  						           
  						<table class="table table-striped ">
    					<thead class="personale">
      					<tr>
      					  <th>Id</th>
      					  <th>Postazione Prelievo</th>
      					  <th>Marca</th>
      					  <th>Colore</th>
      					  <th>Anno Acquisizione</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr >
      							  <td class="col-md-3"><?php echo $userRow['Id']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Postazione_Prelievo']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Marca']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Colore']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Anno_Acquisizione']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
<script type='text/javascript' language='javascript'>
$('#Cancella').click(function() {
				var $textAndPic = $('<div></div>');
			$textAndPic.append('<p>Scegli bici che vuoi cancellare:</p>  <div>  	<select name="form-bici" class="form-control" id="form-bici">	<?php while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC)): ?><option  value="<?php echo $userRow["Id"]; ?>"><?php echo $userRow["Id"]; ?></option><?php endwhile; ?>
					</select></div> </div>');
					BootstrapDialog.show({
					title: 'Cancella Bici',
					message : $textAndPic,
					buttons: [{
					label: 'Cancella',
					action: function(dialog) {
					var id=  $( "#form-bici option:selected" ).text();
					
					$.ajax({
					url : '/BasiDati/function/EliminaBici.php',
					type : 'POST',
					data : "Id=" + id
					}).done(function() {
					alert("Bici Eliminata con successo!");
					dialog.close();
					cambiaContenuto('visbici');
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
