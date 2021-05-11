<?php
    require("template/header.php");
    require('template/config.php');
?>
<?php
    echo $_SESSION['xd'];

    $book_id = $_SESSION['xd'];

    $sql = "select * from book where book_id = '$book_id';";

    $result = mysqli_query($conn, $sql);

		$book = mysqli_fetch_assoc($result);

    $cover = $book['book_cover'];


		// !!!! JOIN QUERY TO GET GENRE NAME
    $sql = "select genre_name from genre g, has_genre hg where g.genre_id = hg.genre_id and hg.book_id = '$book_id';";
    $result = mysqli_query($conn, $sql);
    
?>

<br><br><br><br><br> <br>

<div class="row text" style="background-color:white; padding: 10px; margin: 20px 20px 20px 20px">
    <div class="col">
    <?php
			echo '<img src="' . $cover . '" alt="Yoq" style="width: 100px; height:135px;">';
            
    ?>
    </div>

    <div class="col">
        <div class="col">
            <?php echo '<p>' . $book['title'] . '</p>'; ?>
            <?php echo '<p> by ' . $book['author'] . '</p>'; ?>
            <?php echo '<p> Page Count: ' . $book['page_count'] . '</p>'; ?>
            <?php echo '<p> Publish Date: ' . $book['date_published'] . '</p>'; //sadece yıl ay?> 
            <?php echo '<p> Original Name: ' . $book['original_title'] . '</p>'; ?>
            <?php echo '<p> Language: ' . $book['language'] . '</p>'; ?>
        </div>
        <div class="col">
            Genres
            <ul>
                <?php 
                    while($genre = mysqli_fetch_assoc($result)){
                        echo '<li>';

                        echo $genre['genre_name'];


                        echo '</li>';
                    }


                ?>
            </ul>
        </div>

        
            
            
        

    </div>
</div>

</body>
</html>

