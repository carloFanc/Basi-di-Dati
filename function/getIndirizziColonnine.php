<?php
require_once ("../session.php");

require_once ("../class.user.php");
$auth_user = new USER();
 
$stmt = $auth_user->runQuery('SELECT * FROM Colonnina_Elettrica;');

$stmt->execute();
$output_string = '<select data-width="fit" id="colonnina">';
while ($userRow = $stmt -> fetch(PDO::FETCH_ASSOC)) :
	$output_string .= '<option value="'.$userRow['Indirizzo'] .'">' . $userRow['Indirizzo'] . '</option>';	
	endwhile;
$output_string .= '</select>';	
echo json_encode($output_string);
?>