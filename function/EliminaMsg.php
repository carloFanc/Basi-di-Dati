<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$id = $_POST['id'];
	$stmt = $auth_user->runQuery('CALL EliminaINBOX(:id)');
	$stmt -> execute(array(":id" => $id));
	
?>