<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user -> runQuery('SELECT Indirizzo FROM Colonnina_Elettrica');
$stmt -> execute();
?>
<head>
	<link rel="stylesheet" href="/BasiDati/css/nice-select.css">
	<style>
		.top-buffer {
			margin-top: 10px;
		}
		.top-buffer-more {
			margin-top: 30px;
		}

	</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 
	
</head>
	<body>
		 <div>
		 	<div class="container-fluid" >
 <div class="row top-buffer " >
			<h1 align="center">Utilizzo medio Colonnine di Ricarica</h1>
			</div>
			
			<div style="width:35% ; float: left;">
			<div class="row top-buffer">
				<div class=" col-md-12"   >
			<form role="form"  id="sceltaColonnina" onsubmit="return false">
				<div class="form-group">
					<label for="bici">Colonnina Elettrica:</label>
					</div>
					 
					<select name="form-col"  id="form-col">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option  value="<?php echo $userRow["Indirizzo"] ?>"><?php echo $userRow["Indirizzo"] ?></option>
					<?php endwhile; ?>
					</select>	
				 
			</div>	
			</div>	
			<div class="row top-buffer-more">
				<div class=" col-md-12">
				<button type="submit" name="btn-invio" class="btn btn-primary" id="invio">
					Invio
				</button>
				</div>
		</div>
			</form>
		</div>
		<div style="width:65%; float: right;">
			<div id="datiUtilizzo"> 
				 </div></div>
		  
		</div>
		
		</div>
		
	<script src="/BasiDati/js/jquery.nice-select.js"></script> 
	<script src="/BasiDati/js/moment.js"></script>
<script src="/BasiDati/js/utilizzoMedioColonnineEGoogleChart.js"></script>

	</body>