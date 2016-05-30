<?php
require_once ("session.php");

require_once ("class.user.php");
$auth_user = new USER();

if ($auth_user -> is_loggedin() != "") {
	$tipologia = $_SESSION['user_tipologia'];

	if (strcmp($tipologia, "Semplice") == 0) {
		$auth_user -> redirect('homeSemplice.php');
	} else if (strcmp($tipologia, "Premium") == 0) {
		$auth_user -> redirect('homePremium.php');
	} else if (strcmp($tipologia, "Amministratore") == 0) {

	}
}

$umail = $_SESSION['user_email'];

$stmt = $auth_user -> runQuery("SELECT * FROM Utente WHERE Email=:umail");
$stmt -> execute(array(":umail" => $umail));

$userRow = $stmt -> fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Profilo Utente Amministratore</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link href="css/home.css" rel="stylesheet">
		<link rel="stylesheet" href="css/nice-select.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
		<link rel="stylesheet" href="css/bootstrap-dialog.min.css" >
		<script type="text/javascript">
			window.onload = function() {
				$('#menuEContenuto').hide("fast").css("visibility", "hidden");
				cambiaContenuto('Home');

				document.getElementById("HomeImg").onclick = function() {
					$('#menuEContenuto').hide("fast").css("visibility", "hidden");
					cambiaContenuto('Home');
				};
			};
		</script>
	</head>
	<body>

		<header class="navbar navbar-default navbar-static-top" role="banner">
			<!-- QUESTO E' IL DIV DEL MENU' IN ALTO  -->
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
					<img id="HomeImg" src="/BasiDati/img/Logo.png" height="55" width="150">
				</div>
				<nav class="collapse navbar-collapse" role="navigation">
					<ul class="fontMenu nav navbar-nav ">
						<li >
							<a href='#' onclick="cambiaFinestra('bici')" >Bici</a>
						</li>
						<li >
							<a href='#' onclick="cambiaFinestra('veicoli')">Veicoli</a>
						</li>
						<li >
							<a href='#' onclick="cambiaFinestra('prenotazioni')">Prenotazioni</a>
						</li>
						<li >
							<a href='#' onclick="cambiaFinestra('inbox')">Inbox</a>
						</li>
						<li >
							<a href='#' onclick="cambiaFinestra('forum')">Forum</a>
						</li>
						<li >
							<a href='#' onclick="cambiaFinestra('altro')">Altro</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="glyphicon glyphicon-user"></span>&nbsp;Ciao <?php echo $userRow['Nome']; ?>&nbsp;<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li>
									<a href="#" onclick="cambiaFinestra('profilo')"><span class="glyphicon glyphicon-user"></span>&nbsp;Vedi Profilo</a>
								</li>
								<li>
									<a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</header>

		<!-- Begin Body -->
		<div class="container">
			<div id="Home">

			</div>
			<div class="row" id="menuEContenuto">
				<div class="col-md-3" id="leftCol">
					<!-- QUESTO E' IL DIV DEL MENU' LATERALE  -->

					<div id="bici" class="well">
						<ul class="nav nav-stacked" id="sidebar">
							<li data-toggle="collapse" data-parent="#p6" href="#pv6">
								<a class="nav-sub-container">Inserisci<span class="caret arrow"></span><div class="caret-container"></div></a>

								<ul class="nav nav-pills nav-stacked collapse" id="pv6">
									<li>
										<a href="#"  onclick="cambiaContenuto('nuovabici')">Bici</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('nuovapostazione')">Postazioni Prelievo</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('nuovapista')">Piste Ciclabili</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#" onclick="cambiaContenuto('visbici')">Visualizza Bici</a>
							</li>
							<li data-toggle="collapse" data-parent="#p1" href="#pv1">
								<a class="nav-sub-container">Visualizza Post. Prelievo<span class="caret arrow"></span><div class="caret-container"></div></a>

								<ul class="nav nav-pills nav-stacked collapse" id="pv1">
									<li>
										<a href="#"  onclick="cambiaContenuto('postazioni')">Su Tabella</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('getDistanceLatLongBici')">Su Google Maps</a>
									</li>
								</ul>
							</li>

							<li data-toggle="collapse" data-parent="#p2" href="#pv2">
								<a class="nav-sub-container">Visualizza Piste Ciclabili<span class="caret arrow"></span><div class="caret-container"></div></a>

								<ul class="nav nav-pills nav-stacked collapse" id="pv2">
									<li>
										<a href="#"  onclick="cambiaContenuto('pisteciclabili')">Su Tabella</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('getDistanceLatLongPisteCiclabili')">Su Google Maps</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<div id="veicoli" class="well">
						<ul class="nav nav-stacked" id="sidebar">
							<li data-toggle="collapse" data-parent="#p7" href="#pv7">
								<a class="nav-sub-container">Inserisci<span class="caret arrow"></span><div class="caret-container"></div></a>

								<ul class="nav nav-pills nav-stacked collapse" id="pv7">
									<li>
										<a href="#"  onclick="cambiaContenuto('nuovoveicolo')">Veicolo</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('nuovopuntonoleggio')">Punto Noleggio</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('nuovacolonnina')">Colonnina di Ricarica</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#" onclick="cambiaContenuto('visveicoli')">Visualizza Veicoli</a>
							</li>
							<li data-toggle="collapse" data-parent="#p3" href="#pv3">
								<a class="nav-sub-container">Visualizza Punti Noleggio<span class="caret arrow"></span><div class="caret-container"></div></a>

								<ul class="nav nav-pills nav-stacked collapse" id="pv3">
									<li>
										<a href="#"  onclick="cambiaContenuto('puntinoleggio')">Su Tabella</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('getDistanceLatLongPuntiNoleggio')">Su Google Maps</a>
									</li>
								</ul>
							</li>
							<li data-toggle="collapse" data-parent="#p4" href="#pv4">
								<a class="nav-sub-container">Visualizza Colonn. Ricarica<span class="caret arrow"></span><div class="caret-container"></div></a>

								<ul class="nav nav-pills nav-stacked collapse" id="pv4">
									<li>
										<a href="#"  onclick="cambiaContenuto('viscolonnine')">Su Tabella</a>
									</li>
									<li>
										<a href="#" onclick="cambiaContenuto('getDistanceLatLongColonnine')">Su Google Maps</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<div id="prenotazioni" class="well">
						<ul class="nav nav-stacked" id="sidebar">
							<li>
								<a href="#" onclick="cambiaContenuto('prenpassate')">Visualizza Prenotazioni Passate</a>
							</li>
							<li>
								<a href="#" onclick="cambiaContenuto('prenincorso')">Visualizza Prenotazioni in Corso</a>
							</li>
						</ul>
					</div>
					<div id="inbox" class="well">
						<ul class="nav nav-stacked" id="sidebar">
							<li>
								<a href="#" onclick="cambiaContenuto('inviomsgpersonale')">Invia Messaggio Personale</a>
							</li>
							<li>
								<a href="#" onclick="cambiaContenuto('inbox')">Visualizza Messaggi Inbox</a>
							</li>
						</ul>
					</div>
					<div id="forum" class="well">
						<ul class="nav nav-stacked" id="sidebar">
							<li>
								<a href="#" onclick="cambiaContenuto('post')">Inserisci Post</a>
							</li>
							<li>
								<a href="#" onclick="cambiaContenuto('forum')">Visualizza Forum</a>
							</li>
						</ul>
					</div>
					<div id="altro" class="well">
						<ul class="nav nav-stacked" id="sidebar">
							<li>
								<a href="#" onclick="cambiaContenuto('listautenti')">Lista Utenti</a>
							</li>
						</ul>
					</div>

				</div>

				<div id="Contenuto" class="col-md-9">
					<!-- QUESTO E' IL DIV DEL CONTENUTO  -->
				</div>

			</div>
		</div>

		<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap-dialog.min.js"></script>
		<script src="js/jquery.nice-select.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>