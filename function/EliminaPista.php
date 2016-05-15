<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$Id = $_POST['Id'];
	$stmt = $auth_user->runQuery('CALL EliminaPISTA(:id)');
	$stmt -> execute(array(":id" => $Id));
	
?>