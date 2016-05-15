<?php
require_once ("../session.php");

require_once ("../class.user.php");
$auth_user = new USER();

$umail = $_SESSION['user_email'];
$tipo = $_SESSION['user_tipologia'];
$stmt = $auth_user -> runQuery('SELECT * FROM Veicolo_elettrico;');
$stmt -> execute();
$stmt2 = $auth_user -> runQuery('SELECT Targa FROM Veicolo_elettrico;');
$stmt2 -> execute();
?>
<head>
	<style>
		.Mostra {
			padding: 10px 10px 10px 36px;
			font-family: "Trebuchet MS", Arial, Verdana;
			background: #e9e9e9 url(./img/foto.png) 10px 10px no-repeat;
			border-radius: 16px;
			border: 1px solid #d9d9d9;
			text-shadow: 1px 1px #fff;
		}
		
	</style>
	<link href="css/bootstrap-dialog.min.css" rel="stylesheet"> 
</head>
<body>
	
		<div >
			<h1 align="center">Veicoli</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
				<?php if($tipo=="Amministratore"): ?>
				<div>
					<h4>Per cancellare un veicolo  <button type="button" class="btn btn-primary Cancella" data-toggle="modal" data-target="#myModal2">CLICCA QUI</button></h4>
		 
				</div>
				<?php endif;?>
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
     						      <?php if($userRow['Foto']!=""):?><td class="col-md-3"><button type="button" data-toggle="modal" class="Mostra" data-target="#myModal" id="<?php echo $userRow['Foto']; ?>">Foto</button></td>
     			                  <?php else: ?><td class="col-md-3" ><img src="./img/noButton.jpg"></td>
     						      <?php endif; ?>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>

          <script type='text/javascript' language='javascript'>
			$('.Mostra').click(function() {
				var id = $(this).attr('id');

				var html = "<img src=\".\/uploads\/>";
				var $textAndPic = $('<div></div>');
				$textAndPic.append('<img width="555px" src="./uploads/' + id + '" />');

				BootstrapDialog.show({
					message : $textAndPic,
					buttons : [{
						label : 'Close',
						action : function(dialogRef) {
							dialogRef.close();
						}
					}],
				});

			});
</script>
          <script type='text/javascript' language='javascript'>
									$('.Cancella').click(function() {
				
				var $textAndPic = $('<div></div>');
				$textAndPic.append('<p>Scegli Veicolo che vuoi cancellare:</p>  <div>  	<select name="form-targa" class="form-control" id="form-targa">	<?php while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC)): ?><option  value="<?php echo $userRow["Targa"]; ?>"><?php echo $userRow["Targa"]; ?></option><?php endwhile; ?>
					</select></div> </div>');

					BootstrapDialog.show({
					title: 'Cancella Veicolo',
					message : $textAndPic,
					buttons: [{
					label: 'Cancella',
					action: function(dialog) {
					var targa=  $( "#form-targa option:selected" ).text();
					
					$.ajax({
					url : '/BasiDati/function/EliminaVeicolo.php',
					type : 'POST',
					data : "targa=" + targa
					}).done(function() {
					alert("Veicolo Eliminato con successo!");
					dialog.close();
					cambiaContenuto('visveicoli');
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