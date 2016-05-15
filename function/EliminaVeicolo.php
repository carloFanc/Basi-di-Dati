<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$targa = $_POST['targa'];
	$stmt = $auth_user->runQuery('CALL EliminaVEICOLO(:targa)');
	$stmt -> execute(array(":targa" => $targa));
	
?>