
<!DOCTYPE html>
<html>
<?php
require('template/header.php');
require('template/config.php');
// error_reporting(0);

if ($_SESSION['isAdmin'] == 0) {
	header("Location: index.php");
}

if (isset($_POST['edit'])) {
	$bid = $_POST['book_id'];
	$redirect = "book_edit.php?book_id=$bid";
	// die;
	header("Location: book_edit.php?book_id=$bid");
}

?>
<div>
	<div style="padding: 150px 7%;" class="col s11">

		<div class="brand-dark row">
			<div class="brand col s7" style="margin: 50px">
				<div>
					<div class="col s9">
						<div class="brand-text-alt" style="color: #473335">Error Reports</div>
					</div>

				</div>
				<br><br>
				<form class="" action="reports.php" method="POST" name="thisForm">
					<input type="text" name="search_bar" placeholder="Search a book title or user..." style="padding: 15px; width: 50%; background-color:#7fa1bf;" class="text">
					<input type="submit" value="Search" name="search" style="background-color:#7fa1bf; padding:12px; width:10%" class="text">
				</form>
				<br>

				<?php
				if (isset($_POST["search"])) {

					$search = $_POST['search_bar'];

					$query =
						" SELECT * 
						FROM book b, user u
						WHERE (title LIKE '$search%' 
						or b.title LIKE '%$search' 
						or b.author LIKE '$search%' 
						or b.title LIKE '%$search'
						or u.first_name LIKE '%$search'
						or u.first_name LIKE '$search%'
						or u.last_name LIKE '%$search'
						or u.last_name LIKE '$search%'
					)";

					$query = "
							select b.title, b.book_cover, u.first_name, er.report_message, er.report_date, er.report_type, b.book_id
            							from book b, reports r, user u, error_report er
							where b.book_id = r.book_id and r.user_id = u.user_id and er.report_id = r.report_id
							order by b.book_id DESC";

					$res = mysqli_query($conn, $query);

					while ($reports = mysqli_fetch_array($res, MYSQLI_ASSOC)) {


						$title = $reports['title'];
						$user = $reports['first_name'];

						// if (strpos($title, $search) !== false || strpos($user, $search) !== false) {
						echo "<div class='row text purple darken-2' style='border:3px solid black;'>";

						echo "<div class='col s3 ' style='border:3px solid black; text-align:center;'>";
						$tmp = $reports['title'];

						echo '<div class="row">';
						echo $tmp;
						echo '</div>';

						echo '<div class="row">';
						echo '<img src="' . $reports['book_cover'] . '" style="width: 100px; height: 135px; " />';
						echo '</div>';
						echo "</div>";

						$tmp = $reports['report_type'];
						echo "<div class='col s2' style='margin-top: 75px; text-align:center; border:3px solid black'> 
											<p>
											  $tmp
											</p>
										  </div>";

						$tmp = $reports['report_message'];
						$bid = $reports['book_id'];
						echo "<div class='col s4' style='margin-top: 75px; text-align:center; border:3px solid black'> 
										<div style = 'border:3px solid black'>
											<p> $tmp </p>
										</div>
										<div style = 'border:3px solid black'>
										<form action=\"reports.php\" method=\"post\">
										<input type=\"submit\" name=\"edit\" class=\"btn blue lighten-1\" value=\"Edit\" style=\"margin:auto\">
										<input type=\"hidden\" name=\"book_id\" value= " . $bid . ">
										</form>
										</div>
										</div>";

						$tmp = $reports['report_date'];
						$tmp2 = $reports['first_name'];
						echo "<div class='col s3' style='margin-top: 75px; text-align:center; border:3px solid black'> 
										<p class='text'>
											by $tmp2 <br>
											at $tmp
										</p>
									</div>";

						echo "</div>";
						// }
					}
				}
				
				?>

				<div style="padding-top: 100px">
					<table class="brand" style="margin: 10px;">
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body>

</html>