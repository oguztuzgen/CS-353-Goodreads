<?php
require("template/header.php");
require('template/config.php');
?>
<?php
// echo $_SESSION['xd'];

if (!isset($_GET['book_id'])) {
    echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
    die;
}

$book_id = $_GET['book_id'];
//$book_id = 605;

$sql = "select * from book where book_id = '$book_id';";

$result = mysqli_query($conn, $sql);

$book = mysqli_fetch_assoc($result);

$cover = $book['book_cover'];


// !!!! JOIN QUERY TO GET GENRE NAME
$sql = "select genre_name from genre g, has_genre hg where g.genre_id = hg.genre_id and hg.book_id = '$book_id';";
$result = mysqli_query($conn, $sql);

?>


<br><br><br><br><br>

<div class="row text blue lighten-4 valign-wrapper" style="padding: 10px; width:75%; ">
    <div class="col center " style="width: 200px;">
        <?php
        echo '<img src="' . $cover . '" alt="Yoq" style="width: 100px; height:135px;">';

        ?>
    </div>

    <div class="col ">
        <div class="col " style="width: 450px;">
            <?php echo '<p>' . $book['title'] . '</p>'; ?>
            <?php echo '<p> by ' . $book['author'] . '</p>'; ?>
            <?php echo '<p> Page Count: ' . $book['page_count'] . '</p>'; ?>
            <?php echo '<p> Publish Date: ' . substr($book['date_published'], 0, -3) . '</p>'; ?>
            <?php echo '<p> Original Name: ' . $book['original_title'] . '</p>'; ?>
            <?php echo '<p> Language: ' . $book['language'] . '</p>'; ?>

        </div>
        <div class="col" style="width: 250px;">
            <p>Genres</p>

            <ul>
                <?php
                while ($genre = mysqli_fetch_assoc($result)) {
                    echo '<li>';
                    echo $genre['genre_name'];
                    echo '</li>';
                }
                ?>
            </ul>
        </div>

        <div class="col center " style="border:2px solid grey; width: 250px; margin:auto; padding: 10px 10px 10px 10px;">
            <?php echo '<p> Description: <br>' . $book['description'] . '</p>'; ?>
        </div>

    </div>
</div>

<div class="row text blue lighten-4 center-align" style="padding: 30px; width:75%;">
    <form action="" method="POST">
        <input type="number" min="1" class="text" name="numBox">
        <input type="date" placeholder="Enter Your Date Count" class="text" name="dateBox">
        <input type="submit" name="logs" class="btn blue lighten-1" value="Submit Log" style="margin:auto">
    </form>



    <?php // insertion to database
    if (isset($_POST['logs'])) {
        $uid =  $_SESSION['user_id'];
        $date = $_POST['dateBox'];
        $num = $_POST['numBox'];
        $sql = "insert into logs (user_id, book_id, date, count) values ( '$uid', '$book_id', '$date', '$num');";
        if (mysqli_query($conn, $sql)) {
            //echo 'za';
        }
    }
    ?>
</div>

<div class="row text blue lighten-4 center-align" style="padding: 30px; width:75%;">
    <?php
    $uid =  $_SESSION['user_id'];
    $sql = "select sum(count)
        from logs l
        where l.user_id = '$uid' and l.book_id = '$book_id'";

    $sum = mysqli_query($conn, $sql);

    $readed = mysqli_fetch_array($sum, MYSQLI_ASSOC);

    $progress = $readed['sum(count)'] / $book['page_count'];
    $progress = $progress * 100;

    if ($progress >= 100) {
        echo 'Book is Finished';
    } else {
        echo '%' . $progress;
    }


    ?>


</div>