<?php
require_once("session.php");
	
	require_once("class.user.php");

$user = new USER();
    $stmt = $user->runQuery('SELECT id from Bici');
	$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<div class="form-group">
					<select name="maker" class="form-control" id="form-bici">
  					<?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<option value="<?php echo $userRow["id"] ?>"><?php echo $userRow["id"] ?></option>
					<?php endwhile; ?>
					<!-- <input name="form-bici" type="text" class="form-control" id="form-bici"> -->
					</select>	
				</div>
        
<!-- <select name="maker" class="form-control">
  <?php while ($userRow=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
<option value="<?php echo $userRow["id"] ?>"><?php echo $userRow["id"] ?></option>
<?php endwhile; ?>
</select>
<br> -->


</html>