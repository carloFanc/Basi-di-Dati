<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT id from Pista_Ciclabile');
$stmt->execute();
$error = ""; //To store errors
$form_data = array(); //Pass back the data to `form.php`
 if (isset($_POST['id']) && isset($_POST['titolo']) && isset($_POST['testo'])) {

	 
		$mailm = $_SESSION['user_email'];
		$id = $_POST['id'];
		$titolo = $_POST['titolo'];
		$testo = $_POST['testo'];
		

	   $user -> InsertSegnalazione($id,$mailm, $titolo, $testo);
       $error =  $user -> errorGetter();
	   if(strcmp($error, "")==0){
	    $form_data['success'] = true;
        $form_data['errors']  = "";	
	    $form_data['posted'] = 'Data Was Posted Successfully';
	   }else{
	   	$form_data['success'] = false;
        $form_data['errors']  = $error;				   	 
	   }
	   echo json_encode($form_data);
} 
 
?>