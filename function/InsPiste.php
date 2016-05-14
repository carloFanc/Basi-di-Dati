<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT Indirizzo FROM Postazione_Prelievo');
$stmt->execute();
$error = ""; //To store errors
$form_data = array(); //Pass back the data to `form.php`
 if (isset($_POST['km']) && isset($_POST['pend']) && isset($_POST['lat']) && isset($_POST['long'])) {

		$chilometri = $_POST['km'];
		$pendenza = $_POST['pend'];
		$lat = $_POST['lat'];
		$long = $_POST['long'];
		

	   $user -> InsertnewPistaCiclabile($chilometri,$pendenza, $lat, $long);
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