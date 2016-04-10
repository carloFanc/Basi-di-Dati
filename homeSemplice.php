<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM Utente WHERE Email=:umail");
	$stmt->execute(array(":umail"=>$umail));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Progetto</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link href="css/home.css" rel="stylesheet">
	</head>
	<body>

<header class="navbar navbar-default navbar-static-top" role="banner"> <!-- QUESTO E' IL DIV DEL MENU' IN ALTO  -->
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="/" class="navbar-brand">BolognaGreen</a>
				</div>
				<nav class="collapse navbar-collapse" role="navigation">
					<ul class="nav navbar-nav">
						<li>
							<a href='#' onclick="cambiaFinestra('bici')">Bici</a>
						</li>
						<li>
							<a href='#' onclick="cambiaFinestra('veicoli')">Veicoli</a>
						</li>
						<li>
							<a href='#' onclick="cambiaFinestra('prenotazioni')">Prenotazioni</a>
						</li>
						<li>
							<a href='#' onclick="cambiaFinestra('inbox')">Inbox</a>
						</li>
						<li>
							<a href='#' onclick="cambiaFinestra('forum')">Forum</a>
						</li>
						<li>
							<a href='#' onclick="cambiaFinestra('altro')">Altro</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Ciao <?php echo $userRow['Nome']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#" onclick="cambiaContenuto('profilo')"><span class="glyphicon glyphicon-user"></span>&nbsp;Vedi Profilo</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
              </ul>
            </li>
          </ul>
				</nav>
			</div>
		</header>

<!-- Begin Body -->
<div class="container">
	<div class="row">
  			<div class="col-md-3" id="leftCol"> <!-- QUESTO E' IL DIV DEL MENU' LATERALE  -->
              	
				<div id="bici" class="well"> 
              	<ul class="nav nav-stacked" id="sidebar">
                  <li><a href="#sec1">Section 1</a></li>
                  <li><a href="#sec2">Section 2</a></li>
                  <li><a href="#sec3">Section 3</a></li>
                  <li><a href="#sec4">Section 4</a></li>
              	</ul>
  				</div>
  				<div id="veicoli" class="well"> 
              	<ul class="nav nav-stacked" id="sidebar">
                  <li><a href="#sec1">Section 5</a></li>
                  <li><a href="#sec2">Section 6</a></li>
                  <li><a href="#sec3">Section 7</a></li>
                  <li><a href="#sec4">Section 8</a></li>
              	</ul>
  				</div>
  				<div id="prenotazioni" class="well"> 
              	<ul class="nav nav-stacked" id="sidebar">
                  <li><a href="#sec1">Section 9</a></li>
                  <li><a href="#sec2">Section 10</a></li>
                  <li><a href="#sec3">Section 11</a></li>
                  <li><a href="#sec4">Section 12</a></li>
              	</ul>
  				</div>
  				<div id="inbox" class="well"> 
              	<ul class="nav nav-stacked" id="sidebar">
                  <li><a href="#sec1">Section 13</a></li>
                  <li><a href="#sec2">Section 14</a></li>
                  <li><a href="#sec3">Section 15</a></li>
                  <li><a href="#sec4">Section 16</a></li>
              	</ul>
  				</div>
  				<div id="forum" class="well"> 
              	<ul class="nav nav-stacked" id="sidebar">
                  <li><a href="#sec1">Section 17</a></li>
                  <li><a href="#sec2">Section 18</a></li>
                  <li><a href="#sec3">Section 19</a></li>
                  <li><a href="#sec4">Section 20</a></li>
              	</ul>
  				</div>
  				<div id="altro" class="well"> 
              	<ul class="nav nav-stacked" id="sidebar">
                  <li><a href="#sec1">Section 21</a></li>
                  <li><a href="#sec2">Section 22</a></li>
                  <li><a href="#sec3">Section 23</a></li>
                  <li><a href="#sec4">Section 24</a></li>
              	</ul>
  				</div>

      		</div>  
      		
      		
      		<div id="Contenuto" class="col-md-9"> <!-- QUESTO E' IL DIV DEL CONTENUTO  -->
            </div>
      		
      		
      		
  	</div>
</div>







	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>