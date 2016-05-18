<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT Targa FROM Veicolo_elettrico');
$stmt->execute();
$error = ""; 
$form_data = array(); 

 if (isset($_POST['Targa']) && isset($_POST['date1']) && isset($_POST['date2'])) {

	 
		$mailm = $_SESSION['user_email'];
		$targa = $_POST['Targa'];
		$date1 = $_POST['date1'];
		$date2 = $_POST['date2'];
		

	   $user -> InsertVeicoli($mailm, $targa, $date1, $date2);
	   
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