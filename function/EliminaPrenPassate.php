<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$stmt = $auth_user->runQuery('CALL EliminaPrenotazioni()');
	$stmt -> execute(array(":id" => $Id));
	
?>