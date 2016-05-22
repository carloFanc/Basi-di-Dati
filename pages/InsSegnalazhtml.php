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
				<div class=" row">
			<div class="form-group col-md-1" style="float: left;">
					<label for="piste">Piste Ciclabili:</label>
				</div>
                <div class="col-md-6"  style="float: left;">
				  <select name="form-piste"  id="form-piste">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["id"] ?>"><?php echo $userRow["id"] ?></option>
					<?php endwhile; ?>
					</select>	
				</div>
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
		<script src="/BasiDati/js/InsSegnalaz.js"></script>
		
	</body>