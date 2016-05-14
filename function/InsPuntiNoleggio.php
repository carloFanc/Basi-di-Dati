<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT Indirizzo FROM Postazione_Prelievo');
$stmt->execute();
$error = ""; //To store errors
$form_data = array(); //Pass back the data to `form.php`
 if (isset($_POST['nome']) && isset($_POST['sito']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['ind'])&& isset($_POST['lat'])&& isset($_POST['long'])) {

	 
		$nome = $_POST['nome'];
		$sito = $_POST['sito'];
		$email = $_POST['email'];
		$tel = $_POST['tel'];
		$ind = $_POST['ind'];
		$lat = $_POST['lat'];
		$long = $_POST['long'];
		

	   $user -> InsertnewPuntoNoleggio($nome,$sito, $email, $tel,$ind,$lat,$long);
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