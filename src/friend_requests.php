<?php
//require('template/config.php');
require('template/header.php');
if (!$conn) {
    echo "Error in connection";
}
$uid = $_GET['uid'];

$sql = "select *
from friend_requests
where recieve_user = " . $uid . " ;";

if ($res = mysqli_query($conn, $sql)) {
    $info = mysqli_fetch_all($res, MYSQLI_ASSOC);

    mysqli_free_result($res);

    //mysqli_close($conn);
} else {

    echo "<br><br><br><br><br>FATAL ERROR ";
    die;
}
?>
<?php 
    if(isset($_POST['accept'])){
        $sql2 = "insert into friends (user_id, friend_id) values(" . $uid. ", ". $_POST['takeThis'] . ");";
        mysqli_query($conn, $sql2);

        $sql2 = "insert into friends (user_id, friend_id) values(" .$_POST['takeThis'] . ", ". $uid . ");";
        mysqli_query($conn, $sql2);

        $sql2 = "delete from friend_requests where recieve_user = " . $uid . " ;";
        mysqli_query($conn, $sql2);

        header("Location: friend_requests.php?uid=$uid");
    }
    ?>

<br><br><br><br><br><br><br>
<body>

    <div class="row blue lighten-3 text" style="width: 75%;">
        <table>
            <?php foreach ($info as $inf) : ?>
                <tr>    
                    <?php
                    $sql = "select * from user where user_id = " . $inf['send_user'] . " ;";
                    //echo $sql;
                    $res = mysqli_query($conn, $sql);
                    $user = mysqli_fetch_array($res);
                    ?>
                    <td>
                        <img src="<?php echo $user['profile_picture']; ?>" width="150px" height="150px" alt="" onerror=this.src="../image/profile_placeholder.jpg">
                        <h5> <?php echo $user['first_name'] . $user['last_name'] ;?></h5>

                    </td>

                    <td>
                        <form action="" method="POST">
                            <input type="hidden" value="<?php echo $user['user_id']; ?>" name="takeThis">
                            <input type="submit" class = "button " name="accept" value="Accept Request">
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>

        </table>
    </div>
    
</body>

</html>