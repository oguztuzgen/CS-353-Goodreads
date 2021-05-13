<?php
	if (!isset($_GET['uid'])) {
		header('Location: index.php');
	}

	$uid = $_GET['uid'];
	require('template/config.php');

	$sql = "INSERT INTO book_list(title, description)
					VALUES('', '')";

	mysqli_query($conn, $sql);
	
	$sql = "SELECT max(list_id) as list_id FROM book_list";

	$list_id = mysqli_fetch_assoc(mysqli_query($conn, $sql));

	$list_id = $list_id['list_id'];

	echo $list_id;

	// $sql = "INSERT INTO lists(list_id, user_id, book_id)
	// 				VALUES($list_id, $uid, )";


	header("Location: edit_book_list.php?list_id=$list_id"); // ! ADD HERE LIST ID
?>