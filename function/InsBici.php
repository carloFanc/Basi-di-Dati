<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT Indirizzo FROM Postazione_Prelievo');
$stmt->execute();
$error = ""; 
$form_data = array(); 
 if (isset($_POST['id']) && isset($_POST['postazione']) && isset($_POST['marca']) && isset($_POST['colore']) && isset($_POST['anno'])) {

	 
		$id = $_POST['id'];
		$postazione = $_POST['postazione'];
		$marca = $_POST['marca'];
		$colore = $_POST['colore'];
		$anno = $_POST['anno'];
		

	   $user -> InsertnewBici($id,$postazione, $marca, $colore, $anno);
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