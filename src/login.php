  <?php
	session_start();
	require('db/db_connect.php');

	$login = 0;

	if (isset($_POST['login']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (empty($email) || empty($password)) {
			echo '<p class="error">user name or password is not entered</p>';
		} else if (!empty($email) && !empty($password)) {

			//read from database
			$query = "select * from user where email = '$email' limit 1";
			$result = mysqli_query($conn, $query);

			if (!empty($result)) {
				if (mysqli_num_rows($result) > 0) {

					$user_data = mysqli_fetch_assoc($result);

					if ($user_data['pass'] === $password) {
						$_SESSION['login'] = 1; // şimdilik dursun
						$_SESSION['email'] = $email;
						$_SESSION['pass'] = $password;
						$_SESSION['name'] = $user_data['first_name'];
						header("Location: index.php");
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


	$register_email = $register_password = $register_name = $register_surname = $register_bdate = "";
	$errors = array('register_password' => '', 'register_email' => '', 'register_name' => '', 'register_surname' => '', 'register_bdate' => '');

	$check_register_param = array(
		'0' => 'register_email', '1' => 'register_password',
		'2' => 'register_name', '3' => 'register_surname', '4' => 'register_bdate'
	);

	if (isset($_POST['register'])) {
		echo $_POST["register_email"] . " " . $_POST["register_password"] . " ";
		
		foreach ($check_register_param as $param) {
			if (empty($_POST[$param])) {
				$errors[$param] = "This field is required <br>";
			}
		}

		if (!filter_var($register_email, FILTER_VALIDATE_EMAIL)) {
			$errors['register_email'] = "Email invalid <br>";
		}

		if (!array_filter($errors)) {
			echo "DUMB DUMB SUM TING WONG ";
			// if there are no errors on register form
	
			$register_email = mysqli_real_escape_string($conn, $_POST["register_email"]);
			$register_password = mysqli_real_escape_string($conn, $_POST["register_password"]);
			$register_name = mysqli_real_escape_string($conn, $_POST["register_name"]);
			$register_surname = mysqli_real_escape_string($conn, $_POST["register_surname"]);
			$register_bdate = mysqli_real_escape_string($conn, $_POST["register_bdate"]);
	
			echo $register_email . " " . $register_password . " ";
      
			$sql = "INSERT INTO user(email, pass, first_name, last_name ,birth_date) VALUES('$register_email', '$register_password', '$register_name', '$register_surname', '$register_bdate')";
			echo "DUMB DUMB I did it ";
	
			if (mysqli_query($conn, $sql)) {
				mysqli_close($conn);
				$_SESSION['login'] = 1;
				$_SESSION['email'] = $register_email;
				$_SESSION['password'] = $register_password;
				header('Location: index.php');
			} else {
				echo "DUMB DUMB SUM TING WONG " . mysqli_error($conn);
			}
		}
	}

	?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
  	<?php require('template/style.php'); ?>

  	<meta charset="utf-8">
  	<title>Login</title>
  	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  	<!--Import Google Icon Font-->
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  	<!--Import materialize.css-->
  	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  	<!-- Compiled and minified JavaScript -->
  </head>

  <body>

  	<div class="center1">
  		<div class="text" style="float:left">
  			<img src="../image/ordek.png" width="200" height="170" alt="">
  		</div>
  		<h1 style="text-align: left; margin-left: 40%;">DUCKREAD</h1>
  	</div>

  	<div>

  		<table class="" cellspacing="20px">
  			<tr>
  				<td style="width:2%"></td>

  				<td>
  					<div>
  						<table style="width:100%;">
  							<td><button class="button text" id="log" style="width:100%; border-color:white; background-color:#7fa1bf;" onclick="openPanel('Login', 'log')">Login</button></td>
  							<td><button class="button text " id="reg" style="width:100%; border-color: #7fa1bf; background-color:#7fa1bf;" onclick="openPanel('Register', 'reg')">Register</button></td>
  						</table>

  					</div>

  					<div id="Login" class="logs text">
  						<h2 style="text-align: left; margin-left:29%;">Login</h2>

  						<form class="z-depth-0" action="login.php" method="post">
  							<p style="text-decoration:underline; text-align:left; margin-left:29%;">Email</p>
  							<input type="text" name="email" id="login_email" value="" placeholder="E-mail" style="padding: 15px; width: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text">
  							<p style="text-decoration:underline; text-align:left; margin-left:29%;">Password</p>
  							<input type="password" name="password" id="login_password" value="" placeholder="Password" style="padding: 15px; width: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text">
  							<br> <br>
  							<input type="submit" name="login" id="login" value="Login" style="padding: 15px; background-color:#7fa1bf;" class="text">
  						</form>
  					</div>

  					<div id="Register" class="logs text" style="display:none;">
  						<h2 style="text-align: left; margin-left:29%;">Register</h2>

  						<form class="" action="login.php" method="post">
  							<p style="text-decoration:underline; text-align:left; margin-left:29%;">Email</p>
  							<input type="text" name="register_email" id="register_email" value="" placeholder="E-mail" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text">
  							<p style="text-decoration:underline; text-align:left; margin-left:29%;">Password</p>
  							<input type="password" name="register_password" id="register_password" value="" placeholder="Password" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text">
  							<p style="text-decoration:underline; text-align:left; margin-left:29%;">Name</p>
  							<input type="text" name="register_name" id="register_name" value="" placeholder="Name" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text ">
  							<p style="text-decoration:underline; text-align:left; margin-left:29%;">Surname</p>
  							<input type="text" name="register_surname" id="register_surname" value="" placeholder="Surname" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text">
  							<p style="text-decoration:underline; text-align:left; margin-left:29%;">Birth Day</p>

  							<div class="input-field" style="width:40.5%; margin-left:29%; ">
  								<input type="text" class="datepicker text" id="register_bdate" style="background-color:#7fa1bf; border-color: white; padding:12px;">
  							</div>
  							<br>
  							<input type="submit" name="register" id="register" value="Register" style="padding: 15px; background-color:#7fa1bf;" class="text">
  						</form>
  					</div>

  					<script>
  						function openPanel(Name, evt) {
  							var i;
  							var x = document.getElementsByClassName("logs text");
  							var logs = document.getElementsByClassName("button text");
  							for (i = 0; i < x.length; i++) {
  								x[i].style.display = "none";
  								logs[i].style.borderColor = "#7fa1bf";
  							}
  							document.getElementById(Name).style.display = "block";
  							document.getElementById(evt).style.borderColor = "white";
  						}
  					</script>

  				</td>

  				<td style="width:2%"></td>

  			</tr>
  		</table>

  	</div>
  	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  	<script>
  		$(document).ready(function() {
  			$('.datepicker').datepicker({


  			});
  		});
  	</script>

  </body>

  </html>