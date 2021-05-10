

<!DOCTYPE html>
<html>
	<?php	require('template/header.php'); ?>

	<div>
		<div style="padding: 150px 7%;" class="col s11">
			<div class="brand-dark row">
				<div class="brand col s5" style="margin: 50px">
					<div>
						<div class="col s3">
							<img src="../image/cover_placeholder.png" style="float: left; margin: 5px;">
						</div>
						<div class="col s9">
							<input type="text" class="text" style="width: 50%; margin-left: 10px;" placeholder="Enter search parameter...">
							<!-- TODO PHP CODE GOES HERE -->
							<div class="brand-text-alt" style="color: #473335">Created by Oğuz Tüzgen</div>
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
									<tr>
									<!-- IF IMG COVER DOES NOT EXIST -->
										<th><img src="../image/cover_placeholder.png" alt="" width="56" height="64"></th>
										<th>Yes you're fat and no one likes you</th>
										<th>Mike Hunt</th>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<div class="col s5">
					<div> <!-- RIGHT HAND SIDE -->
						<div class="text brand-text-alt">Search</div>
						
						<div>
							<form action="booklist.php" method="POST">
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
								<tr>
									<th><img src="../image/cover_placeholder.png" alt=""></th>
									<th>Yes you're fat and no one likes you</th>
									<th>Mike Hunt</th>
									<th><input type="submit" class="btn brand-btn" style="float: right;" name="submit" value="Add"></th>
								</tr>
							</tbody>
						</table>

						<form style="float: right" action="booklist.php" method="POST">
							<input type="submit" class="btn brand-btn" id="submit" name="submit" id="submit">
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</body>
</html>