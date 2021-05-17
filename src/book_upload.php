<?php
// TODO ADD GENRE FROM BOOK UPLOAD

// initialize session var and connect to db
require('template/header.php');

if ($_SESSION['login'] == 0) {
	echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
	die;
}

if (!isset($_SESSION['critic'])) {
	header('Location: index.php');
}

$allowed_extensions = array('jpg', 'jpeg', 'png');
$submit_param = array('book_title', 'book_author', 'book_description', 'page_count', 'published_month_year', 'book_isbn', 'book_edition', 'book_translator');
$image_error = ""; 
$errors = array('book_title' => '', 'book_author' => '', 'book_description' => '', 'page_count' => '', 'published_month_year' => '', 'book_isbn' => '', 'book_edition' => '', 'book_translator' => '');
$book_title = $book_author = $book_description = $page_count = $published_month_year = $book_isbn = $book_language = $upload_path = $book_edition = $book_translator = "";

if (isset($_POST['submit'])) {
	foreach ($submit_param as $param => $value) {
		if (empty($_POST[$value])) {
			$errors[$value] = "This field is required <br>";
		}
	}

	if (!filter_var($_POST['page_count'], FILTER_VALIDATE_INT) || intval($_POST['page_count']) <= 0) {
		$errors['page_count'] = "Please enter a valid page count";
	}

	if (!filter_var($_POST['book_edition'], FILTER_VALIDATE_INT) || intval($_POST['book_edition']) <= 0) {
		$errors['book_edition'] = "Please enter a valid integer";
	}

	if (isset($_FILES['image'])) {
		$img_name = $_FILES['image']['name'];
		$img_size = $_FILES['image']['size'];
		$tmp_name = $_FILES['image']['tmp_name'];
		$error = $_FILES['image']['error'];

		if ($error === 0) {
			if ($img_size > 2125000) {
				$image_error = "File too large";
				$upload_path = '../image/cover_placeholder.png';
			} else {
				$img_ex = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
				if (in_array($img_ex, $allowed_extensions)) {
					$img_name_redux = uniqid("IMG-", true) . '.' . $img_ex;
					$upload_path = 'uploads/' . $img_name_redux;
					move_uploaded_file($tmp_name, $upload_path);
					// Get all the submitted data from the form
				} else {
					$image_error = "Wrong extension type (should be .jpg, .jpeg, .png)";
					$upload_path = '../image/cover_placeholder.png';
				}
			}
		} else {
			$image_error = "Please upload a cover page";
			$upload_path = '../image/cover_placeholder.png';
		}
	} else {
		$upload_path = '../image/cover_placeholder.png';
		$image_error = "Please upload a cover page";
	}

	$book_title = mysqli_real_escape_string($conn, $_POST["book_title"]);
	$book_author = mysqli_real_escape_string($conn, $_POST["book_author"]);
	$book_description = mysqli_real_escape_string($conn, $_POST["book_description"]);
	$page_count = mysqli_real_escape_string($conn, $_POST["page_count"]);
	$published_month_year = mysqli_real_escape_string($conn, $_POST["published_month_year"]) . "-01";
	$book_isbn = mysqli_real_escape_string($conn, $_POST["book_isbn"]);
	$book_language = mysqli_real_escape_string($conn, $_POST["language_picker"]);

	// echo "<pre>"; print_r($_POST); echo "</pre>";
	// die;

	if (!array_filter($errors) && empty($image_error)) {

		// TODO EKLEYEN USERA GORE VERIFIED AYARLA
		$original_title = $_POST['original_title'] ?? $book_title;
	
		// verified is set to 0, will be verified by the admins later
		$sql = "insert into book(book_isbn, title, author, description, date_published, book_edition, page_count, rating, verified, view_count, language, original_title, book_cover)
			VALUES('$book_isbn', '$book_title', '$book_author', '$book_description', '$published_month_year', 1, '$page_count', 0, 0, 0, '$book_language', '$original_title', '$upload_path');";

		// echo $upload_path . "<br>" . $sql;
		if (mysqli_query($conn, $sql)) {

			$sql = "SELECT book_id FROM book WHERE book_isbn=\"$book_isbn\" and title=\"$book_title\" and author=\"$book_author\"";
			$book_id = mysqli_query($conn, $sql);
			$book_id = mysqli_fetch_assoc($book_id);
			$book_id = $book_id['book_id'];
			$sql = "INSERT INTO has_genre(book_id, genre_id) VALUES";
			foreach ($_POST['book_genres'] as $gnr) {
				$sql = $sql . "($book_id, $gnr),";
			}
			$sql = substr($sql, 0, -1);
			$sql = $sql . ";";

			mysqli_query($conn, $sql);
			// post value is series_id
			if (isset($_POST['series']) && !empty($_POST['series'])) {
				$ser_id = $_POST['series'];
				$rank = $_POST['rank'] ?? -1;
				if ($rank <= 0) { $rank = -1; }

				// get original id
				$sql = "SELECT origin_id, series_id, amount as max_rank FROM series WHERE series_id = $ser_id";

				$serie = mysqli_fetch_assoc(mysqli_query($conn, $sql));
				$origin_id = $serie['origin_id'];
				$max_rank = $serie['max_rank'] + 1;

				$rank = ($rank == -1) ? $max_rank : $rank;

				$sql = 
				"INSERT INTO belongs_to(origin_id, book_id, series_id, rank)
				 VALUES($origin_id, $book_id, $ser_id, $rank);"; // ! TRIGGER TO CHANGE OTHER ITEMS WHEN A SMALLER RANK IS INTRODUCED

				if (mysqli_query($conn, $sql)) {

				} else {
					echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>" . $sql;
					echo mysqli_error($conn);
					die;
				}
			}

			//mysqli_close($conn);
			header('Location: index.php');

		} else {
			echo "SQL ERROR: " . mysqli_error($conn);
		}
	}
}
?>


