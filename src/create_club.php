<?php
	error_reporting(0);
	require('template/config.php');

	if (!(isset($_SESSION['user_id']) || isset($_SESSION['isAdmin']))) {
		header('Location: index.php');
	}

	print_r($_POST);
	print_r($_COOKIE);

	require('template/header.php');


	$uid = $_SESSION['user_id'];

	if (isset($_POST['pick'])) {
		$book_id = $_POST['book_id'];
		setcookie('book_id', $book_id);
		// $_COOKIE['book_id'] = $book_id;
	}

	if (isset($_POST['club_title'])) {
		$club_title = $_POST['club_title'];
	} else {
		$club_title = "";
	}

	// if (isset($_POST['book_id'])) {
	// 	$book_id = $_POST['book_id'];
	// } else {
	// 	$book_id = "";
	// }

	// HANDLE POST REQUESTS HERE
	$errors = array('club_title' => '');
	

	foreach ($errors as $key => $value) {
		if (empty($_POST[$key])) {
			$errors[$key] = "This field is required";
		}
	}

	if (isset($_POST['submit'])) {
		if (!array_filter($errors)) {
			$book_id = $_COOKIE['book_id'];
				$sql = "INSERT INTO book_club(name, owner_id, book_id) VALUES('$club_title', $uid, $book_id)";

			if (mysqli_query($conn, $sql)) {

				$sql = "SELECT MAX(club_id) as id FROM book_club WHERE name = '$club_title' and owner_id = $uid and book_id = $book_id;";
				if ($result = mysqli_query($conn, $sql)) {

				}
				$result = mysqli_fetch_assoc($result);
				$result = $result['id'];

				unset($_COOKIE['book_id']);
				header("Location: club_page.php?club_id=$result");
			}
		}
	} else {
		echo "GIRMIYO";
	}
?>


	<!DOCTYPE html>

	<html>
		<br><br><br><br><br><br>
	
		<div style="margin: auto; background: #AAD5FF">
		<?php echo "<form action=\"create_club.php\" method=\"POST\">"; ?>
		
			<div style="margin: 25px">
					<h2 class="brand-text">Create a Book Club</h2>		
					<input type="submit" style="float: right;" class="btn brand-btn" name="submit" value="Submit">


					<?php echo "<input type=\"text\" value=\"$club_title\" name=\"club_title\" style=\"float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;\" class=\"z-depth-0 text brand-anan\" placeholder=\"Club Title\">"; ?>
					<?php $error = $errors['club_title']; echo "<p class=\"red-text\">$error</p>";?>
				
					<div class="text brand-text">The Book of The Club</div>

					<div>
						<input type="text" class="text" name="search" style="padding: 10px; background: #7fa1bf; width: 50%;" placeholder="Enter search parameter...">
						<input type="submit" class="btn brand-btn" name="search_btn" value="Search">

						<?php

							echo "
							<table class='highlight'>
							<tr>
								<th class=\"center\">Title</th>
								<th class=\"center\">Author</th>
								<th class=\"center\"> </th>
							</tr>
							";
							if (isset($_POST['search_btn'])) {
								$search = $_POST['search'];

								$query = 
								" SELECT * 
									FROM book b
									WHERE (title LIKE '$search%' 
									or title LIKE '%$search' 
									or author LIKE '$search%' 
									or title LIKE '%$search');
								";
	
								$result = mysqli_query($conn, $query);
	
								$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
								foreach ($result as $res) {
									$title = $res['title'];
                  $author = $res['author'];
                  $search = $search;
									echo "<tr>";

									$tmp = $res['title'];

									echo "<td style='margin-top: 75px;'> 
															<p class='text'>
																$tmp
															</p>
														</td>";

									$tmp = $res['author'];
									echo "<td style='margin-top: 75px'> 
															<p>
																$tmp
															</p>
														</td>";

									$tmp = $res['book_id'];
									echo "<input type=\"hidden\" name=\"book_id\" value=\"$tmp\">";
									echo "<td><input type=\"submit\" name=\"pick\" value=\"pick\" class=\"btn brand-btn\"";
									echo "</tr>";
                }
                echo '</table>';
							}
						?>
					</div>
			</div>
			</form>
		</div>
		
	
	</body>
	
	</html>