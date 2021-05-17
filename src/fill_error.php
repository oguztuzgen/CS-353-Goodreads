<?php
require("template/header.php");
require('template/config.php');


$book_id = $_GET['book_id'];
?>
<br><br><br><br><br>
<?php 
if(isset($_POST['send'])){

    // echo $_POST['description'];

    $sql = "insert into error_report(report_message, report_type) values('". $_POST['description'] ."', 'BOOK');";
    // echo $sql;
    mysqli_query($conn, $sql);

    $sql = "select max(report_id) from error_report;";
    $res = mysqli_query($conn, $sql);

    $r_id = mysqli_fetch_array($res);

    $sql = "insert into reports(user_id, book_id, report_id) values (".$_SESSION['user_id']." , " . $book_id . " , " . $r_id['max(report_id)'] . "); ";
    // echo $sql;
    if(mysqli_query($conn, $sql)){
    ?>
    <p class="text " style="color: green; text-align:center;"> Report Succesfully Sent Turn Back to Index Page or Fill in Another Report About the Book </p>
    
<?php
}
}
?>



<html>

<body>

    <div class="row blue lighten-3 text center" style="width: 50%; padding:20px;">
        <form action="" method="POST">
            <div class="row">
                <textarea name="description" style="float: left; margin-top: 15px; padding: 10px; width: 60%; height: 120px; background-color:#7fa1bf; border-color: white;" class="text" placeholder="Enter your error description"></textarea>
            </div>
            <div class="row left">
                <input type="submit" name="send" value="Send Report" class="btn">
            </div>

        </form>

    </div>


</body>

</html>