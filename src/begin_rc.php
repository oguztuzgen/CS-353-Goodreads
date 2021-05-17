<?php
	if (!($_SESSION['isAdmin'])) {
		header('Location: index.php');
	}

	//$uid = $_GET['uid'];
	require('template/config.php');

	$sql = "INSERT INTO reading_challenge(subject, amount)
					VALUES('', 0)";

	if(mysqli_query($conn, $sql)){
        echo "<script> alert(Noooooooo) </script>";
    }
	
	$sql = "SELECT max(rc_id) as rc_id FROM reading_challenge";

	$rc_id = mysqli_fetch_assoc(mysqli_query($conn, $sql));

	$rc_id = $rc_id['rc_id'];

	echo $rc_id;

	// $sql = "INSERT INTO lists(list_id, user_id, book_id)
	// 				VALUES($list_id, $uid, )";


	header("Location: create_rc.php?rc_id=$rc_id"); // ! ADD HERE LIST ID
?>