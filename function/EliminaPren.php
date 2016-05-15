<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$id = $_POST['id'];
	$n= $_POST['n'];
	if($n==1){
	$stmt = $auth_user->runQuery('CALL EliminaPrenInCorsoBici(:id)');
	$stmt -> execute(array(":id" => $id));
	}elseif($n==2){
	$stmt = $auth_user->runQuery('CALL EliminaPrenInCorsoVeicoli(:id)');
	$stmt -> execute(array(":id" => $id));
	}elseif($n==3){
	$stmt = $auth_user->runQuery('CALL EliminaPrenInCorsoColonnina(:id)');
	$stmt -> execute(array(":id" => $id));
	}
?>