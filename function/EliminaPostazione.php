<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$Id = $_POST['Id'];
	$stmt = $auth_user->runQuery('CALL EliminaPOSTAZIONE(:id)');
	$stmt -> execute(array(":id" => $Id));
	
?>