<!DOCTYPE html>
<html>
<?php
require('template/header.php');
require('template/config.php');


if (!isset($_GET['list_id'])) {
    echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
    die;
}
$search = $name_error = "";

if (isset($_POST['search_btn'])) {
    $search = $_POST['search'];
}

$list_id = $_GET['list_id'];

if (isset($_POST['add'])) {
    $user = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $sql =
        "INSERT INTO lists(list_id, user_id, book_id)
		 VALUES($list_id, $user, $book_id)";

    mysqli_query($conn, $sql);
}

if (isset($_POST['submit'])) {
    if (empty($_POST['list_name'])) {
        $name_error = "Please enter a list name";
    } else {
        $list_title = $_POST['list_name'];
        $sql = "UPDATE book_list SET title = '$list_title' WHERE book_list.list_id = $list_id;";
        mysqli_query($conn, $sql);
    }

    if (empty($_POST['list_description'])) {
        $_POST['list_description'] = "No description";
    }

    $description = $_POST['list_description'];
    $sql = "UPDATE book_list SET description = '$description' WHERE book_list.list_id = $list_id;";

    mysqli_query($conn, $sql);
}

$sql = "SELECT b.title as book_title, b.author, b.book_id, b.book_cover, bl.title as list_title, bl.description, u.first_name, u.last_name
						FROM book b, book_list bl, user u, lists l
						WHERE b.book_id = l.book_id and u.user_id = l.user_id and bl.list_id = l.list_id and l.list_id = $list_id";


if ($result = mysqli_query($conn, $sql)) {
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $user_name = $result[0]['first_name'] . " " . $result[0]['last_name'];
} else {
    echo "SQL SYNTAX ERROR" . mysqli_error($conn);
}



?>

<div>
    <?php echo "<form action=\"\" method=\"POST\">"; ?>
    <div style="padding: 150px 7%;" class="col s11">
        <div class="brand-dark row">
            <div class="brand col s11" style="margin: 50px">
                <div>
                    <div class="col s11 text">
                        <?php $list_title = $result[0]['list_title'];
                        echo "<h2> $list_title </h2>"; ?>

                        <?php 
                            echo '<h4>';
                            echo $result[0]['description'];
                            echo '</h4>';
                        ?>

                    </div>
                    <div class="col s11">
                        <?php echo "<div class=\"brand-text-alt\" style=\"color: #473335; margin-top: 25px; padding-bottom:25px;\">Created by $user_name</div>"; ?>
                    </div>
                </div>

                <div style="padding-top: 100px; font-size:16px;">
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
                            <?php
                            foreach ($result as $book) {
                                $img = $book['book_cover'];
                                $title = $book['book_title'];
                                $author = $book['author'];
                                echo "
																	<tr>
																	<th><img src=\"$img\" width=\"56\" height=\"64\"></th>
																	<th>$title</th>
																	<th>$author</th>
																	</tr>
																";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</html>