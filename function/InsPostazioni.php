<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT Indirizzo FROM Postazione_Prelievo');
$stmt->execute();
$error = ""; //To store errors
$form_data = array(); //Pass back the data to `form.php`
 if (isset($_POST['ind']) && isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['lat']) && isset($_POST['long'])) {

	 
		$indirizzo = $_POST['ind'];
		$numbicitotale = $_POST['num1'];
		$numbicidisp = $_POST['num2'];
		$lat = $_POST['lat'];
		$long = $_POST['long'];
		

	   $user -> InsertnewPostazione($indirizzo,$numbicitotale, $numbicidisp, $lat, $long);
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