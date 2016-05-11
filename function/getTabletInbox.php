<?php
require_once ("../session.php");

require_once ("../class.user.php");
$auth_user = new USER();

$umail = $_SESSION['user_email'];
$tipouser= $_SESSION['user_tipologia'];
$stmt = $auth_user -> runQuery('CALL VisualizzaInbox(:umail)');

$stmt -> execute(array(":umail" => $umail));
$output_string = '';
$output_string .= '<table  style="border: 0;"class="table table-striped">';
$output_string .= '<tr> <th>Email Mittente</th><th>Titolo</th><th>Testo Messaggio</th><th>Data di Invio</th><th style="border: 0;"></th></tr>' ;
while ($userRow = $stmt -> fetch(PDO::FETCH_ASSOC)) :
$output_string .= '<tr>';

$output_string .= '<td class="col-md-3">' . $userRow['Email_Mittente'] . '</td>';
$output_string .= '<td class="col-md-3">' . $userRow['Titolo'] . '</td>';
$output_string .= '<td class="col-md-3">' . $userRow['Testo_Messaggio'] . '</td>';
$output_string .= '<td class="col-md-3">' . $userRow['DataInvio'] . '</td>';
if($tipouser=="Amministratore"){
	$output_string .= '<td style="border: 0;" class="col-md-3"><div class="cancella" id="'.$userRow['Id_Messaggio'].'"><img src="/BasiDati/img/delete.png"></img></div></td>';
}else{
if($userRow['Tipo']=="Personale"){
$output_string .= '<td style="border: 0;" class="col-md-3"><div class="cancella" id="'.$userRow['Id_Messaggio'].'"><img src="/BasiDati/img/delete.png"></img></div></td>';		
}
}
$output_string .= '</tr>';


endwhile;
$output_string .= '</table>';
$output_string .= '<script type=\'text/javascript\' language=\'javascript\'>
$(\'.cancella\').click(function(){
    var id = $(this).attr(\'id\');
      $.ajax({
        url: \'/BasiDati/function/EliminaMsg.php\',
        type:\'POST\',
        data : "id=" + id
        }).done(function(){
                cambiaContenuto(\'inbox\');
            } ); 
         
});
</script>';
// This echo for jquery
echo json_encode($output_string);
?>