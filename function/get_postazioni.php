<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$stmt = $auth_user->runQuery('SELECT Indirizzo,Numero_Bici_Totale,Latitudine,Longitudine FROM Postazione_Prelievo');
	$stmt->execute();
	$locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
	header('Content-Type: application/json');
	echo json_encode($locations);
?>