<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user -> runQuery('SELECT Nome FROM Punto_Noleggio');
$stmt -> execute();
?>
	<body>
		 <div>
			<h1 align="center">Inserimento Nuovo Veicolo</h1>
			
			
			<form role="form"  id="uploadimage" action="" method="post" enctype="multipart/form-data" >
				<div class="form-group">
					<label for="text">Targa:</label>
					<input name="form-targa" type="text" class="form-control" id="form-targa">
				</div>
				<div class="form-group">
					<label for="veicoli">Punti Noleggio:</label>
					<select name="form-punti" class="form-control" id="form-punti">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["Nome"] ?>"><?php echo $userRow["Nome"] ?></option>
					<?php endwhile; ?>
					</select>	
				</div>
				<div class="form-group">
					<label for="veicoli">Tipologia:</label>
					<select name="form-tipo" class="form-control" id="form-tipo">
					<option  value="Scooter">Scooter</option>
					<option  value="Auto">Auto</option>
					</select>	
				</div>
				<div class="form-group">
					<label for="text">Nome Modello:</label>
					<input name="form-modello" type="text" class="form-control" id="form-modello">
				</div>
				<div class="form-group">
					<label for="text">Colore:</label>
					<input name="form-colore" type="text" class="form-control" id="form-colore">
				</div>
				<div class="form-group">
					<label for="text">Costo Orario:</label>
					<input name="form-costo" type="number" class="form-control" id="form-costo">
				</div>
				<div class="form-group">
					<label for="text">Cilindrata:</label>
					<input name="form-cilindrata" type="number" class="form-control" id="form-cilindrata">
				</div>
				<div class="form-group">
					<label for="text">Autonomia Km:</label>
					<input name="form-autonomia" type="number" class="form-control" id="form-autonomia">
				</div>
				<div class="form-group">
					<label for="text">Max Passeggeri:</label>
					<input name="form-passeggeri" type="number" class="form-control" placeholder="Inserire nel caso di Auto" id="form-passeggeri">
				</div>
				<div class="form-group">
					<label for="text">Chilometraggio Attuale:</label>
					<input name="form-chilometri" type="number" class="form-control" placeholder="Inserire nel caso di Auto" id="form-chilometri">
				</div>
				<div class="form-group"> 
				<label for="text">Foto:</label>
    			<input type="file" name="file" id="file" required />
              </div>
 <button type="submit" value="Upload" name="submit" class="btn btn-primary">
					Invio
				</button>
			</form>
		</div>
		<script src="/BasiDati/js/jquery-1.11.1.min.js"></script>
		<script src="/BasiDati/js/bootstrap.min.js"></script>			
		<script src="/BasiDati/js/jquery-ui.js"></script>
		 <script src="/BasiDati/js/InsVeicoli.js"></script>  
	</body>