<?php
// TODO HANDLE POST REQUEST

// initialize session var and connect to db
require('template/header.php');

$errors = array('book_author' => '', 'book_description' => '', 'page_count' => '', 'published_month_year' => '', 'book_isbn' => '');
$book_title = $book_author = $book_description = $page_count = $published_month_year = $book_isbn = $book_language = "";
$submit_param = array_keys($errors);

if (isset($_POST['submit'])) {
	foreach ($submit_param as $param => $value) {
		if (empty($_POST[$value])) {
			$errors[$value] = "This field is required <br>";
		}
	}

	if (!filter_var($_POST['page_count'], FILTER_VALIDATE_INT)) {
		// ! NEGATIF BISI GIRSE PATLAR BURA
		$errors['page_count'] = "Please enter a valid integer";
	}

	// TODO EDITION EKLE BURAYA

	$book_title = mysqli_real_escape_string($conn, $_POST["book_title"]);
	$book_author = mysqli_real_escape_string($conn, $_POST["book_author"]);
	$book_description = mysqli_real_escape_string($conn, $_POST["book_description"]);
	$page_count = mysqli_real_escape_string($conn, $_POST["page_count"]);
	$published_month_year = mysqli_real_escape_string($conn, $_POST["published_month_year"]);
	$book_isbn = mysqli_real_escape_string($conn, $_POST["book_isbn"]);
	$book_genres = mysqli_real_escape_string($conn, $_POST["book_genres"]);
	$book_language = mysqli_real_escape_string($conn, $_POST["language_picker"]);

	if (!array_filter($errors)) {
		// TODO EKLEYEN USERA GORE VERIFIED AYARLA
		// TODO ORIGINAL TITLE
		$sql = "insert into book(book_isbn, title, author, date_published, book_edition, page_count, rating, verified, view_count, language, original_title)
			VALUES('$book_isbn', '$book_title', '$book_author', '$published_month_year', 1, '$page_count', 0, 0, 0, '$book_language', '$book_title');";
		if (mysqli_query($conn, $sql)) {
			mysqli_close($conn);
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
	<form action="book_upload.php" method="POST">
		<div class="row">
			<div class="col s3">
				<img src="../image/cover_placeholder.png" style="margin: 5px; margin-top:20px;" width="127" height="145">
				<form method="POST" action="file.php" enctype="multipart/form-data">
					<input type="file" name="image"/>
					<input type="submit" name="upload" value="upload">
				</form>

				<!-- <div class="file-field input-field">
					<div class="btn brand-btn">
						<span>Upload</span>
						<input type="file">
					</div>
					<div class="brand file-path-wrapper" style="margin: 5px;">
						<input class="file-path validate" type="text">
					</div>
				</div> -->

			</div>


			<div class="col s9" style="background: #AAD5FF">

				<div class="col s12">
					<input type="text" name="book_title" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text brand-anan" placeholder="Book Title">
					<input type="text" name="book_author" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Author">
					<input type="text" name="book_description" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Description">

					<div class="col s12">
						<div class="col s6">
							<input type="text" name="page_count" style="font-size: 14px; float: left; margin-top: 15px; padding: 10px; width: 50%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Page count">
						</div>
						<div class="col s6">
							<input type="month" name="published_month_year" style="float: right; margin-top: 15px; padding: 10px; width: 55%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Enter Date">
						</div>
					</div>

					<input type="text" name="book_isbn" style="font-size: 14px; float: left; margin-top: 15px; padding: 10px; width: 40%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="ISBN">
					<div class="input-field col s12">
						<select multiple name="book_genres">
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
					<div class="input-field col s12">
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