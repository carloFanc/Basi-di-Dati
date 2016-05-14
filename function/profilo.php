<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM Utente WHERE Email=:umail");
	$stmt->execute(array(":umail"=>$umail));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>

	<head>
		
		<title>profilo</title>
		
		
	</head>

	<body>
		<div >
			<h1>Dati Profilo</h1>
			   
		 <div class="list-group">
  			<a  class="list-group-item"><b>Nome: </b><?php echo $userRow['Nome']; ?></a>
  			<a  class="list-group-item"><b>Cognome: </b><?php echo $userRow['Cognome']; ?></a>
  			<a  class="list-group-item"><b>Password: </b><?php echo $userRow['password']; ?></a>
  			<a  class="list-group-item"><b>Tipologia: </b><?php echo $userRow['Tipologia']; ?></a>
  			<a  class="list-group-item"><b>Data Nascita: </b><?php echo $userRow['Data_Nascita']; ?></a>
  			<a  class="list-group-item"><b>Luogo Nascita: </b><?php echo $userRow['Luogo_Nascita']; ?></a>
  			<a  class="list-group-item"><b>Indirizzo Residenza: </b><?php echo $userRow['Indirizzo_Residenza']; ?></a>
  			<a  class="list-group-item"><b>Telefono: </b><?php echo $userRow['Telefono']; ?></a>
		 </div>
		 <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Cancella Account</button>
		 </div>
		
		 <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog modal-sm">
         <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Cancella Account</h4>
        </div>
        <div class="modal-body">
          <p>Sicuro di voler eliminare questo account?</p>
        </div>
        <div class="modal-footer">
          <button align="left" type="button"  id="<?php echo $_SESSION['user_email']; ?>" class="btn btn-primary pull-left Rimuovi">Si</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
  <script type='text/javascript' language='javascript'>
$('.Rimuovi').click(function(){
    var id = $(this).attr('id');
      $.ajax({
        url: '/BasiDati/function/EliminaUtente.php',
        type:'POST',
        data : "id=" + id
        }).done(function(){
                window.location.href = '/BasiDati/logout.php?logout=true';
            } ); 
         
});
</script>
</body>

