

<!DOCTYPE html>
<html>
	<?php	require('template/header.php'); ?>

	<div>
		<div style="padding: 150px 7%;">
			<div class="brand-dark row">
				<div class="brand col s4 md5" style="margin: 50px">
					<p>ZAAA</p>
				</div>
				<div class="col s4 md5">
					<div> <!-- RIGHT HAND SIDE -->
						<div class="text brand-text-alt">Search</div>
						<form action="booklist.php" method="POST">
							<input type="text" class="text" style="float: left; width: 50%;" placeholder="Enter search parameter...">
							<input type="submit" class="btn brand-btn" style="float: right;" name="submit" value="Submit">
						</form>
						<div>
							<table>
								<thead>
									<tr>
										<th>Title</th>
										<th>Author</th>
									</tr>
								</thead>

								<tbody>
									<!-- PHP CODE HERE FOREACH QUERY RESULT -->
									<tr>
										<th>Yes you're fat and no one likes you</th>
										<th>Mike Hunt</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>