<!DOCTYPE html>
<html>
<?php
require('template/header.php');
require('template/config.php');


if (!isset($_GET['list_id'])) {
	echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
	die;
}

$list_id = $_GET['list_id'];

$sql = "SELECT b.title as book_title, b.author, b.book_id, b.book_cover, bl.title as list_title, bl.description, u.user_id, u.first_name, u.last_name
				  FROM book b, book_list bl, user u, lists l
					WHERE b.book_id = l.book_id and u.user_id = l.user_id and bl.list_id = l.list_id and l.list_id = $list_id";


if ($result = mysqli_query($conn, $sql)) {
	$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$user_name = $result[0]['first_name'] . " " . $result[0]['last_name'];
} else {
	echo "SQL SYNTAX ERROR" . mysqli_error($conn);
}
?>

<div>
	<div style="padding: 150px 7%;" class="col s11">
		<div class="brand-dark row">
			<div class="brand col s5" style="margin: 50px">
				<div>
					<div class="col s6">
						<input name="list_name" type="text" class="text" style="width: 50%; margin-top: 15px; margin-left: 10px;" placeholder="Enter search parameter...">
					</div>
					<div class="col s6">
						<?php echo "<div class=\"brand-text-alt\" style=\"color: #473335; margin-top: 25px;\">Created by $user_name</div>"; ?>
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
				<div>
					<div class="text brand-text-alt">Search</div>

					<div>
						<?php echo "<form action=\"book_list.php?list_id=$list_id\" method=\"POST\">"; ?>
						<input type="text" class="text" style="float: left; width: 50%;" placeholder="Enter search parameter...">
						<input type="submit" class="btn brand-btn" style="float: right;" name="submit" value="Search">
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
							$sql = "SELECT * FROM book";
							if ($res = mysqli_query($conn, $sql)) {
								echo $sql;
								$books = mysqli_fetch_all($res, MYSQLI_ASSOC);
								
								foreach ($books as $book) {
									// echo "<pre>";
									// print_r($book);
									// echo "</pre>";
									if (strpos($book['title'], $search) !== false 
										|| strpos($book['author'], $search) !== false) {
											
									}
								}
								echo "

										";
							} else {
								echo mysqli_error($conn);
							}



							?>

							<tr>
								<th><img src="../image/cover_placeholder.png" alt=""></th>
								<th>Yes you're fat and no one likes you</th>
								<th>Mike Hunt</th>
								<th><input type="submit" class="btn brand-btn" style="float: right;" name="submit" value="Add"></th>
								<?php echo "<input type=\"hidden\" value=$book_id>"; ?>
							</tr>
						</tbody>
					</table>

					<?php echo "<form style=\"float: right\" action=\"book_list.php?list_id=$list_id\" method=\"POST\">"; ?>
					<input type="submit" class="btn brand-btn" id="submit" name="submit" value="Submit">
					</form>
				</div>
			</div>
		</div>

	</div>
</div>
</body>

</html>