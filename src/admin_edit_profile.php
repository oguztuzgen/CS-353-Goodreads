<?php
// TODO PROFIL FOTOSUNUN TEKRAR YUKLENMESI GEREKIYO HER SEFERINDE ONU DUZELT
// initialize session var and connect to db
require('template/header.php');

if ($_SESSION['login'] == 0) {
	header('Location: login.php');
	die;
}

if (!isset($_GET['user_id'])) {
	echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
	die;
}

$uid = $_GET['user_id'];

$sql = "SELECT * FROM user WHERE user_id = $uid";

if ($result = mysqli_query($conn, $sql)) {
	
	$result = mysqli_fetch_assoc($result);
	$profile_first_name = $result['first_name'];
	$profile_last_name = $result['last_name'];
	$profile_birth_date = $result['birth_date'];
	$profile_about = $result['about'];// ?? "";
	$profile_address = $result['address'];// ?? "";
	$upload_path = $result['profile_picture'] ?? "../image/profile_placeholder.jpg";
	$profile_author = $result['author'];
	$profile_critic = $result['critic'];
	// $upload_path = $result['profile_picture'] ?? "../image/profile_placeholder.jpg";
} else {
	$profile_first_name = $profile_last_name = $profile_birth_date = $profile_about = $profile_address = "";
}

if (isset($_POST['profile_first_name'])) {
	$profile_first_name = $_POST['profile_first_name'];
}

if (isset($_POST['profile_last_name'])) {
	$profile_last_name = $_POST['profile_last_name'];
}

if (isset($_POST['profile_birth_date'])) {
	$profile_birth_date = $_POST['profile_birth_date'];
}

if (isset($_POST['profile_about'])) {
	$profile_about = $_POST['profile_about'];
}

if (isset($_POST['profile_address'])) {
	$profile_address = $_POST['profile_address'];
}

if (isset($_POST['profile_critic'])) {
	$profile_critic = $_POST['profile_critic'];
}

if (isset($_POST['is_author'])) {
	$is_author = $_POST['is_author'];
}

$allowed_extensions = array('jpg', 'jpeg', 'png');
$submit_param = array('profile_first_name', 'profile_last_name'); //, 'profile_birth_date');
$image_error = ""; 
$errors = array(
	'profile_first_name' => '',
	'profile_last_name' => '',
	'profile_birth_date' => '',
);

if (isset($_POST['submit'])) {
	foreach ($submit_param as $param => $value) {
		if (empty($_POST[$value])) {
			$errors[$value] = "This field is required <br>";
		}
	}

	if (!empty($_FILES['image']['name'])) {
		$img_name = $_FILES['image']['name'];
		$img_size = $_FILES['image']['size'];
		$tmp_name = $_FILES['image']['tmp_name'];
		$error = $_FILES['image']['error'];

		if ($error === 0) {
			if ($img_size > 2125000) {
				$image_error = "File too large";
				$upload_path = '../image/profile_placeholder.png';
			} else {
				$img_ex = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
				if (in_array($img_ex, $allowed_extensions)) {
					$img_name_redux = uniqid("IMG-", true) . '.' . $img_ex;
					$upload_path = 'uploads/' . $img_name_redux;
					move_uploaded_file($tmp_name, $upload_path);
					// Get all the submitted data from the form
				} else {
					$image_error = "Wrong extension type (should be .jpg, .jpeg, .png)";
					$upload_path = '../image/profile_placeholder.png';
				}
			}
		} else {
				$image_error = "Please upload a cover page";
				$upload_path = '../image/profile_placeholder.png';
		}
	}
	// }

	// $profile_first_name = mysqli_real_escape_string($conn, $_POST["profile_first_name"]);
	// $profile_last_name = mysqli_real_escape_string($conn, $_POST["profile_last_name"]);
	// $profile_birth_date = mysqli_real_escape_string($conn, $_POST["profile_birth_date"]);
	// $profile_about = mysqli_real_escape_string($conn, $_POST["profile_about"]);
	// $profile_address = mysqli_real_escape_string($conn, $_POST["profile_address"]);
  //   $profile_critic = $_POST['is_critic'];
  //   $profile_author = $_POST['is_author'];


	if (!array_filter($errors) && empty($image_error)) {

		print_r($_POST);
		$profile_critic = $_POST['is_critic'];
        $profile_author = $_POST['is_author'];

		$sql = "UPDATE user SET first_name=\"$profile_first_name\", last_name=\"$profile_last_name\", about=\"$profile_about\", address=\"$profile_address\", profile_picture=\"$upload_path\", 
        author=$profile_author, critic=$profile_critic where user_id = " . $uid . ";";

        //echo "<h1>$sql</h1>";
            // die;
		if (mysqli_query($conn, $sql)) {
			//mysqli_close($conn);
			//$_SESSION['name'] = $profile_first_name;

            echo "<h1> $sql  </h1>";
			header('Location: profile.php?uid=' . $uid);

		} else {
			echo "SQL ERROR: " . mysqli_error($conn);
			die;
		}
	} else {
		echo "<h1>ZA</h1>";
		die;
	}

}
?>


