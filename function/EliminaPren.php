<?php

require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');
	$auth_user = new USER();
	$id = $_POST['id'];
	$email = $_POST['email'];
	$n= $_POST['n'];
	if($n==1){
	$stmt = $auth_user->runQuery('CALL EliminaPrenInCorsoBici(:id,:email)');
	$stmt -> execute(array(":id" => $id,":email" => $email));
	}elseif($n==2){
	$stmt = $auth_user->runQuery('CALL EliminaPrenInCorsoVeicoli(:id,:email)');
	$stmt -> execute(array(":id" => $id,":email" => $email));
	}elseif($n==3){
	$stmt = $auth_user->runQuery('CALL EliminaPrenInCorsoColonnina(:id,:email)');
	$stmt -> execute(array(":id" => $id,":email" => $email));
	}
?>