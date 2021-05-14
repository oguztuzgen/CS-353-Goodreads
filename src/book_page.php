<?php
require("template/header.php");
require('template/config.php');
?>
<?php
// echo $_SESSION['xd'];

// if book id not specified via get request
if (!isset($_GET['book_id'])) {
	echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
	die;
}

$book_id = $_GET['book_id'];

$sql = "select * from book where book_id = '$book_id';";

$result1 = mysqli_query($conn, $sql);

$book = mysqli_fetch_assoc($result1);
$cover = $book['book_cover'];


// !!!! JOIN QUERY TO GET GENRE NAME
$sql = "select genre_name from genre g, has_genre hg where g.genre_id = hg.genre_id and hg.book_id = '$book_id';";
$result = mysqli_query($conn, $sql);

?>

<br><br><br><br><br> <br>
<div class="row">
	<div class="col" style="width: 75%; margin-left: 20px;">
		<div>
			<?php echo '<form action="book_page.php?book_id=' . $_GET['book_id'] . '" method="POST">'; ?>

			<div class="row text blue lighten-4 valign-wrapper" style="padding: 10px; width:90%; ">
				<div class="col " style="width: 200px;">
					<?php
					echo '<img src="' . $cover . '" alt="Yoq" style="width: 100px; height:135px;">';

					?>
				</div>


				<div class="col " style="width: 450px;">
					<?php echo '<p>' . $book['title'] . '</p>'; ?>
					<?php echo '<p> by ' . $book['author'] . '</p>'; ?>
					<?php echo '<p> Page Count: ' . $book['page_count'] . '</p>'; ?>
					<?php echo '<p> Publish Date: ' . substr($book['date_published'], 0, -3) . '</p>'; ?>
					<?php echo '<p> Original Name: ' . $book['original_title'] . '</p>'; ?>
					<?php echo '<p> Language: ' . $book['language'] . '</p>'; ?>

				</div>


				<div class="col " style="width: 250px; height: 250px;">
					<p>Genres</p>

					<ul>
						<?php
						while ($genre = mysqli_fetch_assoc($result)) {
							echo '<li>';
							echo $genre['genre_name'];
							echo '</li>';
						}
						?>
					</ul>
				</div>




				<div class="col center" style="border:2px solid grey; width: 250px; padding: 10px; text-align:center; height: 100%">
					<?php echo '<p> Description: <br>' . $book['description'] . '</p>'; ?>
				</div>
				<div class="col center " style="border:2px solid grey; width: 250px; margin:auto; padding: 10px 10px 10px 10px;">
					<?php echo "<a href=\"book_log.php?book_id=$book_id\">See your logs</a>" ?>

					<!-- buraya tuş gelecek -->
				</div>

			</div>
		</div>

		<div class="row text blue lighten-4" style="padding: 30px; width:90%;">

			<div class="col s3" style="border: 3px solid black; text-align:left;">
				<p>Your Rating:</p>

				<div class="left-align">

					<div class="rating left-align">
						<span><input type="radio" name="rating" id="str5" value="5"><label for="str5"></label></span>
						<span><input type="radio" name="rating" id="str4" value="4"><label for="str4"></label></span>
						<span><input type="radio" name="rating" id="str3" value="3"><label for="str3"></label></span>
						<span><input type="radio" name="rating" id="str2" value="2"><label for="str2"></label></span>
						<span><input type="radio" name="rating" id="str1" value="1"><label for="str1"></label></span>
					</div>

					<script>
						$(document).ready(function() {
							$(".rating input:radio").attr("checked", false);

							$('.rating input').click(function() {
								$(".rating span").removeClass('checked');
								$(this).parent().addClass('checked');
							});

							document.cookie = "rating=" + 0;
							$('input:radio').change(
								function() {
									var userRating = this.value;
									document.cookie = "rating=" + userRating;
								});
						});
					</script>
				</div>
			</div>
			<div class="col s1">

			</div>
			<div class="col s8 blue lighten-2 vertical-align text center-align" style="border: 3px solid black; padding: 5px;">

				<input type="text" placeholder="Enter Your Rating Description..." class="text" name="reviewBox">
				<input type="submit" name="baban" class="btn blue lighten-1" value="Submit Review" style="margin:auto">
				<br>
				<?php // insertion to database
				if (isset($_POST['baban'])) {
					//echo ' ' . $_COOKIE["rating"];
					//echo ' ' . $_POST['reviewBox'];

					$sql = "insert into review (content, rating) values ('" . $_POST['reviewBox'] . "', " . $_COOKIE["rating"] . ");";
					if (mysqli_query($conn, $sql)) {
						//echo 'za';
					}

					$sql = "select max(review_id)
                from review;";
					$res = mysqli_query($conn, $sql);
					$rev_id = mysqli_fetch_array($res, MYSQLI_ASSOC);

					$sql = "insert into reviews(review_id, user_id, book_id) values (" . $rev_id['max(review_id)'] . ", " . $_SESSION['user_id'] . "," . $book_id . ");";
					if (mysqli_query($conn, $sql)) {
						//echo 'succesful insertion';
					}
				}
				?>
			</div>
		</div>

		<div class="row text blue lighten-4" style="padding: 10px; width:90%; border: 3px solid red;">

			<p>Reviews:</p>
			<table>
				<?php
				$sql = "select u.first_name, r.date_sent, r.content, r.rating, r.likes, u.profile_picture, u.user_id, r.review_id
        from reviews rw, review r, user u
        where rw.review_id = r.review_id and rw.book_id = " . $book_id . " and rw.user_id = u.user_id";
				$res = mysqli_query($conn, $sql);

				while ($review = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

					$uid = $review['user_id'];
					echo '<tr class="text">';
					echo '<form action="book_page.php?book_id=' . $_GET['book_id'] . '" method="POST">';



					echo '<td class="center" style="width: 150px;">';
					echo '<img src="' . $review['profile_picture'] . '" alt="Yoq" style="width: 100px; height:135px;">';
					echo '<br>';
					echo $review['date_sent'];
					echo '</td>';
					echo '<td class="center" style="width: 150px;">';
					echo '</td>';

					echo '<td class="" style="width:150px;">';

					echo "<a href=\"profile.php?uid=$uid\">Sent by: ";
					echo $review['first_name'];
					echo '</a>';
					echo '<pre class="text"> Rating: ';
					echo $review['rating'];
					echo '</pre>';

					echo '</td>';

					echo '<td class="" style="width:400px;">';
					echo $review['content'];
					echo '</td>';

					echo '<td class=" center" style="width: 250px;">';

					echo '<input type="submit" name="like" class="btn blue lighten-1" value="Like" style="margin:auto">';
					echo '<input type="hidden" name="review_id" value="' . $review['review_id'] . '">';
					echo '<input type="hidden" name="user_id" value="' . $review['user_id'] . '">';

					echo '<input type="submit" name="comment" class="btn blue lighten-1" value="Comment" style="margin:auto">';
					echo '<input type="hidden" name="review_id2" value="' . $review['review_id'] . '">';

					echo '</td>';
					echo '</form>';

					echo '<td class="center" style="width:100px;">';
					echo '</td>';
					echo '</tr>';


					$sql2 = "select u.profile_picture, u.first_name, u.karma, c.content, u.user_id, c.replied_to, c.message_id
						from user u, comment c
						where c.replied_to = " . $review['review_id'] . " AND u.user_id = c.user_id;";
					$res2 = mysqli_query($conn, $sql2);

					while ($comms = mysqli_fetch_array($res2, MYSQLI_ASSOC)) {
						$uid = $comms['user_id'];

						echo '<tr class="text" style="border: 3px solid grey;">';
						//echo '<form action="book_page.php?book_id=' . $_GET['book_id'] . '" method="POST">';

						echo '<td class="center" style="width: 100px;">';
						echo 'comment';
						echo '</td>';

						echo '<td class="center" style="width: 100px;">';
						echo '<img src="' . $comms['profile_picture'] . '" alt="Yoq" style="width: 100px; height:135px;">';
						echo '</td>';



						echo '<td class="center" style="width:100px;">';

						echo "<a href=\"profile.php?uid=$uid\">Sent by: ";
						echo $comms['first_name'];
						echo '</a>';
						echo '</td>';

						echo '<td class="" style="width:200px;">';
						echo $comms['content'];
						echo '</td>';

						echo '<td class=" center" style="width: 250px;">';
						echo '<input type="submit" name="comment2" class="btn blue lighten-1" value="Comment" style="margin:auto">';
						echo '<input type="hidden" name="review_id2" value="' . $comms['replied_to'] . '">';

						echo '</td>';

						echo '<td class="center" style="width:100px;">';
						echo '</td>';

						echo '</tr>';



						$sql3 = "select u.profile_picture, u.first_name, u.karma, c.content, u.user_id, c.replied_to_c
						from user u, comment c
						where c.replied_to_c = " . $comms['message_id'] . " AND u.user_id = c.user_id;";
						$res3 = mysqli_query($conn, $sql3);

						while ($comms2 = mysqli_fetch_array($res3, MYSQLI_ASSOC)) {
							$uid = $comms2['user_id'];

							echo '<tr class="text" style="border: 3px solid grey;">';
							//echo '<form action="book_page.php?book_id=' . $_GET['book_id'] . '" method="POST">';

							echo '<td class="center" style="width:100px;">';
							echo '</td>';
							echo '<td class="center" style="width: 100px;">';
							echo 'comment22';
							echo '</td>';

							echo '<td class="center" style="width: 100px;">';
							echo '<img src="' . $comms2['profile_picture'] . '" alt="Yoq" style="width: 100px; height:135px;">';
							echo '</td>';



							echo '<td class="center" style="width:100px;">';

							echo "<a href=\"profile.php?uid=$uid\">Sent by: ";
							echo $comms2['first_name'];
							echo '</a>';
							echo '</td>';

							echo '<td class="" style="width:200px;">';
							echo $comms2['content'];
							echo '</td>';

							echo '<td class=" center" style="width: 150px;">';
							echo '<input type="submit" name="No" class="btn blue lighten-1" value="Comment" style="margin:auto">';

							echo '</td>';

							echo '</tr>';
						}
					}

					echo '<tr class="text">';

					echo '</tr>';
				}
				?>

			</table>

			<?php


			// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! LIKE LA ALAKALI HICBIR SEY CALISMIYOR
			if (isset($_POST['like'])) {

				$rid = $_POST['review_id'];
				$u = $_POST['user_id'];
				$sql = "select count(*) from likes where review_id = $rid and user_id = $u";

				if (mysqli_fetch_assoc(mysqli_query($conn, $sql))['count(*)'] <= 0) {
					$boi = "update review set likes = likes + 1 where review_id = $rid;";
					mysqli_query($conn, $boi);

					$sql = "update user set karma = karma + 1 where user_id =" . $_POST['user_id'] . ";";
					mysqli_query($conn, $sql);

					$sql = "insert into likes(review_id, user_id) VALUES($rid, $u);";
					mysqli_query($conn, $sql);
				} else {
					// TODO ERROR MESSAGE CANNOT LIKE TWICE
				}
			}


			if (isset($_POST['comment'])) {
				$rid = $_POST['review_id2'];
				$u = $_SESSION['user_id'];
				$boi = "abcdefg";
				$comment = "insert into comment(user_id, replied_to, content) VALUES ( $u, $rid, \"$boi\");";
				if (mysqli_query($conn, $comment)) {
					//echo '<script>alert("Yes")</script>';
				} else {
					//echo '<script>alert("No ' . $comment .  '")</script>';
				}
			}

			if (isset($_POST['comment2'])) {
				$rep_id = $_POST['replied_to'];
				$u = $_SESSION['user_id'];
				$boi = "abcdefg 2";
				$comment = "insert into comment(user_id, replied_to, replied_to_c, content) VALUES ( $u, 149, $rep_id, \"$boi\");";
				if (mysqli_query($conn, $comment)) {
					//echo '<script>alert("Yes")</script>';
				} else {
					//echo '<script>alert("No ' . $comment .  '")</script>';
				}
			}

			if (isset($_POST['No'])) {
					echo '<script>alert("Sohbet odası mı bura")</script>';
			}
			?>

		</div>
		</form>
	</div>

	<div class="col blue lighten-4 text" style="width: 23%; ">
		<h3>Lists That Include This Book: </h3>
		<hr>
		<?php
		$sql = 'select distinct l.list_id, bl.title from lists l, book_list bl where l.book_id =' . $book_id . ' and l.list_id = bl.list_id ';
		$res = mysqli_query($conn, $sql);
		// echo $sql;
		// print_r($res);

		while ($bl = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

			echo '<a class="" style="text-decoration: underline; font-size:20px;" href="show_book_list.php?list_id=' . $bl['list_id'] . '">';
			echo $bl['title'];
			echo '</a>';
			echo '<br>';
			echo '<br>';
		}
		?>
	</div>

	<div class="col blue lighten-4 text" style="width: 23%; ">
		<h3>Series That Include This Book: </h3>
		<hr>
		<?php
		$sql = 'select distinct bl.series_id, s.series_name from belongs_to bl, series s where bl.book_id =' . $book_id . ' and bl.series_id = s.series_id ';
		$res = mysqli_query($conn, $sql);
		// echo $sql;
		// print_r($res);

		while ($bl = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

			echo '<a class="" style="text-decoration: underline; font-size:20px;" href="show_book_list.php?list_id=' . $bl['series_id'] . '">';
			echo $bl['series_name'];
			echo '</a>';
			echo '<br>';
			echo '<br>';
		}
		?>
	</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>