<?php
error_reporting(0);
require('template/config.php');

?>



<!DOCTYPE html>

<html>
	<?php require('template/header.php'); ?>
	<style>
		.brand {
			background: #AAD5FF;
		}
	</style>
	<br><br><br><br><br><br>


	<div>
		<div class="row">
			<div class="col s6 center" style="background: #AAD5FF">
				<h2>Book Lists</h2>
				
				<?php 
							$sql = "SELECT * FROM book_list ";
							if ($result = mysqli_query($conn, $sql)) {
									$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
							}
							else{
									echo "FAILED TO EXECUTE QUERY";
							}
							
						foreach ($result as $res) {
									
									$list_id = $res["list_id"];

									$sql1 = "SELECT book_cover FROM book WHERE book_id IN(SELECT MAX(book_id) FROM lists WHERE list_id = '$list_id')";
									
									if($res1 = mysqli_query($conn, $sql1)){
									$result1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
									}
									else{
											echo "Problem encountered while fetching cover page";
									}
									
									// isset() => setlenmemis assoc array elemani
									// empty() => bos liste
									if(!isset($result1['book_cover'])) {
											echo  "<a href = \"show_book_list.php?list_id=$list_id\" ><img src=\"../image/cover_placeholder.png\" width=\"300\" height=\"405\" alt= \"No image\"> ";
									}
									else {
											echo "<a href = \"show_book_list.php?list_id=$list_id\" ><img src=\"" .$result1["book_cover"]. "\"  width=\"300\" height=\"405\"  alt= \"No image\"> ";
									}
									
									
									$name = $res['title'];
									$desc = $res['description'];
															echo "<h2><a href=\"show_book_list.php?list_id=$list_id\">$name</a></h2>";
									echo $desc;
															echo "<br>";
															echo "<br>";
															echo "<br>";
															echo "<br>";
													}
				?>
			</div>
			<div class="col s6 center " style="background: #AAD5FF">
					<?php
						$sql = "SELECT series_id, series_name, b.book_cover as series_cover FROM series, book b WHERE b.book_id = origin_id";
						$result = mysqli_query($conn, $sql);
						$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
						echo "
								<table>
									<thead>
										<th></th>
										<th></th>
										<th><h3>Series</h3></th>
									</thead>

									<tbody>
									";
										foreach ($result as $ser) {
											$series_id = $ser['series_id'];
											$series_name = $ser['series_name'];
											$series_img = $ser['series_cover'];
					
											echo "
												<tr>
												<td><a href=\"show_book_series.php?series_id=$series_id\"><img src=\"$series_img\" width=\"300\" height=\"405\"></a></td>
												<td></td>
												<td style=\"width: 300px;\"><h4 class=\"left\"><a href=\"show_book_series.php?series_id=$series_id\">$series_name</a></h4></td>
												</tr>
											";
										}
										
							echo "
									</tbody>
								</table>
							";
					?>
						
			</div>
		</div>
	</div>
	</body>
    
</html>