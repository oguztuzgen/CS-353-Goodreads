<?php
require('template/header.php');
require('template/config.php');


if (!isset($_GET['challenge_id'])) {
    echo "<h1><br><br>404: NOT FOUND</h1>";
    die;
}
$rc_id = $_GET['challenge_id'];
// $rc_id = 100;

$sql = 'select amount, subject
from reading_challenge where rc_id =' . $rc_id . ';';
$res = mysqli_query($conn, $sql);
$challenge = mysqli_fetch_array($res, MYSQLI_ASSOC);
// challenge['subject'], challenge['amount']


//$sql = "select user_id from rc_participates where rc_id = " . $rc_id . ";";
$sql = "select u.profile_picture, u.user_id, u.first_name from rc_participates rc, user u where rc.rc_id = " . $rc_id . " AND rc.user_id = u.user_id;";
$res = mysqli_query($conn, $sql);


?>

<br><br><br><br><br>
<div class="center1 left text" style="width:50%; margin-left:2%; margin-top:2;">
    <table>
        <tr style="padding:15px;">
            <h4>
                <?php
                echo $challenge['subject'];
                //echo $sql;

                ?>
            </h4>
        </tr>
        <tr style="padding:15px;">
            <?php echo '<form action="challenge.php?challenge_id=' . $rc_id . '"method="POST">' ?>
            <input type="submit" class="btn" name="join" value="Join the Challenge" onclick="func()">
            </form>
            <hr style="width: 100%">
            <?php
            if (isset($_POST['join'])) {
                $sql = "insert into rc_participates (rc_id, user_id)
                            values (" . $rc_id . "," . $_SESSION['user_id'] . ");";

                if (mysqli_query($conn, $sql)) {
                    echo '<p style="color:green">Joined Succesfully</p>';
                } else {
                    echo '<p style="color:red">DUM DUM</p>';
                }
                header("challenge.php?challenge_id=" . $rc_id); // bi sorun var refresh istiyor
                header("challenge.php?challenge_id=" . $rc_id);
            }
            ?>
        </tr>

        <tr>
            <table>
                <?php

                while ($review = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

                    echo '<tr>';

                    $uid = $review['user_id'];
                    echo '<td class="center" style="">';

                    echo '<div class="row"> <img src="' . $review['profile_picture'] . '" onerror=this.src="../image/profile_placeholder.jpg" style="width: 100px; height:135px;"></div>';
                    echo '<div class="row">' . $review['first_name'] . '</div>';

                    echo '</td>';

                    $query = 'select b.book_id, b.page_count
                from book b, rc_books rc
                where b.book_id = rc.book_id and rc.rc_id =' . $rc_id . ';';
                    $result = mysqli_query($conn, $query);
                    $toplam = 0;

                    while ($bok_id = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                        $qry = "select sum(count)
                    from logs l
                    where l.user_id = '$uid' and l.book_id = '" . $bok_id['book_id'] . "'";

                        $sum = mysqli_query($conn, $qry);
                        $readed = mysqli_fetch_array($sum, MYSQLI_ASSOC);
                        $progress = $readed['sum(count)'] / $bok_id['page_count'];
                        $progress = $progress * 100;

                        $toplam += $progress;
                    }

                    if ($_SESSION['bookAmount'] == 0) {
                    } else {
                        $toplam = $toplam / $_SESSION['bookAmount'];
                    }

                    $toplam = (int) $toplam;
                    echo '<td class="center" style="">';
                    echo $toplam . '%';
                    echo '<br>';
                    echo '<progress id=\"baban\" value="' . $toplam . '" max="100"></progress>';
                    echo '</td>';

                    echo '</tr>';
                }
                ?>


            </table>
        </tr>


    </table>
</div>

<div class="row right white text" style="width:40%; margin-right: 50px;">

    <h3> Books in the Challenge </h3>

    <?php
    $sql = 'select *
            from rc_books rc, book b
            where rc_id =' . $rc_id . ' and b.book_id = rc.book_id';
    $res = mysqli_query($conn, $sql);

    while ($books = mysqli_fetch_array($res)) {
        echo '<div class="col center">';
        echo '<img src="' . $books['book_cover'] . '" onerror=this.src="../image/cover_book.jpg" style="width: 100px; height:135px;">';
        echo '<h5>' . $books['title'] . '</h5>';

        //echo '</div>';
    }
    ?>


</div>


</body>

</html>