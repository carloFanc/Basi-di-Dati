<?php
session_start();
require_once ('class.user.php');
$user = new USER();

if ($user -> is_loggedin() != "") {
	$tipologia = $_SESSION['user_tipologia'];

	if (strcmp($tipologia, "Semplice") == 0) {
		$login -> redirect('homeSemplice.php');
	} else if (strcmp($tipologia, "Premium") == 0) {
		$login -> redirect('homePremium.php');
	} else if (strcmp($tipologia, "Amministratore") == 0) {
		$login -> redirect('homeAmministratore.php');
	}
}

if (isset($_POST['btn-signup'])) {
	$uname = strip_tags($_POST['form-first-name']);
	$ucogn = strip_tags($_POST['form-last-name']);
	$umail = strip_tags($_POST['form-email']);
	$upass = strip_tags($_POST['form-pass']);
	$udata = strip_tags($_POST['form-date']);
	$uluogo = strip_tags($_POST['form-luogo']);
	$uresidenza = strip_tags($_POST['form-resid']);
	$utel = strip_tags($_POST['form-tel']);
    $foto = strip_tags($_POST['file']);
	try {
		$stmt = $user -> runQuery("SELECT Email FROM Utente WHERE Email=:umail");
		$stmt -> execute(array(':umail' => $umail));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);

		if ($row['Email'] == $umail) {
			echo '<script type="text/javascript">alert("email già esistente! Riprova");
					window.location = \'indexsignup.php\'</script>';
		} else {
			if ($user -> register($uname, $ucogn, $umail, $upass, $udata, $uluogo, $uresidenza, $utel)) {
				echo '<script type="text/javascript">alert("Utente registrato correttamente");
					window.location = \'index.php\'</script>';

			}
		}
	} catch(PDOException $e) {
		echo $e -> getMessage('Error');
	}
}
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login</title>

		<!-- CSS -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/form-elementsLogin.css">
		<link rel="stylesheet" href="css/styleLogin.css">
		<link rel="stylesheet" href="css/jquery-ui.css">

		<link rel="shortcut icon" href="assets/ico/favicon.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">

	</head>

	<body>

		<!-- Top content -->
		<div class="top-content">

			<div class="inner-bg">
				<div class="container">

					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 text">
							<h1>Benvenuto!</h1>
						</div>
					</div>

					<div class="row">

						<div class="col-md-6 col-md-offset-3 ">

							<div class="form-box">
								<div class="form-top">
									<div class="form-top-left">
										<h3>Registrati ora</h3>
										<p>
											Compila i seguenti campi per registrarti:
										</p>
									</div>
									<div class="form-top-right">
										<i class="fa fa-pencil"></i>
									</div>
								</div>
								<div class="form-bottom">
									<form role="form" action="" method="post" class="registration-form">
										<div class="form-group">
											<label class="sr-only" for="form-first-name">Nome</label>
											<input type="text" name="form-first-name" placeholder="Nome..." class="form-first-name form-control" id="form-first-name">
										</div>
										<div class="form-group">
											<label class="sr-only" for="form-last-name">Cognome</label>
											<input type="text" name="form-last-name" placeholder="Cognome..." class="form-last-name form-control" id="form-last-name">
										</div>
										<div class="form-group">
											<label class="sr-only" for="form-email">Email</label>
											<input type="email" name="form-email" placeholder="Email..." class="form-email form-control" id="form-email">
										</div>
										<div class="form-group">
											<label class="sr-only" for="form-pass">Password</label>
											<input type="password" name="form-pass" placeholder="Password..." class="form-pass form-control" id="form-pass">
										</div>
										<div class="form-group">
											<label class="sr-only" for="form-date">Data di Nascita</label>
											<input type="text" name="form-date" placeholder="Data di Nascita..." class="form-date form-control datepicker" id="data">
										</div>
										<div class="form-group">
											<label class="sr-only" for="form-luogo">Luogo di Nascita</label>
											<input type="text" name="form-luogo" placeholder="Luogo di Nascita..." class="form-luogo form-control" id="form-luogo">
										</div>
										<div class="form-group">
											<label class="sr-only" for="form-resid">Indirizzo di Residenza</label>
											<input type="text" name="form-resid" placeholder="Indirizzo di Residenza..." class="form-resid form-control" id="form-resid">
										</div>
										<div class="form-group">
											<label class="sr-only" for="form-tel">Recapito Telefonico</label>
											<input type="text" name="form-tel" placeholder="Recapito Telefonico..." class="form-tel form-control" id="form-tel">
										</div>
										<div class="form-group">
											<label for="text">Foto:</label>
											<input type="file" name="file" id="file" required />
										</div>
										<button type="submit" name="btn-signup" class="btn">
											Registrati!
										</button>
									</form>
								</div>
							</div>
							<label>Hai già un account? <a href="index.php">Loggati</a></label>
						</div>
					</div>

				</div>
			</div>

		</div>

		<!-- Javascript -->
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scriptsLogin.js"></script>

	</body>

</html>