<?php
	require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$stmt = $auth_user->runQuery('SELECT Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine FROM Punto_Noleggio');
	$stmt->execute();
	$locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
	header('Content-Type: application/json');
	echo json_encode($locations);
?>
