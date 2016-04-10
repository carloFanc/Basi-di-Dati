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

<header class="navbar navbar-default navbar-static-top" role="banner">
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
					<ul class="nav navbar-nav pull-right">
						
					 
						<li>
							<a href=#>Ciao <?php echo $userRow['Email']; ?></a>
							</li>
						<li>							
							<a href="logout.php?logout=true">Logout</a>
						</li>
					</ul>
				</nav>
			</div>
		</header>

<!-- Begin Body -->
<div class="container">
	<div class="row">
  			<div class="col-md-3" id="leftCol">
              	
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
      		<div class="col-md-9">
              	<h1>Contenuto</h1>
              	
              	
      		</div> 
  	</div>
</div>


<script>
function cambiaFinestra(string) {   
    $('#bici').hide("fast").css("visibility","hidden");
    $('#veicoli').hide("fast").css("visibility","hidden");
    $('#prenotazioni').hide("fast").css("visibility","hidden");
    $('#inbox').hide("fast").css("visibility","hidden");
    $('#forum').hide("fast").css("visibility","hidden");
    $('#altro').hide("fast").css("visibility","hidden");
    if(string=="bici"){
        $('#bici').show("fast").css("visibility","visible");
    }
       if(string=="veicoli"){
        $('#veicoli').show("fast").css("visibility","visible");
    } 
        if(string=="prenotazioni"){
        $('#prenotazioni').show("fast").css("visibility","visible");
    }
        if(string=="inbox"){
        $('#inbox').show("fast").css("visibility","visible");
    }
        if(string=="forum"){
        $('#forum').show("fast").css("visibility","visible");
    }
        if(string=="altro"){
        $('#altro').show("fast").css("visibility","visible");
    }
}</script>







	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>