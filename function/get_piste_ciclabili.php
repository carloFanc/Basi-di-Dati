<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$stmt = $auth_user->runQuery('SELECT Id,Chilometri,Pendenza_Media,Latitudine,Longitudine FROM Pista_Ciclabile');
	$stmt->execute();
	$locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
	header('Content-Type: application/json');
	echo json_encode($locations);
?>