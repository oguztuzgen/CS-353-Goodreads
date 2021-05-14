<?php
require('template/header.php');
if (!$conn) {
	echo "Error in connection";
}

$uid = $_GET['uid'];
$sql = 'SELECT * FROM user WHERE user_id = \'' . $uid . '\'';

echo $sql;
if ($res = mysqli_query($conn, $sql)) {
	$info = mysqli_fetch_array($res, MYSQLI_ASSOC);

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


<!DOCTYPE html>
<html>

<br><br><br><br><br><br>
<br>


<div class="row white text" style="width: 60%; float:left; margin-left:30px; padding: 20px;">

	<div class="col">
		<?php $prof = $info['profile_picture'];
		echo "<img src=\"$prof\" width=\"250\" height=\"250\" alt='Bune'>"; ?>

		<h5 style="text-decoration:underline; margin-left: 25px;"> Biography:</h5>
		<div class="" style="margin-left: 25px; border: 3px solid grey; width: 300%; height: 100px;">
			<?php echo '<h6>' . $info['about'] . '</h6>'; ?>
		</div>

	</div>

	<div class="col">
		<?php
		echo '<h3>';
		echo $info['first_name'] . " " . $info['last_name'];
		echo '</h3>';

		echo '<h5>';
		echo $info['karma'] . " karma";
		echo '</h5>';
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
		echo "<img src=" . $friend['profile_picture'] . " width=\"125\" height=\"125\" onerror=this.src='uploads/IMG-609e419a2da3b2.02041658.jpg'>";
		echo '</div>';
		echo '<h6>' . $friend['first_name'] . " " . $friend['last_name'] . "</h6>";
		
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
	order by l.date
	limit 3';

	$result = mysqli_query($conn, $qry);


	$i = 0;
	while ($log = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

		if ($i >= 3) {
			break;
		}

		echo '<h6 style="margin-left:25px; font-size:18px"> <span style="color: red"> ' . $info['first_name'] . " " . $info['last_name'] . '</span> has read <span style="color: blue">' . $log['count'] . '</span> pages from the book ';

		echo '<span style="color: green">' . $log['title'] . '</span>';

		echo ' at date <span style="color: purple">';

		echo $log['date'] . '</span>';

		echo '</h6>';

		$i++;
	}
	?>

</div>

<div class="row" style="float: left; width: 60%; margin-left:30px;">
	<hr>
</div>

<div class="row white text" style="width: 60%; float:left; margin-left:30px; padding: 20px;">
	<h5 style="text-decoration:underline; margin-left: 25px;"> Book Clubs:</h5>
</div>



</body>

</html>