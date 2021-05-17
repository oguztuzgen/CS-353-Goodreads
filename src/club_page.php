<?php
	// error_reporting(0);
	require('template/config.php');
	require('template/header.php');

	// HANDLE POST REQUESTS HERE


	// UNTIL HERE
	if (!isset($_GET['club_id'])) {
		echo "<br><br><br><br><br><h1>404 NOT FOUND</h1>";
    die;
	}

	$club_id = $_GET['club_id'];   

    
?>


<!DOCTYPE html>

<html>
	<br><br><br><br><br><br>

	<div class="row">
		<div class="col s8">
            <?php
                $sql = "SELECT * FROM bc_post WHERE post_id IN (SELECT post_id FROM bc_post_belongs WHERE bc_id = $club_id) " ;
                if ($result = mysqli_query($conn, $sql)) {
                    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                }
                else{
                        echo "FAILED TO EXECUTE QUERY";
                }
                $sql1 = "SELECT * FROM book_club WHERE club_id = '$club_id'";
                if ($res1 = mysqli_query($conn, $sql1)) {
                    $result1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
                    echo " <h1>" .$result1["name"]. "</h1>";
                    $sql2 = "SELECT book_cover FROM book WHERE book_id =(SELECT book_id FROM book_club WHERE club_id = $club_id)";
                    $res2 = mysqli_query($conn, $sql2);
                    $result2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);
                    echo "<img src=\"" . $result2["book_cover"] . "\"  width=\"300\" height=\"405\"  alt= \"No image\"> ";
                    echo " <h4>" . "Member count = " . $result1["member_count"]. "</h4>";

                }
                else{
                        echo "FAILED TO EXECUTE QUERY";
                }
                
            ?> 
            <?php foreach($result as $res): ?>
                <?php
                $pid = $res["post_id"];
                //echo $pid;
                $sql3 = "SELECT * FROM user WHERE user_id IN(SELECT user_id FROM posts WHERE post_id = $pid) ";
                $res3 = mysqli_query($conn, $sql3);
                $result3 = mysqli_fetch_array($res3, MYSQLI_ASSOC);
                ?>
                <table style = "width:100%">
                    <tr>
                        <td style = "text-align:left"> <?php echo "<h4>" .$result3["first_name"]. "</h4>" ?></td>
                        <td style = "text-align:left"> <?php echo $res["content"];?> </td>		 
                    </tr>
                </table>

                
                
            <?php endforeach ?>
            <input type="text" placeholder="Enter Your Comment..." class="text" name="reviewBox">
            <input type="submit" name="comment" class="btn blue lighten-1" value="Submit Review" style="margin:auto">
            <?php if (isset($_POST['comment'])) {
                    $maxid = max($result["post_id"]);
                    $sql = "insert bc_post(post_id, content) values ( '$maxid' + 1, $_POST['reviewBox'])";
                    if (mysqli_query($conn, $sql)) {
                        //echo 'za';
                    }

                    $sql = "select max(review_id)
                    from review;";
                    $res = mysqli_query($conn, $sql);
                    $rev_id = mysqli_fetch_array($res, MYSQLI_ASSOC);

                    $sql = "insert into reviews(review_id, user_id, book_id) values (" . $rev_id['max(review_id)'] . ", " . $_SESSION['user_id'] . "," . $book_id . ");";
                    if (mysqli_query($conn, $sql)) {
                        //echo 'succesful insertion';
                    }
                }
            ?>


		</div>
		<div class="col s4">
			
		</div>
	</div>
	

</body>

</html>