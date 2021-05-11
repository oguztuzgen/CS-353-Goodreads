<?php
	require('template/config.php');
	if(!$conn){
		echo "Error in connection";
	}
	$sql = 'SELECT * FROM user WHERE email = "eray@gmail.com"';
	$res = mysqli_query($conn, $sql);
	$info = mysqli_fetch_array($res, MYSQLI_ASSOC);

	mysqli_free_result($res);
	mysqli_close($conn);

	/*
	echo "<pre>";
	print_r($info);
	echo "</pre>";
	*/

?>

	
<!DOCTYPE html>
<html>
	<?php require('template/header.php'); ?>
		<div class="container">
			<div class="row-100">
				<span style="position:relative; left:-130px; top:180px;">
					<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $info['profile_picture'] ).'"/>'; ?>
					<h2><?php echo htmlspecialchars($info['first_name']) . " " . htmlspecialchars($info['last_name'])?></h2>
					<h5><?php echo htmlspecialchars($info['karma']) . " " .  "karma" ?></h5>

				
				</span>

				<span style="position:relative; left:130px; top:180px;">
					<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $info['profile_picture'] ).'"/>'; ?>

					
				
				</span>
				
			</div>	
		</div>
	</body>				
	
</html>