<?php
	require('template/header.php');
	if(!$conn){
		echo "Error in connection";
	}

	$uid = $_GET['uid'];
	$sql = 'SELECT * FROM user WHERE user_id = \'' . $uid .'\'';

	echo $sql;
	if ($res = mysqli_query($conn, $sql)) {
		$info = mysqli_fetch_array($res, MYSQLI_ASSOC);

		mysqli_free_result($res);
		$id = $info['user_id'][0];
		$sql1 = 'select * 
			from user u 
			WHERE u.user_id in (SELECT friend_id FROM friends f WHERE f.user_id ='. $id.');' ;
		$res1 = mysqli_query($conn, $sql1);
		$info1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
		mysqli_free_result($res1);
		mysqli_close($conn);
	} else {
		echo "<br><br><br><br><br>FATAL ERROR";
		die;
	}

?>

	
<!DOCTYPE html>
<html>

	<br><br><br>
		<div class="text">
			<div style = "position:relative; left:280px; top:120px;">
				<div class="centered">
						<?php $prof = $info['profile_picture']; echo "<img src=\"$prof\" width=\"250\" height=\"250\">"; ?>
						<h2><?php echo htmlspecialchars($info['first_name']) . " " . htmlspecialchars($info['last_name'])?></h2>
						<h5><?php echo htmlspecialchars($info['karma']) . " " .  "karma" ?></h5>
				
				</div>	
			</div>
		</div>
		<div class="text">
			<div style = "position:relative; left:1080px; top:-350px;">
				<div class = "centered">
					<h2><?php echo "FRIENDS" ?> </h2>
					<h5><?php foreach($info1 as $inf): ?> 
						<?php $prof = $inf['profile_picture']; echo "<a href=\"profile.php\"><img src=\"$prof\"width=\"150\" height=\"150\">"  ?> <br> 
						<?php echo htmlspecialchars($inf['first_name']) . " " . htmlspecialchars($inf['last_name']); ?><br> <?php 
					endforeach; ?></h5>

					
				</div>	
			</div>
		</div>

		
	</body>				
	
</html>