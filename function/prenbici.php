<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$stmt = $user->runQuery('SELECT id from Bici');
$stmt->execute();
$error = ""; //To store errors
$form_data = array(); //Pass back the data to `form.php`
 if (isset($_POST['id']) && isset($_POST['date1']) && isset($_POST['date2'])) {

	 
		$mailm = $_SESSION['user_email'];
		$id = $_POST['id'];
		$date1 = $_POST['date1'];
		$date2 = $_POST['date2'];
		

	   $user -> InsertBici($mailm, $id, $date1, $date2);
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
