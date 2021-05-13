<!DOCTYPE html>
<html>
<?php 
require('template/header.php'); 
require('template/config.php');

if($_SESSION['isAdmin'] == 0){
	header("Location: index.php");
}


?>

<div>
	<div style="padding: 150px 7%;" class="col s11">

		<div class="brand-dark row">
			<div class="brand col s5" style="margin: 50px">
				<div>
					<div class="col s9">
						<div class="brand-text-alt" style="color: #473335">Error Reports</div>
					</div>

				</div>
				<br><br>
				<form class="" action="reports.php" method="POST" name="thisForm">
					<input type="text" name="search_bar" placeholder="Search a book title or user..." style="padding: 15px; width: 50%; background-color:#7fa1bf;" class="text">
					<input type="submit" value="Search" name="button" style="background-color:#7fa1bf; padding:12px; width:10%" class="text">
				</form>
				<br>
				<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					echo $_POST['search_bar'];

					$search = $_POST['search_bar'];



					$query = "
							select b.title, b.book_cover, u.first_name, er.report_message, er.report_date
            							from book b, reports r, user u, error_report er
							where b.book_id = r.book_id and r.user_id = u.user_id and er.report_id = r.report_id
							order by b.book_id DESC";

					$res = mysqli_query($conn, $query);

					while ($reports = mysqli_fetch_array($res, MYSQLI_ASSOC)) {


						$title = $reports['title'];
						$user = $reports['first_name'];

						if (strpos($title, $search) !== false || strpos($user, $search) !== false) {
							echo "<div class='row text purple darken-2' style='border:3px solid black;'>";

							echo "<div class='col s3 ' style='border:3px solid black; text-align:center;'>";
								$tmp = $reports['title'];

								echo '<div class="row">';
								echo $tmp;
								echo '</div>';

								echo '<div class="row">';
								echo '<img src="data:image/jpeg;base64,' . base64_encode($reports['book_cover']) . '" style="width: 100px; height: 135px; " />';
								echo '</div>';
							echo "</div>";

							$tmp = $reports['report_message'];
							echo "<div class='col s3' style='margin-top: 75px; text-align:center; border:3px solid black'> 
											<p>
											  $tmp
											</p>
										  </div>";

							$tmp = $reports['first_name'];
							echo "<div class='col s3' style='margin-top: 75px; text-align:center; border:3px solid black'> 
											<p class='text'>
											  $tmp
											</p>
										  </div>";

							$tmp = $reports['report_date'];
							echo "<div class='col s3' style='margin-top: 75px; text-align:center; border:3px solid black'> 
										<p class='text'>
											$tmp
										</p>
									</div>";

							echo "</div>";
						}
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