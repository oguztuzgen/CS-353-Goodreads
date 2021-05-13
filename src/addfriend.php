<?php
    require('template/config.php');
    require('template/header.php');
    if(!$conn){
		echo "Error in connection";
	}
    $uid = $_GET['uid'];

    $sql = "SELECT user_id, first_name, last_name, profile_picture FROM user";
    if ($res = mysqli_query($conn, $sql)) {
		$info = mysqli_fetch_all($res, MYSQLI_ASSOC);

		mysqli_free_result($res);
		
		mysqli_close($conn);
	} else {
		echo "<br><br><br><br><br>FATAL ERROR";
		die;
	}

    
?>
<br><br><br><br><br><br><br><br>
<div class="container">

    <table>
         	<h5><?php foreach($info as $inf): ?>
            <?php  $prof = $inf['profile_picture']; $id = $inf['user_id']; echo "<img src=\"$prof\" data-id=\"'.$id.\"  width=\"150\" height=\"150\">";?> 
						<!-- POSTLA HALLEDERSIN BACKEND KISMINI -->
            <form method="post" action="addfriend.php">
                <input type="submit" name="add_fren" value="Add friend"> 
            </form>
            <?php echo htmlspecialchars($inf['first_name']) . " " . htmlspecialchars($inf['last_name']); ?> 
            <?php endforeach; ?></h5>
    </table>


</div>