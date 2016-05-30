<body>
		 <div>
			<h1 align="center">Inserimento Nuova Postazione Prelievo</h1>
			
			
			<form role="form"  id="InsPostazioni" >
				<div class="form-group">
					<label for="text">Indirizzo:</label>
					<input name="form-ind" type="text" class="form-control" id="form-ind">
				</div>
				<div class="form-group">
					<label for="text">Numero Bici Totali:</label>
					<input name="form-num1" type="number" class="form-control" id="form-num1">
				</div>
				
				<div class="form-group">
					<label for="text">Numero Bici Disponibili:</label>
					<input name="form-num2" type="number" class="form-control" id="form-num2">
				</div>
				<div class="form-group">
					<label for="text">Latitudine:</label>
					<input name="form-lat" type="text" class="form-control" id="form-lat">
				</div>
				<div class="form-group">
					<label for="text">Longitudine:</label>
					<input name="form-long" type="text" class="form-control" id="form-long">
				</div>
				<button type="submit" name="btn-invio" class="btn btn-primary">
					Invio
				</button>
			</form>
		</div>
		<script src="/BasiDati/js/InsPostazioni.js"></script>
	</body>