<?php
error_reporting(0);
require('template/config.php');

if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

// retrieve everything from db
$uid = $_SESSION['user_id'];

?>



<html>

<body>
	<?php require('template/header.php'); ?>

	<div>
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
							echo "
								<tr>
									<td><img src=\"$img\" width=\"56\" height=\"64\"></td>
									<td>$title</td>
									<td>$author</td>
									<td>PROGRESS</td>
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
							echo "
								<tr>
									<td><img src=\"$img\" width=\"56\" height=\"64\"></td>
									<td>$title</td>
									<td>$author</td>
									<td>FINISH DATE</td>
								</tr>
							";
						}
						?>
					</table>
				</div>

			</div>
		</div>
	</div>



</body>

</html>