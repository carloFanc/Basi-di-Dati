<?php
require_once (dirname(dirname(__FILE__)) . '/session.php');
require_once (dirname(dirname(__FILE__)) . '/class.user.php');

$user = new USER();
$error = ""; 
$form_data = array(); 
 if (isset($_POST['targa']) && isset($_POST['puntonoleggio']) && isset($_POST['tipologia']) && isset($_POST['nomemodello']) && isset($_POST['colore'])&& isset($_POST['costorario'])) {

	 
		$targa = $_POST['targa'];
		$puntonoleggio = $_POST['puntonoleggio'];
		$tipologia = $_POST['tipologia'];
		$nomemodello = $_POST['nomemodello'];
		$colore = $_POST['colore'];
		$costorario = $_POST['costorario'];
		$cilindrata = $_POST['cilindrata'];
		$autonomia = $_POST['autonomia'];
		$passeggeri = $_POST['passeggeri'];
		$chilometri = $_POST['chilometri'];
		$foto = $_POST['foto'];
		$foto=str_replace( "C:\\fakepath\\", "", $foto);
		
		if($_POST['tipologia']=="Auto"){
	   $user -> InsertnewVeicolo($targa,$puntonoleggio,$tipologia,$nomemodello,$colore,$costorario,$cilindrata,$autonomia,$passeggeri,$chilometri,$foto);
       $error =  $user -> errorGetter();
		}else if($_POST['tipologia']=="Scooter"){
			$user -> InsertnewVeicolo($targa,$puntonoleggio,$tipologia,$nomemodello,$colore,$costorario,$cilindrata,$autonomia,null,null,$foto);
            $error =  $user -> errorGetter();
			
		}
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