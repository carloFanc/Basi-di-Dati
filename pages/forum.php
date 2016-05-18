<?php

require_once ("../session.php");

require_once ("../class.user.php");
$auth_user = new USER();

$umail = $_SESSION['user_email'];
$tipouser= $_SESSION['user_tipologia'];
$stmt = $auth_user -> runQuery('CALL VisualizzaForum()');
$stmt -> execute();
?>
	<body>
		<div >
			<h1 align="center">Messaggi Forum</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div >    
  						<table class="table table-striped table-hover table-condensed">
    					<thead class="personale">   
      					<tr>
      					  <th>Email Mittente</th>
      					  <th>Titolo</th>
      					  <th>Testo Messaggio</th>
      					  <th>Data Inserimento</th>
     					 </tr>
    					</thead>
    						<tbody>
    							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
     							 <tr>
     							 	  <td align="left" class="col-md-3"><?php echo $userRow['EmailUtente']; ?></td>
      								  <td align="left" class="col-md-3"><?php echo $userRow['Titolo']; ?></td>
      							      <td align="left" class="col-md-3"><?php echo $userRow['Testo_Messaggio']; ?></td>
       								  <td align="left" class="col-md-3"><?php echo $userRow['Data_Inserimento']; ?></td>
       								 <?php if($tipouser=="Amministratore"): ?>
                                       <td style="border: 0;" class="col-md-3"><div class="cancella" id="<?php echo $userRow['Id']; ?>"><img src="/BasiDati/img/delete.png"></img></div></td>	
                                    <?php endif; ?>			
      							 </tr>
      							  <?php endwhile; ?>
                            </tbody>
                        </table>
                </div>
              <?php endif; ?>
          </div>
     </body>
<script type='text/javascript' language='javascript'>
$('.cancella').click(function(){
    var id = $(this).attr('id');
      $.ajax({
        url: '/BasiDati/function/EliminaPost.php',
        type:'POST',
        data : "id=" + id
        }).done(function(){
                cambiaContenuto('forum');
            } ); 
         
});
</script>