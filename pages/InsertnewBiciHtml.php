<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user -> runQuery('SELECT Indirizzo FROM Postazione_Prelievo');
$stmt -> execute();
?>
	<body>
		 <div>
			<h1 align="center">Inserimento Nuova Bici</h1>
			
			
			<form role="form"  id="InsBici" >
				<div class="form-group">
					<label for="text">Identificativo:</label>
					<input name="form-id" type="number" class="form-control" id="form-id">
				</div>
				<div class="form-group">
					<label for="bici">Postazione Prelievo:</label>
					<select name="form-post" class="form-control" id="form-post">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["Indirizzo"] ?>"><?php echo $userRow["Indirizzo"] ?></option>
					<?php endwhile; ?>
					</select>	
				</div>
				
				<div class="form-group">
					<label for="text">Marca:</label>
					<input name="form-marca" type="text" class="form-control" id="form-marca">
				</div>
				<div class="form-group">
					<label for="text">Colore:</label>
					<input name="form-colore" type="text" class="form-control" id="form-colore">
				</div>
				<div class="form-group">
					<label for="text">Anno:</label>
					<input name="form-anno" type="number" class="form-control" id="form-anno">
				</div>
				<button type="submit" name="btn-invio" class="btn btn-primary">
					Invio
				</button>
			</form>
		</div>
		<script src="/BasiDati/js/InsBici.js"></script>
		
	</body>