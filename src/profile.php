<?php
	require('template/config.php');
	if(!$conn){
		echo "Error in connection";
	}
	$sql = 'SELECT * FROM user WHERE email = "oguz@gmail.com"';
	$res = mysqli_query($conn, $sql);
	$info = mysqli_fetch_all($res, MYSQLI_ASSOC);

	mysqli_free_result($res);
	mysqli_close($conn);
	print_r($info);
?>

	
<!DOCTYPE html>
<html>
	<?php require('template/header.php'); ?>
		<div class="container">
			<div class="row">
				<h2><?php echo htmlspecialchars($info['first_name']) . " " . htmlspecialchars($info['last_name'])?></h2>
			</div>
			
				
		</div>				
	
</html>