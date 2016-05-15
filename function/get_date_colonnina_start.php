<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER(); 
  if (isset($_POST['indirizzo'])) {
 
   $indirizzo = $_POST['indirizzo'];
    $data = $user-> getDataColonnina( $indirizzo );
    $data = $data["Data_Inserimento"];
    echo json_encode($data );
 } 
 
?>