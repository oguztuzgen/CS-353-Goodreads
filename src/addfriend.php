<?php
//require('template/config.php');
require('template/header.php');
if (!$conn) {
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
<br><br><br><br><br><br><br><br>
<div class="row text blue lighten-4 center" style="width: 70%;">
  <form action="">
    <div class="col">
      <input type="text" placeholder="Search a user...">
    </div>
    <div class="col">

    </div>
  </form>
</div>

<div class="row text blue lighten-4 center" style="width: 70%;">

  <?php foreach ($info as $inf) : ?>
    <div class="col" style="padding: 10px; width:160px; margin: 10px;">
      <?php $prof = $inf['profile_picture'];
      $id = $inf['user_id'];
      echo "<img src=\"$prof\" data-id=\"'.$id.\"  width=\"150\" height=\"150\" onerror=this.src='../image/profile_placeholder.jpg'>"; ?>
      <?php echo htmlspecialchars($inf['first_name']) . " " . htmlspecialchars($inf['last_name']); ?>

      <form method="POST" style="padding: 10px;">
        <input type="hidden" value="<?php echo $id; ?>" name="frenId">
        <input class="btn blue lighten-3" type="submit" name="add_fren" value="Add friend" id="user">
      </form>

    </div>
  <?php endforeach; ?>

</div>

<?php
if (isset($_POST['add_fren'])) {
  echo $_POST['frenId'];
}
?>

</body>

</html>