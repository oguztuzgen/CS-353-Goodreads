<?php
error_reporting(0);
require('template/config.php');

if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

// retrieve everything from db
$uid = $_SESSION['user_id'];


if (isset($_POST['remove'])) {
	$book_id = $_POST['book_id'];

	$sql = "DELETE FROM read_list WHERE book_id=$book_id";

	if (mysqli_query($conn, $sql)) {
	} else {
		echo "SQL ERROR";
	}
}

?>



<html>

<body>
	<?php require('template/header.php');
	require('template/style.php');
	?>
	<div>
		<form action="my_books.php" method="post">
			<div class="brand-dark brand-text-alt row">
				<div style="padding: 150px 7%;" class="col s11">

					<div class="col s4">
						<h4 class="center">Want to read</h4>
						<?php

						$sql = "SELECT * FROM read_list rl, book b WHERE rl.user_id = $uid AND b.book_id=rl.book_id AND status = 'WANT'";
						$books = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

						?>
						<table>
							<?php
							foreach ($books as $book) {
								$img = $book['book_cover'];
								$title = $book['title'];
								$author = $book['author'];
								echo "
								<tr>
									<td><img src=\"$img\" width=\"56\" height=\"64\"></td>
									<td>$title</td>
									<td>$author</td>
									<td><input type=\"submit\" name=\"remove\" value=\"remove\" class=\"btn brand-btn\" font-family: Oswald;\"></td>
									<input type=\"hidden\" name=\"book_id\" value=\"" . $book['book_id'] . "\">
								</tr>
							";
							}
							?>
						</table>
					</div>
					<div class="col s4">
						<h4 class="center">Currently reading</h4>
						<?php

						$sql = "SELECT * FROM read_list rl, book b WHERE rl.user_id = $uid AND b.book_id=rl.book_id AND status = 'READING'";
						$books = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
						?>
						<table>
							<?php

							foreach ($books as $book) {
								$img = $book['book_cover'];
								$title = $book['title'];
								$author = $book['author'];

								$sql = "SELECT sum(count) as total_read FROM logs WHERE user_id = " . $_SESSION['user_id'] . " and book_id = ". $book['book_id'];
								
								if ($result = mysqli_query($conn, $sql)) {
									$result = mysqli_fetch_assoc($result)['total_read'];
									$progress = $result / $book['page_count'] * 100;

								} else {
									echo "SQL ERROR";
									die;
								}

								echo "
								<tr>
									<td><img src=\"$img\" width=\"56\" height=\"64\"></td>
									<td>$title</td>
									<td>$author</td>
									<td>% " . round($progress, 1) . " </td>
								</tr>
							";
							}
							?>
						</table>

					</div>
					<div class="col s4">
						<h4 class="center">Finished reading</h4>
						<?php
						$sql = "SELECT * FROM read_list rl, book b WHERE rl.user_id = $uid AND b.book_id=rl.book_id AND status = 'FINISHED'";
						$books = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
						?>
						<table>
							<?php
							foreach ($books as $book) {
								$img = $book['book_cover'];
								$title = $book['title'];
								$author = $book['author'];

								$sql='select max(date) as date
								from logs
								where user_id ='. $_SESSION['user_id'] .' and book_id= ' . $book['book_id'] .';';

								if ($result = mysqli_query($conn, $sql)) {
								} else {
									echo "SQL SYNTAX ERROR";
									die;
								}


								$result = mysqli_fetch_assoc($result);

								echo "
								<tr>
									<td><img src=\"$img\" width=\"56\" height=\"64\"></td>
									<td>$title</td>
									<td>$author</td>
									<td>" . substr( $result['date'], 0, -8) . "</td>
								</tr>
							";
							}
							?>
						</table>
					</div>

				</div>
			</div>
		</form>
	</div>



</body>

</html>