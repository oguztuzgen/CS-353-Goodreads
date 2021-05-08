<?php
	require('style.php');
?>

<ul id="dropdown1" class="dropdown-content">
	<?php 
		$_SESSION['name'] = "Eray1"; // !!! DEBUG DELETE

		if (isset($_SESSION['name'])) { // ! ALSO HERE LOG IN INFO IS CHECKED
			echo "<li><a href=\"#\" class=\"nav-btn\">Friends</a></li>";
			echo "<li><a href=\"#\" class=\"nav-btn\">Reading Challenges</a></li>";
			echo "<li><a href=\"#\" class=\"nav-btn\">Upload a book</a></li>";
			echo "<li><a href=\"#\" class=\"nav-btn\">Log out</a></li>";
		} else {
			echo "<li><a href=\"#\">Login</a></li>";
			echo "<li><a href=\"#\">Register</a></li>";
		}
	?>
</ul>

<div class="header navbar-fixed">
	
	<nav class="header">
		<div class="brand nav-wrapper" style="width: 90%; height: 90%; padding: 5px; margin:auto;">
			<div style="float: left; padding-left: 30px;">
				<img src="../image/ordek_kafa.png" style="float: left;" alt="DuckRead" width="150" height="150" class="rotateimg180 flipimgy">
				<a href="index.php" class="brand-text" style="padding-top: 20px">DuckRead</a>
			</div>

			<ul class="center" style="float: right;">
				<li><a href="index.php" class="nav-btn">Home</a></li>
				<li><a href="index.php" class="nav-btn">My Books</a></li>
				<li><a href="index.php" class="nav-btn">Browse</a></li>
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
</div>	

<script>
		document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems);
  });
</script>