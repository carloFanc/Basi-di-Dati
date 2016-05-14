<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user -> runQuery('SELECT id FROM Pista_Ciclabile');
$stmt -> execute();
?>
	<body>
		 <div>
			<h1>Inserimento Segnalazione</h1>
			
			
			<form role="form"  id="InsSegn" >
				<div class="form-group">
					<label for="bici">Piste Ciclabili:</label>
					<select name="form-piste" class="form-control" id="form-piste">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["id"] ?>"><?php echo $userRow["id"] ?></option>
					<?php endwhile; ?>
					</select>	
				</div>
				<div class="form-group">
					<label for="text">Titolo:</label>
					<input name="form-titolo" type="text" class="form-control" id="form-titolo">
				</div>
				<div class="form-group">
					<label for="text">Testo Messaggio:</label>
					<input name="form-testo" type="text" class="form-control" id="form-testo">
				</div>
				<button type="submit" name="btn-invio" class="btn btn-primary">
					Invio
				</button>
			</form>
		</div>
		<script src="/BasiDati/js/jquery-1.11.1.min.js"></script>
		<script src="/BasiDati/js/bootstrap.min.js"></script>			
		<script src="/BasiDati/js/jquery-ui.js"></script>
		<script src="/BasiDati/js/InsSegnalaz.js"></script>
		
	</body>