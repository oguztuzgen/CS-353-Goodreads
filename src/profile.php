<?php
require('template/header.php');
if (!$conn) {
	echo "Error in connection";
	die;
}


$uid = $_GET['uid'];
$sql = 'SELECT * FROM user WHERE user_id = \'' . $uid . '\'';

if (isset($_POST['edit_profile'])) {
	// send somewhere else
	header("Location: edit_profile.php?user_id=$uid");
}

echo $sql;
if ($res = mysqli_query($conn, $sql)) {
	$info = mysqli_fetch_array($res, MYSQLI_ASSOC);

	$critic = $info['critic'];
	$author = $info['author'];
	//mysqli_free_result($res);
	$id = $info['user_id'][0];
	$sql1 = 'select * 
			from user u 
			WHERE u.user_id in (SELECT friend_id FROM friends f WHERE f.user_id =' . $id . ');';
	$res1 = mysqli_query($conn, $sql1);
	$info1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
	//mysqli_free_result($res1);
	//mysqli_close($conn);
} else {
	echo "<br><br><br><br><br>FATAL ERROR";
	die;
}

?>
<?php
if (isset($_POST['remove'])) {
	//echo $_POST['fr_id'];

	$sql = "delete from friends where friend_id = " . $_POST['fr_id'] . " and user_id = " . $uid . " ;";
	mysqli_query($conn, $sql);

	/* delete from the other user too */
	$sql = "delete from friends where friend_id = " . $uid . " and user_id = " . $_POST['fr_id'] . " ;";
	mysqli_query($conn, $sql);

	header("Location: profile.php?uid=$uid");
}
?>

<!DOCTYPE html>
<html>

<br><br><br><br><br><br>
<br>


<div class="row white text" style="width: 60%; float:left; margin-left:30px; padding: 20px;">
	<?php echo "<form action=\"profile.php?uid=$uid\" method=\"post\">"; ?>


	<div class="col">
		<div class="col">
			<?php $prof = $info['profile_picture'];
			echo "<img src=\"$prof\" width=\"250\" height=\"250\" alt='Bune'>"; ?>
		</div>

		<div class="col" style="margin-left: 12px;">
			<h5 style="text-decoration:underline; margin-left: 25px;"> Biography:</h5>
			<div class="" style="margin-left: 25px; border: 3px solid grey; width: 100%; height: 100px;">
				<?php echo '<h6>' . $info['about'] . '</h6>'; ?>
			</div>
		</div>


	</div>

	<div class="row">

	</div>
	<div class="col">
		<?php
		echo '<h3>';
		echo $info['first_name'] . " " . $info['last_name'];
		echo '</h3>';
		if ($critic) {
			echo '<h3>';
			echo '<span style="color:red; text-decoration:underline;" > *Critic* </span>';
			echo '</h3>';
		}

		if ($author) {
			echo '<h3>';
			echo '<span style="color:blue; text-decoration:underline;" > *Author* </span>';
			echo '</h3>';
		}

		echo '<h5>';
		echo $info['karma'] . " karma";
		echo '</h5>';
		?>

		<?php

		if (!isset($_SESSION['user_id'])) {
			// DO NOTHING
		} else if ($_SESSION['user_id'] == $uid) { // if logged in user
			echo "
				<div class=\"col\">
					<input type=\"submit\" name=\"edit_profile\" class=\"btn brand-btn\" value=\"Edit Profile\">
				</div>
			";
		} else if (isset($_SESSION['user_id'])) { // if not the logged in user
			echo "
				<div class=\"col\">
					<input type=\"submit\" name=\"friend\" class=\"btn brand-btn\" value=\"Add Friend\">
				</div>
			";
		}
		?>
	</div>
</div>

