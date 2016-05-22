<?php 
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT id from Pista_Ciclabile');
$stmt->execute();
$error = ""; 
$form_data = array(); 
 if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['mail']) 
  && isset($_POST['pass']) && isset($_POST['data']) && isset($_POST['luogo']) 
  && isset($_POST['res']) && isset($_POST['tel']) && isset($_POST['foto'])) {
	$uname = strip_tags($_POST['name']);
	$ucogn = strip_tags($_POST['surname']);
	$umail = strip_tags($_POST['mail']);
	$upass = strip_tags($_POST['pass']);
	$udata = strip_tags($_POST['data']);
	$uluogo = strip_tags($_POST['luogo']);
	$uresidenza = strip_tags($_POST['res']);
	$utel = strip_tags($_POST['tel']);
    $foto = strip_tags($_POST['foto']);
	try {
		$stmt = $user -> runQuery("SELECT Email FROM Utente WHERE Email=:umail");
		$stmt -> execute(array(':umail' => $umail));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);

		if ($row['Email'] == $umail) {
			echo ' '.$row['Email'].' '. $umail;
		} else {
			if ($user -> register($uname, $ucogn, $umail, $upass, $udata, $uluogo, $uresidenza, $utel, $foto)) {
			 echo 'ok';

			}
		}
	} catch(PDOException $e) {
		echo $e -> getMessage('Error');
	} 
}
?>