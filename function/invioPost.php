<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
if (isset($_POST['titolo']) && isset($_POST['text'])) {

	try {
		$mailm = $_SESSION['user_email'];
		$text = $_POST['text'];
		$titolo = $_POST['titolo'];
		
		if ($titolo != NULL && $text != NULL) {
			if ($user -> InsertPost($mailm,$titolo,$text)) {
				echo '<script type="text/javascript">alert("Post inviato correttamente");</script>';

			}

		}

	} catch(PDOException $e) {
		echo $e -> getMessage('Error');
		
	}

}
?>
