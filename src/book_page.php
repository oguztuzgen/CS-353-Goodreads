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

        <div class="col center " style="border:2px solid grey; width: 250px; margin:auto;">
            <?php echo '<p> Description: <br>' . $book['description'] . '</p>'; ?>
        </div>

    </div>
</div>

<div class="row text blue lighten-4" style="padding: 10px; width:75%;">

    <div class="col s3" style="border: 3px solid black; text-align:left;">
        <p>Your Rating:</p>

        <div class="left-align">
            <form action="book_page.php" method="POST">
                <div class="rating left-align">
                    <span><input type="radio" name="rating" id="str5" value="5"><label for="str5"></label></span>
                    <span><input type="radio" name="rating" id="str4" value="4"><label for="str4"></label></span>
                    <span><input type="radio" name="rating" id="str3" value="3"><label for="str3"></label></span>
                    <span><input type="radio" name="rating" id="str2" value="2"><label for="str2"></label></span>
                    <span><input type="radio" name="rating" id="str1" value="1"><label for="str1"></label></span>
                </div>





                <script>
                    $(document).ready(function() {
                        $(".rating input:radio").attr("checked", false);

                        $('.rating input').click(function() {
                            $(".rating span").removeClass('checked');
                            $(this).parent().addClass('checked');
                        });

                        document.cookie = "rating=" + 0;
                        $('input:radio').change(
                            function() {
                                var userRating = this.value;
                                document.cookie = "rating=" + userRating;
                            });
                    });
                </script>



        </div>

        <!-- <p id="stars">No Stars</p>

        <script>
            var slider = document.getElementById('test5');
            var stars = document.getElementById('stars');

            stars.innerHTML = slider.value; // Display the default slider value

            // Update the current slider value (each time you drag the slider handle)
            slider.oninput = function() {
                stars.innerHTML = this.value;
            }
        </script> -->
    </div>
    <div class="col s1">

    </div>
    <div class="col s8 white vertical-align text" style="border: 3px solid black;">

        <input type="text" placeholder="Enter Your Rating Description..." class="text" name="reviewBox">
        <input type="submit" name="baban" class="right btn blue lighten-1" value="Submit Review">
        </form>
        <br><br>
        <?php
        if (isset($_POST['baban'])) {
            //echo ' ' . $_COOKIE["rating"];
            //echo ' ' . $_POST['reviewBox'];

            $sql = "insert into review (content, rating) values ('" . $_POST['reviewBox'] . "', " . $_COOKIE["rating"] . ");";
            if (mysqli_query($conn, $sql)) {
                //echo 'za';
            }

            $sql = "select max(review_id)
                from review;";
            $res = mysqli_query($conn, $sql);
            $rev_id = mysqli_fetch_array($res, MYSQLI_ASSOC);

            //echo $rev_id['max(review_id)'] . " " . $_SESSION['user_id'];

            $sql = "insert into reviews(review_id, user_id, book_id) values (" . $rev_id['max(review_id)'] . ", " . $_SESSION['user_id'] . "," . $book_id . ");";
            if (mysqli_query($conn, $sql)) {
                //echo 'succesful insertion';
            }
        }
        ?>
    </div>
</div>

<div class="row text blue lighten-4" style="padding: 10px; width:75%;">

    <p>Reviews:</p>



    <?php
    // echo $book_id;
    $sql = "select u.first_name, r.date_sent, r.content, r.rating, r.likes, u.profile_picture
        from reviews rw, review r, user u
        where rw.review_id = r.review_id and rw.book_id = " . $book_id . " and rw.user_id = u.user_id";

    $res = mysqli_query($conn, $sql);
    // print_r($res);



    while ($review = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

        echo '<div class="row text">';

        echo '<div class="col center" style="width: 200px;">';
        echo '<img src="' . $review['profile_picture'] . '" alt="Yoq" style="width: 100px; height:135px;">';
        echo '<br>';
        echo $review['date_sent'];
        echo '</div>';

        echo '<div class="col center" style="width: 400px;">';

        echo '<div class="row">';
        echo '<pre class="text"> User Name: ';
        echo $review['first_name'];
        echo '                  Rating:    ';
        echo $review['rating'];
        echo '</pre>';


        echo '</div>';

        echo '<div class="row">';
        echo $review['content'];
        echo '</div>';

        echo '</div>';




        echo '</div>';
    }

    ?>

</div>


<div class="col">
    <br>
</div>
<p></p>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>






</body>

</html>