<?php 
	require('template/config.php');
	$login = 0;

	if (isset($_POST['login']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (empty($email) || empty($password)) {
			echo '<p class="error">user name or password is not entered</p>';
		} else if (!empty($email) && !empty($password)) {

			//read from database
			$query = "select * from admin_user where email = '$email' limit 1";
			$result = mysqli_query($conn, $query);

			if (!empty($result)) {
				if (mysqli_num_rows($result) > 0) {

					$user_data = mysqli_fetch_assoc($result);

					if ($user_data['pass'] === $password) {
						$_SESSION['login'] = 1; // şimdilik dursun
						$_SESSION['email'] = $email;
						$_SESSION['pass'] = $password;
						$_SESSION['name'] = $user_data['first_name'];
						header("Location: reports.php");
						die;
					}
				}
			}

			$_SESSION['login'] = 0;
			echo '<p class="error">wrong  or password!</p>';
		} else {
			$_SESSION['login'] = 0;
			echo '<p class="error">wrong username or password!</p>';
		}
	}

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
				<p style="text-decoration:underline; text-align:left; margin-left:29%;">Email</p>
  				<input type="text" name="email" id="login_email" value="" placeholder="E-mail" style="padding: 15px; width: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text">
  				<p style="text-decoration:underline; text-align:left; margin-left:29%;">Password</p>
  				<input type="password" name="password" id="login_password" value="" placeholder="Password" style="padding: 15px; width: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text">
  				<br> <br>
  				<input type="submit" name="login" id="login" value="Login" style="padding: 15px; background-color:#7fa1bf;" class="text">
					<!-- <label class="left brand-text" style="font-size: 22;">Email</label>
					<input style="background: white; color: black; margin-top: 10px; margin-bottom: 20px" type="email" name="email" placeholder="Admin email">
					<label class="left brand-text" style="font-size: 22;">Password</label>
					<input style="background: white; color: black; margin-top: 10px; margin-bottom: 20px" type="password" name="pass" placeholder="Password">
					<input type="submit" name="login" value="Submit" class="btn" style="background: #80A1C0; color: #473335; font-weight: bold; font-size: 18px"> -->
				</form>
			</div>
		</div>
	</section>
</html>