<!DOCTYPE html>
<html>

<div class=" brand-dark" style="padding: 150px 7%;">
	<?php echo "<form action=\"admin_edit_profile.php?user_id=$uid\" method=\"POST\" enctype=\"multipart/form-data\">"; ?>
		<div class="row">
			<div class="col s3">
				<?php echo "<img src=\"$upload_path\" style=\"margin: 5px; margin-top:20px;\" width=\"127\" height=\"145\" onerror=\"../image/user_placeholder.jpg\">"; ?>
					<input type="file" name="image" id="image">
					<?php echo "<p class=\"red-text\">$image_error</p>"; ?>

			</div>


			<div class="col s9" style="background: #AAD5FF">

				<div class="col s12">
					<?php
						echo "<input type=\"text\" value=\"$profile_first_name\" name=\"profile_first_name\" class=\"z-depth-0 text brand-anan\" placeholder=\"First Name\" style=\"float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;\">";
					 	$error = $errors['profile_first_name']; echo "<p class=\"red-text\">$error</p>";

						echo "<input type=\"text\" value=\"$profile_last_name\" name=\"profile_last_name\" class=\"z-depth-0 text brand-anan\" placeholder=\"Last Name\" style=\"float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;\">";
					 	$error = $errors['profile_last_name']; echo "<p class=\"red-text\">$error</p>";

						echo "<textarea name=\"profile_about\" style=\"float: left; margin-top: 15px; padding: 10px; width: 100%; height: 100%; background-color:#7fa1bf; border-color: white;\" class=\"text\">$profile_about</textarea>";
						// $error = $errors['profile_about']; echo "<p class=\"red-text\">$error</p>";

						echo "<textarea name=\"profile_address\" style=\"float: left; margin-top: 15px; padding: 10px; width: 100%; height: 100%; background-color:#7fa1bf; border-color: white;\" class=\"text\" placeholder=\"Address\">$profile_address</textarea>";

						echo "<label style=\"\">Is author</label>";
						echo "<input type=\"text\" id=\"is_author\" name=\"is_author\" value=\"$profile_author\" style=\"width: 30px; height: 30px; margin-top: 15px; padding: 10px; \">";
                        echo "<br>";
						echo "<label style=\"\">Is critic</label>";		
						echo "<input type=\"text\" id=\"is_critic\" name=\"is_critic\" value=\"$profile_critic\" style=\"width: 30px; height: 30px; margin-top: 15px; padding: 10px; \">";

						echo "
							<div class=\"input-field\" style=\"width:40.5%; margin-left:29%;\">
  								<input type=\"date\" class=\"datepicker text\" value=\"$profile_birth_date\" name=\"profile_birth_date\" id=\"register_bdate\" style=\"background-color:#7fa1bf; border-color: white; padding:12px;\">
  						</div>";
					?>

					<div style="float: right; margin: 15px">
						<input type="submit" value="Submit" name="submit" id="submit" class="btn brand-btn">
					</div>
				</div>
	</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
	$(document).ready(function() {
		$('select').formSelect();
	});
</script>

<script>
  		$(document).ready(function() {
  			$('.datepicker').datepicker({
  				defaultDate: new Date(2000, 1, 31),
  				maxDate: new Date(2015, 12, 31),
  				yearRange: [1928, 2015],
  				format: "yyyy-mm-dd"

  			});
  		});
  	</script>
</body>

</html>