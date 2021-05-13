<?php
	// error_reporting(0);
	require('style.php');
	require('config.php');
	$uid = $_SESSION['user_id'];
	

?>

<ul id="dropdown1" class="dropdown-content">
	<?php
		if (isset($_SESSION['name'])) { // ! ALSO HERE LOG IN INFO IS CHECKED
			$this_file = htmlspecialchars('<?php echo $_SERVER["PHP_SELF"];?>');
			if($_SESSION['isAdmin'] == 0){
				echo "<li><a href=\"profile.php?uid=$uid\" class=\"nav-btn\">Profile</a></li>";
			}
			echo "<li><a href=\"#\" class=\"nav-btn\">Friends</a></li>";
			echo "<li><a href=\"create_book_list.php?uid=$uid\" class=\"nav-btn\">Create a new book list</a></li>";
			echo "<li><a href=\"reading_challenges.php\" class=\"nav-btn\">Reading Challenges</a></li>";
			echo "<li><a href=\"#\" class=\"nav-btn\">Upload a book</a></li>";
			echo "<li><a href=\"logout.php\" id=\"logout\" class=\"nav-btn\">Log out</a></li>";
			if($_SESSION['isAdmin'] == 1){
				echo "<li><a href=\"reports.php\" id=\"reports\" class=\"nav-btn\">Reports</a></li>";
			}
		} else {
			echo "<li><a href=\"login.php\">Login</a></li>";
			echo "<li><a href=\"login.php\">Register</a></li>";
		}
	?>
</ul>


<!-- TODO FOR EVERY PAGE ADD CLOSING BODY TAG TO THE END -->

<body class="header navbar-fixed">
	
	<nav class="header">
		<div class="brand nav-wrapper" style="width: 90%; height: 90%; padding: 5px; margin:auto;">
			<div style="float: left; padding-left: 30px;">
				<img src="../image/ordek_kafa.png" style="float: left;" alt="DuckRead" width="150" height="150" class="rotateimg180 flipimgy">
				<a href="index.php" class="brand-text" style="padding-top: 20px">DuckRead</a>
			</div>

			<ul class="center" style="float: right;">

			<li><a href="index.php" class="nav-btn">Home</a></li>
				<li><a href="index.php" class="nav-btn">Browse</a></li>

			<?php
			// $_SESSION['name'] = "yarro eray";

				if (isset($_SESSION['name'])) { // ! ALSO HERE LOG IN INFO IS CHECKED
					$this_file = htmlspecialchars('<?php echo $_SERVER["PHP_SELF"];?>');
					echo "<li><a href=\"my_books.php\" class=\"nav-btn\">My Books</a></li>";
					echo "<li><a href=\"book_upload.php\" class=\"nav-btn\">Upload a book</a></li>";
				}
			?>
			<li><a class="dropdown-trigger nav-btn" href="#!" data-target="dropdown1"> 


				
					<?php

						if (isset($_SESSION['name'])) {
							// TODO small logo echo "<>"
							echo "Welcome " . $_SESSION['name']; // ! CHECKING SESSION NAME IF THE USER IS LOGGED IN
						} else {
							echo "Login/Register";
						}
					?> 
					<i class="material-icons right">arrow_drop_down</i>
					</a></li>
			</ul>

		</div>
	</nav>
<!-- </div>	 -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems, {}); // ! options removed
  });
</script>
