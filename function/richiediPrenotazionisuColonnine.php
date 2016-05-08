<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

if (isset($_POST['indirizzo']) && isset($_POST['data'])) {
		 $indirizzo = $_POST['indirizzo'];
		$data = $_POST['data'];
		
		 
	$auth_user = new USER();
	$stmt = $auth_user->runQuery("SELECT Slot_Inizio,Slot_Fine FROM Prenotazione_Colonnina WHERE Indirizzo=:indiri AND Data_pren=:datapren");
	 $stmt->bindparam(":indiri",  $indirizzo);
	 $stmt->bindparam(":datapren", $data );
	$stmt->execute();
	$locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
	header('Content-Type: application/json');
	echo json_encode($locations);
}
?>