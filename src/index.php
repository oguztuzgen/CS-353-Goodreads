<!DOCTYPE html>
<html>
<?php

require('template/header.php');
require('template/config.php');

$flag = 0;

$search;
$search = "";
?>

<?php
if (isset($_GET['ordek_x'])) {

  echo $_GET['xd'];
  $_SESSION['xd'] = $_GET['xd'];
  echo $_SESSION['xd'];
  header("Location: book_page.php");
}

?>

<br><br><br><br><br>
<div>
  <div class="">
    <table cellspacing="25">
      <tr>
        <td style="width: 20%">
          <blockquote cite="annen" style="font-family:Comic sans ms; font-size:16px; color:white; padding-right: 10px">
            "The chances of being killed by a duck are low but never zero." <br>
            - Steve Irwin
          </blockquote>
        </td>

        <td style="width: 10%;"></td>

        <td style="width: 70%; font-size: 32px;color:white; font-family:Comic sans ms; text-align:left; padding: 10px;">
          <p>Search</p>

          <form class="" action="" method="POST" name="thisForm">
            <input type="text" name="search_bar" placeholder="Search a book..." style="padding: 15px; width: 50%; background-color:#7fa1bf;" class="text">
            <input type="submit" value="Search" name="button" style="background-color:#7fa1bf; padding:12px; width:10%" class="text">
            <!-- </form> -->
        </td>
      </tr>
    </table>
  </div>

  <br>

  <div class="text">
    <table class="" cellspacing="10px">
      <tr>
        <td style="background-color: #80A1C0; text-align:left; width: 10%; vertical-align:top; ">
          <div class="text" style="margin-top: 5%; margin-left: 5%;">
            AVAILABLE FILTERS:<br><br>

            <!-- <form action="" method="POST"> -->
            <?php
            $sql = "SELECT * FROM genre;";

            $result = mysqli_query($conn, $sql);
            $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($genres as $index => $pair) {
              $genre_id = $pair["genre_id"];
              $genre_name = $pair["genre_name"];

              echo "
                    <p class=''>
                      <label >
                        <input type='checkbox' name='genr[]' value='$genre_id'/>
                        <span style='color:black; font-size:16px;' >$genre_name</span>
                      </label>
                    </p>";
            }
            ?>

            </form>




          </div>
        </td>

        <td style="width: 1.5%;"></td>

        <td style="width: 40%; background-color: #80A1C0;">
          <div class="row text">
            <div class="col s4">
              <h4>Cover</h4>
            </div>

            <div class="col s4">
              <h4>Title</h4>
            </div>

            <div class="col s4">
              <h4>Author</h4>
            </div>
          </div>

          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" ||  $flag == 0) {
            //echo $_POST['search_bar'];
            $flag = 1;
            global $search;
            // error_reporting(0);

            $search = $_POST['search_bar'];
            //$genrebar = $_POST['genr'];



            $query = "select book_cover,title,author,book_id from book";

            $res = mysqli_query($conn, $query);

            while ($books = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

              $title = $books['title'];
              $author = $books['author'];

              if (strpos($title, $search) !== false || strpos($author, $search) !== false) {

                echo "<div class='row text'>";

                echo "<div class='col s4' style=''>";
								
								$cover = $books['book_cover'];

                $tmp = $books['title'];
                echo '<form action="index.php" method="GET">
                                  <div class="container">
                                      <input type = "image" name="ordek"
                                      src="' . $cover . '" style="width: 100px; height: 135px;" alt="Image" formmethod="get">

                                  </div>';


                echo "</div>";

                

                echo "<div class='col s4' style='margin-top: 75px;'> 
                                <p class='text'>
                                  $tmp
                                </p>
                              </div>";

                $tmp = $books['author'];
                echo "<div class='col s4' style='margin-top: 75px'> 
                                <p>
                                  $tmp
                                </p>
                              </div>";

                $tmp = $books['book_id'];
                              
                echo "<input type='hidden' name='xd' value='$tmp' style=''>";

                echo '</form>';
                echo "</div>";
              }
            }
          }
          ?>



          <a href="book_page"></a>
        </td>

        <td style="width: 1.5%;"></td>

        <td>
          <div class="text">
            <p id="text" style="display:none">annen</p>
          </div>
        </td>
      </tr>

    </table>
  </div>
</div>


</body>

</html>