<head>
	
	<link rel="stylesheet" href="/BasiDati/css/bootstrap-datetimepicker.min.css"> 
 
</head>
<body>
		 <div style=" clear:both">
			<h1 align="center">Inserimento Nuova Colonnina di Ricarica</h1>
			
			
			<form role="form"  id="InsColonnine" >
				<div class="form-group">
					<label for="text">Indirizzo:</label>
					<input name="form-ind" type="text" class="form-control" id="form-ind">
				</div>
				<div class="form-group">
					<label for="text">Ente Fornitore:</label>
					<input name="form-ente" type="text" class="form-control" id="form-ente">
				</div>
				<div class="form-group">
					<label for="text">MAX KWH:</label>
					<input name="form-max" type="number" class="form-control" id="form-max">
				</div>
				<h4>Data Inserimento:</h4>
                <div class="input-group date" id="datetimepicker" style="clear:both">
				 
                    <input type='text' class="form-control" id="form-data" name="form-data"></input>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
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
		 
		<script  src="/BasiDati/js/moment.js"></script>
		<script src="/BasiDati/js/bootstrap-datetimepicker.min.js"></script>
		<script src="/BasiDati/js/InsColonnine.js"></script>
		
	</body>