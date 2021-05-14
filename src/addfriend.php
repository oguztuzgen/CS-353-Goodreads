<?php
    require('template/config.php');
    require('template/header.php');
    if(!$conn){
		echo "Error in connection";
	}
    $uid = $_GET['uid'];

    $sql = "SELECT user_id, first_name, last_name, profile_picture FROM user WHERE user_id <> '.$uid.'";
    if ($res = mysqli_query($conn, $sql)) {
		$info = mysqli_fetch_all($res, MYSQLI_ASSOC);

		mysqli_free_result($res);
		
		mysqli_close($conn);
	} else {
		echo "<br><br><br><br><br>FATAL ERROR";
		die;
	}

    
?>

<!DOCTYPE html>
<br><br><br><br><br><br><br><br> selam as napıyon php icinden data attribute erisilmiyomus onu halletmeye çalışıyorum

<div class="container">

    <table id = 'usersTable' class = 'table' >

    </table>


</div>



<h5><?php foreach($info as $inf): ?>
  <div class="user">
    <br> <?php  $prof = $inf['profile_picture']; $id = $inf['user_id']; echo "<img src=\"$prof\" data-id=\"'.$id.\"  width=\"150\" height=\"150\"> ";?> 
    <?php echo htmlspecialchars($inf['first_name']) . " " . htmlspecialchars($inf['last_name']); ?> 
  <!-- POSTLA HALLEDERSIN BACKEND KISMINI -->
    <form method="post" onclick="returnId()">
      <input type="submit" name="add_fren" value="Add friend">
    </form>     
    <?php endforeach; 
  ?></h5>
  </div>
<body>

<script>
function returnId(){
  var list = document.getElementsByClassName('user');

  for (var i = 0; i < list.length; i++) {
    var src = list[i].getAttribute( 'data-id');
    console.log("THE WINNER IS ");
  }
}
  
</script>

</body>

</html>