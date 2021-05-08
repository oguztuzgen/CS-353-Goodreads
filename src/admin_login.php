<?php 
	require('template/style.php');


	// TODO HANDLE POST REQUEST FOR LOGIN
?>


<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="styles.css">
	<section class="center container">
		<div class="brand center">
			<div class="brand-dark">
				<h3 class="center brand-text" style="color: #F0F0F0; padding: 10px; font-size: 48px;">ADMIN LOGIN</h3>
			</div>
			<div class="center" style="padding: 25px 30%;">
				<form action="admin_login.php" method="POST">
					<label class="left brand-text" style="font-size: 22;">Email</label>
					<input style="background: white; color: black; margin-top: 10px; margin-bottom: 20px" type="email" name="email" placeholder="Admin email">
					<label class="left brand-text" style="font-size: 22;">Password</label>
					<input style="background: white; color: black; margin-top: 10px; margin-bottom: 20px" type="password" name="password" placeholder="Password">
					<input type="submit" name="submit" value="Submit" class="btn" style="background: #80A1C0; color: #473335; font-weight: bold; font-size: 18px">
				</form>
			</div>
		</div>
	</section>
</html>