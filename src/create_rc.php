<!DOCTYPE html>
<html>
<?php
require('template/header.php');
require('template/config.php');


if (!($_SESSION['isAdmin'])) {
	echo "<br><br><br><br><br><h1>FORBIDDEN</h1>";
	die;
}

$search = $name_error = "";

if (isset($_POST['search_btn'])) {
	$search = $_POST['search'];
}

$rc_id = $_GET['rc_id'];

if (isset($_POST['add'])) {
	$book_id = $_POST['book_id'];
	$sql =
		"INSERT INTO rc_books(rc_id, book_id)
		 VALUES($rc_id, $book_id)";

	mysqli_query($conn, $sql);
}

if (isset($_POST['submit'])) {
	if (empty($_POST['rc_name'])) {
		$name_error = "Please enter a rc name";
	} else {
		$rc_title = $_POST['rc_name'];
		$sql = "UPDATE reading_challenge SET subject = '$rc_title' WHERE rc_id = $rc_id;";
		mysqli_query($conn, $sql);
	}

	// if (empty($_POST['rc_description'])) {
	// 	$_POST['rc_description'] = "No description";
	// }

	// $title = $_POST['rc_description'];
	//$sql = "UPDATE book_list SET description = '$description' WHERE book_list.list_id = $list_id;";

	//mysqli_query($conn, $sql);
	header('Location: reading_challenges.php');

}

$sql = "SELECT b.title as book_title, b.author, b.book_id, b.book_cover, rc.subject as rc_name
FROM book b, reading_challenge rc, rc_books rcb
WHERE b.book_id = rcb.book_id and rcb.rc_id = rc.rc_id and rc.rc_id = $rc_id";


if ($result = mysqli_query($conn, $sql)) {
	$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if (!empty($result)) {
		//$user_name = $result[0]['first_name'] . " " . $result[0]['last_name'];
	}
} else {
	echo "SQL SYNTAX ERROR" . mysqli_error($conn);
}
?>

<div>
	<?php echo "<form action='create_rc.php?rc_id=$rc_id' method=\"POST\">"; ?>
	<div style="padding: 150px 7%;" class="col s11">
		<div class="brand-dark row">
			<div class="brand col s5" style="margin: 50px">
				<div>
					<div class="col s6">
						<?php $rc_title = $result[0]['subject'] ?? '';
						echo "<input name=\"rc_name\" value=\"$rc_title\" type=\"text\" class=\"text\" style=\"width: 50%; margin-top: 15px; margin-left: 10px;\" placeholder=\"RC name...\">"; ?>
						<br><label style="margin-left:12px">Reading Challenge name</label>
						<?php echo "<p class=\"red-text\">$name_error</p>"; ?>
					</div>
					
				</div>

				<div style="padding-top: 100px">
					<table class="brand" style="margin: 10px;">
						<thead>
							<tr>
								<th></th>
								<th>Title</th>
								<th>Author</th>
							</tr>
						</thead>

						<tbody>
							<!-- PHP CODE HERE FOREACH QUERY RESULT -->
							<?php

							if (!$result) {
								$result = array();
							}
							foreach ($result as $book) {
								$img = $book['book_cover'];
								$title = $book['book_title'];
								$author = $book['author'];
								echo "
										<tr>
										<th><img src=\"$img\" width=\"56\" height=\"64\"></th>
										<th>$title</th>
										<th>$author</th>
										</tr>
									";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- RIGHT HAND SIDE -->
			<div class="col s5">
				<input type="submit" style="float: right; margin-top: 5px;" class="btn brand-btn" id="submit" name="submit" value="Submit">
				<div style="margin-top: 50px;">
					<div class="text brand-text-alt">Search</div>

					<div>
						<input type="text" class="text" name="search" style="float: left; width: 50%;" placeholder="Enter search parameter...">
						<input type="submit" class="btn brand-btn" style="float: right;" name="search_btn" value="Search">
						<!-- </form> -->
					</div>

					<table class="brand" style="margin: 10px;">
						<thead>
							<tr>
								<th></th>
								<th>Title</th>
								<th>Author</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							<!-- PHP CODE HERE FOREACH QUERY RESULT -->
							<?php

							$sql =
								"SELECT * 
                                FROM book b1 
                                WHERE b1.book_id not in (
                                        SELECT b.book_id
                                        FROM book b, rc_books rcb, reading_challenge rc
                                        WHERE b.book_id = rcb.book_id and rc.rc_id = rcb.rc_id and rc.rc_id = $rc_id );";

							if ($res = mysqli_query($conn, $sql)) {

								$books = mysqli_fetch_all($res, MYSQLI_ASSOC);

								foreach ($books as $book) {


									if (
										strpos($book['title'], $search) !== false
										|| strpos($book['author'], $search) !== false
									) {

										$img = $book['book_cover'];
										$title = $book['title'];
										$author = $book['author'];
										$book_id = $book['book_id'];
										echo "
											<form action=\"create_rc.php?rc_id=$rc_id\" method=\"POST\">
											<tr>
												<th><img src=\"$img\" width=\"56\" height=\"64\"></th>
												<th>$title</th>
												<th>$author</th>
												<th><input type=\"submit\" name=\"add\" class=\"btn brand-btn\" value=\"Add\"</th>
												<input type=\"hidden\" name=\"book_id\" value=$book_id>
											</tr>
											</form>
										";
									}
								}
							} else {
								echo mysqli_error($conn);
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
	</form>
</div>
</body>

</html>