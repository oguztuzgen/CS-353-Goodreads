<?php
//require('template/config.php');
require('template/header.php');
if (!$conn) {
  echo "Error in connection";
}
$uid = $_GET['uid'];

$sql = "SELECT distinct u.user_id, u.first_name, u.last_name, u.profile_picture 
FROM user u, friends f 
WHERE u.user_id <> " . $uid . " and u.user_id not in (select fa.friend_id
													from friends fa
													where fa.user_id = " . $uid . ");";



if ($res = mysqli_query($conn, $sql)) {
  $info = mysqli_fetch_all($res, MYSQLI_ASSOC);

  mysqli_free_result($res);

  //mysqli_close($conn);
} else {
  
  echo "<br><br><br><br><br>FATAL ERROR ";
  die;
}
?>

<?php
// add friend
if (isset($_POST['add_fren'])) {
  $frenId =  $_POST['frenId'];
  
  $sql2 = "insert into friend_requests (send_user, recieve_user) values(".$uid ." , " .$frenId ." );";

  //$sql2 = "insert into friends (user_id, friend_id) values(" . $uid. ", ". $frenId . ");";
  // echo $sql2;

  mysqli_query($conn, $sql2);
  header("Location: addfriend.php?uid=$uid");

}
?>

<!DOCTYPE html>
<br><br><br><br><br><br><br><br>

<div class="row text blue lighten-4" style="width: 70%; padding: 10px;">
    <form action="" method="POST" style="margin:auto;">
      <div class="col s8" style="padding: 20px; ">
        <input type="text" placeholder="Search a user...">
      </div>
      <div class="col s4" style="padding: 20px; float:left;">
        <input class="btn indigo lighten-2" type="submit" value="Search">
      </div>
    </form>
</div>

<div class="row text blue lighten-4 center" style="width: 70%;">

  <?php foreach ($info as $inf) : ?>
    <div class="col" style="padding: 10px; width:160px; margin: 10px;">
      <?php $prof = $inf['profile_picture'];
      $id = $inf['user_id'];
      echo "<img src=\"$prof\" data-id=\"'.$id.\"  width=\"150\" height=\"150\" onerror=this.src='../image/profile_placeholder.jpg'>"; ?>

      <a href="profile.php?uid=<?php echo $id ?>"> <?php echo htmlspecialchars($inf['first_name']) . " " . htmlspecialchars($inf['last_name']) ?>  </a>
      

      <form method="POST" style="padding: 10px;">
        <input type="hidden" value="<?php echo $id; ?>" name="frenId">
        <input class="btn blue lighten-3" type="submit" name="add_fren" value="Add friend" id="user">
      </form>

    </div>
  <?php endforeach; ?>

</div>



</body>

</html>