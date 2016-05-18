<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$error = ""; 
$form_data = array();
  if (isset($_POST['indirizzo']) && isset($_POST['data']) && isset($_POST['slot1']) && isset($_POST['slot2'])) {
 
	    $umail = $_SESSION['user_email'];
		$indirizzo = $_POST['indirizzo'];
		$data = $_POST['data'];
		$slot1 = $_POST['slot1'];
		$slot2 = $_POST['slot2'];
	 

	   $user -> PrenotazioneColonnina($umail,$indirizzo,$slot1, $slot2,$data);
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