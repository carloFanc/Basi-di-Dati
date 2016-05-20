<?php
require_once ("../session.php");

require_once ("../class.user.php");
$auth_user = new USER();

$umail = $_SESSION['user_email'];

$stmt = $auth_user -> runQuery("SELECT * FROM Utente WHERE Email=:umail");
$stmt -> execute(array(":umail" => $umail));

$userRow = $stmt -> fetch(PDO::FETCH_ASSOC);
?>

	<head>
		<style>
			.Mostra {
				padding: 10px 10px 10px 36px;
				font-family: "Trebuchet MS", Arial, Verdana;
				background: #e9e9e9 url(./img/foto.png) 10px 10px no-repeat;
				border-radius: 16px;
				border: 1px solid #d9d9d9;
				text-shadow: 1px 1px #fff;
			}
			<style>
</style>
	</style>
		<title>profilo</title>
		<link href="css/bootstrap-dialog.min.css" rel="stylesheet"> 
		
	</head>

	<body>
		<div >
			<div> 
			<div align="left"><h1 align="center">Dati profilo</h1></div>
			<div align="right"><?php if($userRow['Foto']!=""):?><td class="col-md-3"><button type="button" data-toggle="modal2" class="Mostra" data-target="#myModal" id="<?php echo $userRow['Foto']; ?>">Foto</button></td>
     			                  <?php else: ?><td class="col-md-3" ><img src="./img/noButton.jpg"></td>
     						      <?php endif; ?></div>
			</div>
			
			  
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
		 <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2">Cancella Account</button>
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
	$('.Mostra').click(function() {
		var id = $(this).attr('id');

		var html = "<img src=\".\/uploads\/utenti\/>";
		var $textAndPic = $('<div></div>');
		$textAndPic.append('<img width="555px" src="./uploads/utenti/' + id + '" />');

		BootstrapDialog.show({
			title : 'Foto Utente',
			message : $textAndPic,
			buttons : [{
				label : 'Close',
				action : function(dialogRef) {
					dialogRef.close();
				}
			}],
		});

	}); 
</script>
  <script type='text/javascript' language='javascript'>
	$('.Rimuovi').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url : '/BasiDati/function/EliminaUtente.php',
			type : 'POST',
			data : "id=" + id
		}).done(function() {
			window.location.href = '/BasiDati/logout.php?logout=true';
		});

	}); 
</script>
<script src="js/bootstrap-dialog.min.js"></script>
</body>