<div class="row white text" style="width: 35%; float:right; margin-right:30px; padding: 20px;">
	<h5 style="text-decoration:underline; margin-left: 25px;"> Friends</h5>

	<?php
	$qry = 'select *
		from user u, friends f
		where f.user_id = ' . $uid .  ' and u.user_id = f.friend_id';

	$result = mysqli_query($conn, $qry);

	while ($friend = mysqli_fetch_array($result)) {

		echo '<div class="col center" style="padding: 10px; margin:25px;">';
		echo '<div style="width:125; height:125;">';
		echo "<img src=" . $friend['profile_picture'] . " width=\"125\" height=\"125\" onerror=this.src='../image/profile_placeholder.jpg'>";
		echo '</div>';
		echo '<h6>' . $friend['first_name'] . " " . $friend['last_name'] . "</h6>";
	?>
		<form action="" method="POST">
			<input type="hidden" value="<?php echo $friend['friend_id']; ?>" name="fr_id">

			<input type="submit" class="btn" value="Remove Friend" name="remove">
		</form>
	<?php
		echo '</div>';
	}
	?>


</div>



<div class="row" style="float: left; width: 60%; margin-left:30px;">
	<hr>
</div>

<div class="row white text" style="width: 60%; float:left; margin-left:30px; padding: 20px;">

	<h5 style="text-decoration:underline; margin-left: 25px;"> Latest Logs:</h5>

	<?php

	$qry = 'select l.count, b.title, l.date
	from logs l, book b
	where l.user_id = ' . $uid . ' and l.book_id = b.book_id
	order by l.date DESC 
	limit 5';

	$result = mysqli_query($conn, $qry);


	$i = 0;
	while ($log = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

		echo '<h6 style="margin-left:25px; font-size:18px"> <span style="color: red"> ' . $info['first_name'] . " " . $info['last_name'] . '</span> has read <span style="color: blue">' . $log['count'] . '</span> pages from the book ';

		echo '<span style="color: green">' . $log['title'] . '</span>';

		echo ' at date <span style="color: purple">';

		echo $log['date'] . '</span>';

		echo '</h6>';

		$i++;
	}
	?>

</div>

<div class="row white text" style="width: 35%; float:right; margin-right:30px; padding: 20px;">
	<h5 style="text-decoration:underline; margin-left: 25px;"> Reading Challenge Wins:
		<?php
		$quer = "select wins from user where user_id = $uid ;";
		$resultt = mysqli_query($conn, $quer);

		$win = mysqli_fetch_array($resultt);
		?>
		<span style="color:red;"><?php echo $win['wins']; ?> </span>
	</h5>

	<h5 style="text-decoration:underline; margin-left: 25px;">Participated Reading Challenges:</h5>

	<?php
	$quer = "select * from rc_participates rc, reading_challenge rcs where rc.user_id = $uid and rcs.rc_id = rc.rc_id;";
	$resultt = mysqli_query($conn, $quer);

	while ($rc = mysqli_fetch_array($resultt)) {
	?>

		<h5 style="margin-left: 25px;"><?php echo $rc['subject'];  ?></h5>

	<?php } ?>

</div>

<div class="row" style="float: left; width: 60%; margin-left:30px;">
	<hr>
</div>



<div class="row white text" style="width: 60%; float:left; margin-left:30px; padding: 20px;">
	<h5 style="text-decoration:underline; margin-left: 25px;"> Recommended by Friends</h5>

	<?php
	$sql = "select *
		from (select distinct book_id from recommends where friend_id = $uid) as c, book b
		where c.book_id = b.book_id ;";

	$res = mysqli_query($conn, $sql);

	while ($bok = mysqli_fetch_array($res)) {
	?>
		<div class="col center" style="width: 397px; height: 200px; border: 2px solid grey; padding: 10px;">
			<img src="<?php echo $bok['book_cover']; ?>" alt="" style="width: 120px; height: 135px;" onerror=this.src="../image/cover_placeholder.png">
			<h6> <?php echo $bok['title']; ?> </h6>
		</div>
	<?php
	}
	?>

</div>
<div class="row white text" style="width: 35%; float:right; margin-right:30px; padding: 20px;">
	<h5 style="text-decoration:underline; margin-left: 25px;"> Book Clubs:</h5>
</div>
</form>

</body>

</html>