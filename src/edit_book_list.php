<!DOCTYPE html>
<html>
<?php
	require('template/header.php');
	require('template/config.php');


	if (!isset($_GET['list_id'])) {
		echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
		die;
	}
	$search = $name_error = "";

	if (isset($_POST['search_btn'])) {
		$search = $_POST['search'];
	}

	$list_id = $_GET['list_id'];

	if (isset($_POST['add'])) {
		$user = $_SESSION['user_id'];
		$book_id = $_POST['book_id'];
		$sql = 
		"INSERT INTO lists(list_id, user_id, book_id)
		 VALUES($list_id, $user, $book_id)";
		
		mysqli_query($conn, $sql);
	}

	if (isset($_POST['submit'])) {
		if (empty($_POST['list_name'])) {
			$name_error = "Please enter a list name";
		} else {
			$list_title = $_POST['list_name'];
			$sql = "UPDATE book_list SET title = '$list_title' WHERE book_list.list_id = $list_id;";
			mysqli_query($conn, $sql);
		}

		if (empty($_POST['list_description'])) {
			$_POST['list_description'] = "No description";
		}

		$description = $_POST['list_description'];
		$sql = "UPDATE book_list SET description = '$description' WHERE book_list.list_id = $list_id;";

		mysqli_query($conn, $sql);
	}

	$sql = "SELECT b.title as book_title, b.author, b.book_id, b.book_cover, bl.title as list_title, bl.description, u.user_id, u.first_name, u.last_name
						FROM book b, book_list bl, user u, lists l
						WHERE b.book_id = l.book_id and u.user_id = l.user_id and bl.list_id = l.list_id and l.list_id = $list_id";


	if ($result = mysqli_query($conn, $sql)) {
		$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
		if (!empty($result)) {
			$user_name = $result[0]['first_name'] . " " . $result[0]['last_name'];
		}
	} else {
		echo "SQL SYNTAX ERROR" . mysqli_error($conn);
	}

	
	
?>

<div>
	<?php echo "<form action=\"index.php\" method=\"POST\">"; ?>
	<div style="padding: 150px 7%;" class="col s11">
		<div class="brand-dark row">
			<div class="brand col s5" style="margin: 50px">
				<div>
					<div class="col s6">
						<?php $list_title=$result[0]['list_title'] ?? ''; echo "<input name=\"list_name\" value=\"$list_title\" type=\"text\" class=\"text\" style=\"width: 50%; margin-top: 15px; margin-left: 10px;\" placeholder=\"List name...\">"; ?>
						<br><label style="margin-left:12px">Book list name</label>
						<?php echo "<p class=\"red-text\">$name_error</p>"; ?>

						<textarea name="list_description" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 100%; background-color:#7fa1bf; border-color: white;" class="text"></textarea>
						<br><label style="margin-left:12px">Book list description</label>
					</div>
					<div class="col s6">
						<?php $user_name = $_SESSION['name']; echo "<div class=\"brand-text-alt\" style=\"color: #473335; margin-top: 25px;\">Created by $user_name</div>"; ?>
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

							if (!$result) { $result = array(); }
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
						<?php echo "<form action=\"book_list.php?list_id=$list_id\" method=\"POST\">"; ?>
						<input type="text" class="text" name="search" style="float: left; width: 50%;" placeholder="Enter search parameter...">
						<input type="submit" class="btn brand-btn" style="float: right;" name="search_btn" value="Search">
						</form>
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
									FROM book b, book_list bl, user u, lists l
									WHERE b.book_id = l.book_id and u.user_id = l.user_id and bl.list_id = l.list_id and l.list_id = $list_id)";
							
							if ($res = mysqli_query($conn, $sql)) {

								$books = mysqli_fetch_all($res, MYSQLI_ASSOC);
								
								foreach ($books as $book) {


									if (strpos($book['title'], $search) !== false 
										|| strpos($book['author'], $search) !== false) {

										$img = $book['book_cover'];
										$title = $book['title'];
										$author = $book['author'];
										$book_id = $book['book_id'];
										echo "
											<form action=\"edit_book_list.php?list_id=$list_id\" method=\"POST\">
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