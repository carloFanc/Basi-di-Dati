<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL VisualizzaPostazioni()');
	$stmt->execute();
	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Postazioni Prelievo</title>
		<meta name="description" content="profilo">
		<meta name="author" content="Carlof">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
	</head>

	<body>
		<div >
			<h1>Postazioni Prelievo</h1> 
			<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
            	<div class="container">
  						           
  						<table class="table table-bordered">
    					<thead>
      					<tr>
      					  <th>Indirizzo</th>
      					  <th>Numero Bici Disponibili</th>
     					 </tr>
    					</thead>
  		  						<tbody>
      							<tr>
      							  <td class="col-md-3"><?php echo $userRow['Indirizzo']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Numero_Bici_Disponibili']; ?></td>
     							 </tr>
      						  </tbody>
  						</table>
			   </div>
            <?php endwhile; ?>
          </div>
          <div>
           <?php $stmt2 = $auth_user->runQuery('SELECT Latitudine,Longitudine FROM Postazione_Prelievo;');
	$stmt2->execute();?>
			<section id="wrapper">
				<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
				<script>
					function success(position) {
						var mapcanvas = document.createElement('div');
						mapcanvas.id = 'mapcontainer';
						mapcanvas.style.height = '400px';
						mapcanvas.style.width = '600px';

						document.querySelector('article').appendChild(mapcanvas);
					<?php while ($userRow2=$stmt2->fetch(PDO::FETCH_ASSOC)): ?>
						var coords = new google.maps.LatLng($userRow2['Latitudine'];, $userRow2['Longitudine'];);
						

						var options = {
							zoom : 15,
							center : coords,
							mapTypeControl : false,
							navigationControlOptions : {
								style : google.maps.NavigationControlStyle.SMALL
							},
							mapTypeId : google.maps.MapTypeId.ROADMAP
						};
						var map = new google.maps.Map(document.getElementById("mapcontainer"), options);
					 
						var marker = new google.maps.Marker({
							position : coords,
							map : map,
							title : "Postazione Prelievo"
						});
						<?php endwhile; ?>
					}

					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(success);
					} else {
						error('Geo Location is not supported');
					}

				</script>
			</section>
		</div>
</body>
</html>
