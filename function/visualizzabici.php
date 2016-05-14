<?php
require_once ("../session.php");

require_once ("../class.user.php");
$auth_user = new USER();

$umail = $_SESSION['user_email'];

$stmt = $auth_user -> runQuery('SELECT * FROM Bici;');
$stmt -> execute();
?>
<body>
		<div >
			<h1 align="center">Bici</h1> 
			<?php if ($stmt->rowCount()!=0): ?>
            	<div>
  						           
  						<table class="table table-striped ">
    					<thead class="personale">
      					<tr>
      					  <th>Id</th>
      					  <th>Postazione Prelievo</th>
      					  <th>Marca</th>
      					  <th>Colore</th>
      					  <th>Anno Acquisizione</th>
     					 </tr>
    					</thead>
  		  						<tbody>
  		  							<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
      							<tr >
      							  <td class="col-md-3"><?php echo $userRow['Id']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Postazione_Prelievo']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Marca']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Colore']; ?></td>
     						      <td class="col-md-3"><?php echo $userRow['Anno_Acquisizione']; ?></td>
     							 </tr>
     							 <?php endwhile; ?>
      						  </tbody>
  						</table>
			   </div>
            <?php endif; ?>
          </div>
</body>