<!DOCTYPE html>
<html>

<div class=" brand-dark" style="padding: 150px 7%;">
	<form action="book_upload.php" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col s3">
				<img src="../image/cover_placeholder.png" style="margin: 5px; margin-top:20px;" width="127" height="145">
					<input type="file" name="image" id="image">
					<?php echo "<p class=\"red-text\">$image_error</p>"; ?>

			</div>


			<div class="col s9" style="background: #AAD5FF">

				<div class="col s12">
					<input type="text" name="book_title" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text brand-anan" placeholder="Book Title">
					<?php $error = $errors['book_title']; echo "<p class=\"red-text\">$error</p>";?>
					
					<input type="text" name="original_title" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 30%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text brand-anan" placeholder="Original Book Title (Leaving empty defaults to title specified above)">
					
					<input type="text" name="book_author" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Author">
					<?php $error = $errors['book_author']; echo "<p class=\"red-text\">$error</p>";?>
					
					<input type="text" name="book_translator" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Translator (if translated)">
					<?php $error = $errors['book_translator']; echo "<p class=\"red-text\">$error</p>";?>
					
					<textarea name="book_description" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 100%; background-color:#7fa1bf; border-color: white;" class="text" placeholder="Book Description"></textarea>
					<?php $error = $errors['book_description']; echo "<p class=\"red-text\">$error</p>";?>
<!-- <input type="text" name="book_description" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Description"> -->
					
					<div class="col s12">
						<div class="col s5">
							<div class="col s5">
								<input type="text" name="page_count" style="font-size: 14px; margin-top: 15px; padding: 10px; width: 20%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Page count">
								<?php $error = $errors['page_count']; echo "<p class=\"red-text float:\">$error</p>";?>

								<input type="text" name="book_edition" style="font-size: 14px; margin-top: 15px; padding: 10px; width: 20%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Edition no">
								<?php $error = $errors['book_edition']; echo "<p class=\"red-text\">$error</p>";?>
							</div>

							<div class="col 7">
							<input type="text" name="book_isbn" style="font-size: 14px; margin-top: 15px; padding: 10px; width: 70%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="ISBN">
							<?php $error = $errors['book_isbn']; echo "<p class=\"red-text\">$error</p>";?>
							</div>
							
							<!-- <div class="col">
							
							</div> -->
						</div>
						<div class="col s7">

							<input type="month" name="published_month_year" style="margin-top: 15px; padding: 10px; width: 55%; height: 60%; background-color:#7fa1bf; border-color: white;"  placeholder="Enter Date">
							<!-- <input type="month" name="published_month_year" style="float: right; margin-top: 15px; padding: 10px; width: 55%; height: 40%; background-color:#7fa1bf; border-color: white;" placeholder="Enter Date"> -->
							<?php $error = $errors['published_month_year']; echo "<p class=\"red-text\">$error</p>";?>
								<select name="series" data-placeholder="None">
								<option value="">Which series do this book belong to (leave empty if none)</option>
								<?php
									$sql = "SELECT * FROM series";

									$series = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

									foreach ($series as $ser) {
										$ser_id = $ser['series_id'];
										$ser_name = $ser['series_name'];
										echo "<option value=\"$ser_id\">$ser_name</option>";
									}
								?>							
							</select>
							<input type="text" name="rank" style="font-size: 14px; float: left; margin-top: 15px; padding: 10px; width: 40%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Rank in series (default last)">

						</div>
					</div>

					
					<div class="input-field col s12">
						<select multiple name="book_genres[]">
							<option value="" disabled selected>Choose your option</option>

							<?php
							$sql = "SELECT * FROM genre;";

							$result = mysqli_query($conn, $sql);
							$genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

							foreach ($genres as $index => $pair) {
								$genre_id = $pair["genre_id"];
								$genre_name = $pair["genre_name"];

								echo "<option value=\"$genre_id\">$genre_name</option>";
							}
							?>
						</select>
						<label>Genres</label>
					</div>
				</div>

				<div class="row s6">
					<div class="input-field col s12" style="margin-left: 25px; width: 90%">
						<?php require('template/language_picker.php'); ?>
					</div>

					<div style="float: right; margin: 15px">
						<input type="submit" value="Submit" name="submit" id="submit" class="btn brand-btn">
					</div>
				</div>
	</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
	$(document).ready(function() {
		$('select').formSelect();
	});
</script>
</body>

</html>