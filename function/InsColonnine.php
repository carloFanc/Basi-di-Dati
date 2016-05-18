<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT Indirizzo FROM Postazione_Prelievo');
$stmt->execute();
$error = ""; 
$form_data = array(); 
 if (isset($_POST['ind']) && isset($_POST['ente']) && isset($_POST['max']) && isset($_POST['data']) && isset($_POST['lat']) && isset($_POST['long'])) {

	 
		$ind = $_POST['ind'];
		$ente = $_POST['ente'];
		$maxKWH = $_POST['max'];
		$data = $_POST['data'];
		$lat = $_POST['lat'];
		$long = $_POST['long'];
		

	   $user -> InsertnewColonninaRicarica($ind,$ente, $maxKWH, $data,$lat,$long);
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