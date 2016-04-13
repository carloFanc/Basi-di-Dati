<?php
	require_once('session.php');
	require_once('class.user.php');
	$user_logout = new USER();
	
	if($user_logout->is_loggedin()!=""){
		$tipologia = $_SESSION['user_tipologia'];
	  
	if(strcmp ($tipologia , "Semplice") ==0 ){
			$user_logout->redirect('homeSemplice.php');
		}else if(strcmp ($tipologia , "Premium") ==0){
			$user_logout->redirect('homePremium.php');
		}else if(strcmp ($tipologia , "Amministratore") ==0){
			$user_logout->redirect('homeAmministratore.php');
		}
}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('index.php');
	}
