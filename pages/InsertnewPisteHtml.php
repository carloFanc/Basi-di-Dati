<body>
		 <div>
			<h1 align="center">Inserimento Nuova Pista Ciclabile</h1>
			
			
			<form role="form"  id="InsPiste" >
				<div class="form-group">
					<label for="text">Chilometri:</label>
					<input name="form-km" type="number" class="form-control" id="form-km">
				</div>
				<div class="form-group">
					<label for="text">Pendenza Media:</label>
					<input name="form-pend" type="number" class="form-control" id="form-pend">
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
		<script src="/BasiDati/js/jquery-1.11.1.min.js"></script>
		<script src="/BasiDati/js/bootstrap.min.js"></script>			
		<script src="/BasiDati/js/jquery-ui.js"></script>
		<script src="/BasiDati/js/InsPiste.js"></script>
		
	</body>