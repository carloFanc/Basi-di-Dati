<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user -> runQuery('SELECT id from Bici');
$stmt -> execute();
?>
<body>
		 <div>
			<h1 align="center">Prenotazione bici</h1>
			
			
			<form role="form"  id="PrenBici" >
				<div class="form-group">
					<label for="bici">Bici:</label>
					<select name="form-bici" class="form-control" id="form-bici">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["id"] ?>"><?php echo $userRow["id"] ?></option>
					<?php endwhile; ?>
					</select>	
				</div>
				<div id="datetimepicker" class="input-append date">
					<label for="date1">Data Inizio:</label>
					<input name="form-date1" data-format="yyyy-MM-dd hh:mm:ss" type="text" id="form-date1"> </input>
					<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"> </i> </span>
				</div>
				<div id="datetimepicker2" class="input-append date" class="form-group">
					<label for="date2">Data Fine:</label>
					<input name="form-date2" data-format="yyyy-MM-dd hh:mm:ss" type="text" id="form-date2"> </input>
					<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"> </i> </span>
				</div>
				<button type="submit" name="btn-invio" class="btn btn-primary">
					Invio
				</button>
			</form>
		</div>
		<script src="/BasiDati/js/jquery-1.11.1.min.js"></script>
		<script src="/BasiDati/js/bootstrap.min.js"></script>			
		<script src="/BasiDati/js/jquery-ui.js"></script>
		<script src="/BasiDati/js/prenBici.js"></script>
		<script  src="/BasiDati/js/moment.js"></script>
		<script src="/BasiDati/js/bootstrap-datetimepicker.min.js"></script>
	</body>