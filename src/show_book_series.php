<!DOCTYPE html>
<html>
<?php
require('template/header.php');
require('template/config.php');


if (!isset($_GET['series_id'])) {
    echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
    die;
}

$series_id = $_GET['series_id'];


$sql = "SELECT b.title as book_title, b.author, b.book_id, b.book_cover, s.series_name as series_title, s.origin_id
        FROM book b, series s, belongs_to bl
        WHERE b.book_id = bl.book_id and  s.series_id = bl.series_id AND s.series_id = $series_id";


if ($result = mysqli_query($conn, $sql)) {
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "SQL SYNTAX ERROR" . mysqli_error($conn);
}

// if empty??

$origin = $result[0]['origin_id'];

$sql2 = "SELECT * FROM book b WHERE b.book_id = $origin";

if ($res = mysqli_query($conn, $sql2)) {

} else {
	echo "<h1>SQL YARRA YEDI <br>$" .$sql2." </h1>";
}
$origin_book = mysqli_fetch_assoc($res);

?>

<div>
    <?php echo "<form action=\"\" method=\"POST\">"; ?>
    <div style="padding: 150px 7%;" class="col s11">
        <div class="brand-dark row">
            <div class="brand col s11" style="margin: 50px">
                <div>
                    <div class="col s11 text">
                        <?php $list_title = $result[0]['series_title'];
                        echo "<h2> $list_title </h2>"; ?>

                    </div>
                    <div class="col s11">
                    <table class="brand" style="margin: 10px;">
                        <thead>
                            <tr>
                                <th> Origin Book</th>
                                <th>Title</th>
                                <th>Author</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                                $img = $origin_book['book_cover'];
                                $title = $origin_book['title'];
                                $author = $origin_book['author'];
                                echo "
																	<tr>
																	<th><img src=\"$img\" width=\"56\" height=\"64\"></th>
																	<th>$title</th>
																	<th>$author</th>
																	</tr>
																";
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col s11" style=" height: 100px">
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