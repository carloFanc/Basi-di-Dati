<?php

	require_once("../session.php");
	
	require_once("../class.user.php");
	$auth_user = new USER();
	
	
	$umail = $_SESSION['user_email'];
	
	$stmt = $auth_user->runQuery('CALL ListaUtenti()');
	$stmt->execute();
	

?>

	<body>
		<div > 
			<h1 align="center">Lista Utenti</h1> 
			
            	<div>
  						
<div class="btn-group" data-toggle="buttons" id="toggleColumns"  style="width: 870px;">
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="1"/> Email
    </label>
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="2"/> Nome
    </label>
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="3"/> Cognome
    </label>
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="4"/> Password
    </label>
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="5"/> Tipologia
    </label>
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="6"/> Data Nascita
    </label>    
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="7"/> Luogo Nascita
    </label> 
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="8"/> Indirizzo Residenza
    </label> 
    <label class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="9"/> Telefono
    </label> 
    <label style="background-color:red" class="btn btn-primary active">
        <input type="checkbox" checked="checked"
               value="10"/> Del
    </label> 
</div>        
<div class="row resizeRow">
  						<table class="table table-striped">
    					<thead class="personale">
      					<tr>
      					  <th class="1">Email</th>
      					  <th class="2">Nome</th>
      					  <th class="3">Cognome</th>
      					  <th class="4">Password</th>
      					  <th class="5">Tipologia</th>
      					  <th class="6">Data Nascita</th>
      					  <th class="7">Luogo Nascita</th>
      					  <th class="8">Indirizzo Residenza</th>
      					  <th class="9">Telefono</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr>
           						  <td class="1"><?php echo $userRow['Email']; ?></td>
     						      <td class="2"><?php echo $userRow['Nome']; ?></td>
     						      <td class="3"><?php echo $userRow['Cognome']; ?></td>
     						      <td class="4"><?php echo $userRow['password']; ?></td>
     						      <td class="5"><?php echo $userRow['Tipologia']; ?></td>
     						      <td class="6"><?php echo $userRow['Data_Nascita']; ?></td>
     						      <td class="7"><?php echo $userRow['Luogo_Nascita']; ?></td>
     						      <td class="8"><?php echo $userRow['Indirizzo_Residenza']; ?></td>
     						      <td class="9"><?php echo $userRow['Telefono']; ?></td>
     						      <?php if($umail != $userRow['Email']): ?>
     						      <td class="10" style="border: 0;" class="col-md-3"><div class="cancella" id="<?php echo $userRow['Email']; ?>"><img src="/BasiDati/img/delete.png" ></img></div></td>
     						      <?php endif; ?>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
               </div>
          </div>
          <script>
          
 $("#toggleColumns input").change(function() {   
  
  $('.'+this.value).toggle(); 
});

</script>
<script type='text/javascript' language='javascript'>
$('.cancella').click(function(){
    var id = $(this).attr('id');
      $.ajax({
        url: '/BasiDati/function/EliminaUtente.php',
        type:'POST',
        data : "id=" + id
        }).done(function(){
                cambiaContenuto('listautenti');
            } ); 
         
});
</script>
</body>