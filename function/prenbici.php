<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();

if (isset($_POST['email']) && isset($_POST['text'])) {

	try {
		$mailm = $_SESSION['user_email'];
		$id = $_POST['id'];
		$date1 = $_POST['date1'];
		$date2 = $_POST['date2'];
		

		if ($id != NULL && $date1 != NULL && $date2 != NULL) {
			if ($user -> InsertBici($mailm, $id, $date1, $date2)) {
				echo '<script type="text/javascript">alert("Prenotazione effettuata");</script>';

			}

		}

	} catch(PDOException $e) {
		echo $e -> getMessage('Error');
		
	}

}
?>
