<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
echo $_POST['email'] ;
if (isset($_POST['email']) && isset($_POST['text'])) {

	try {
		$mailm = $_SESSION['user_email'];
		$maild = $_POST['email'];
		$text = $_POST['text'];
		$data = date("Y-m-d H:i:s");

		if ($maild != NULL && $text != NULL) {
			if ($user -> Insertmsg($mailm, $maild, $text, $data)) {
				echo '<script type="text/javascript">alert("Messaggio inviato correttamente");</script>';

			}

		}

	} catch(PDOException $e) {
		echo $e -> getMessage('Error');
		echo '<script type="text/javascript"> alert("Messaggio inviato asdasd"); </script>';
	}

}
?>
