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

$sql = "";

?>

<br><br><br><br><br>
<div class="center1 left text" style="width:50%; margin-left:2%; margin-top:2;">
    <table>
        <tr>
            <h4>
                <?php
                echo $challenge['subject'];
                //echo $sql;

                ?>
            </h4>
        </tr>
        <tr>
            <?php
            while ($review = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

                echo '<tr>';

                $uid = $review['user_id'];
                echo '<td class="center" style="">';

                echo '<div class="row"> <img src="' . $review['profile_picture'] . '" alt="Yoq" style="width: 100px; height:135px;"></div>';
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

                    $toplam+=$progress;
                }

                $toplam = $toplam / $_SESSION['bookAmount'];

                echo '<td class="center" style="">';
                echo $toplam . '%';
                echo '</td>';

                echo '</tr>';
            }
            ?>
        </tr>


    </table>
</div>



</body>

</html>