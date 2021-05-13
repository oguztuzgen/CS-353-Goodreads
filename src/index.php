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

  $_GET['book_id'] = $_GET['xd'];
  echo $_SESSION['xd'];
  $b_id = $_GET['book_id'];
  header("Location: book_page.php?book_id=$b_id");
}

?>

<br><br><br><br><br>

<div>
  <form class="" action="" method="POST" name="thisForm">
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

              <?php
              $sql = "SELECT * FROM genre;";

              $result = mysqli_query($conn, $sql);
              $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);


              echo "<select multiple name=\"genre_names[]\">";
              echo "<option value=\"\" disabled selected>Choose your option</option>";
              foreach ($genres as $index => $pair) {
                $genre_id = $pair["genre_id"];
                $genre_name = $pair["genre_name"];

                echo "<option value=\"$genre_id\">$genre_name</option>";

                // <p class=''>
                //   <label >
                //     <option value='$genre_id'>$genre_name</option> name='genr' value='$genre_id' onclick='checked($genre_id)'/>
                //     <span style='color:black; font-size:16px;' >$genre_name</span>
                //   </label>
                // </p>";
              }

              echo "</select>";

              ?>

              <!-- </form> -->

              <script>

              </script>

              <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

              <script>
                $(document).ready(function() {
                  $('select').formSelect();
                });
              </script>
            </div>
          </td>

          <td style="width: 1.5%;"></td>

          <td style="width: 40%; background-color: #80A1C0; ">
            <div style="overflow-y: scroll; height: 700px;">



              <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST" ||  $flag == 0) {
                //echo $_POST['search_bar'];
                $flag = 1;
                global $search;
                error_reporting(0); // delete this in case of a problem

                $search = $_POST['search_bar'];
                //$genrebar = $_POST['genr'];

                echo "
                  <table class='highlight'>
                  <tr>
                    <th class=\"center\">Cover</th>
                    <th class=\"center\">Title</th>
                    <th class=\"center\">Author</th>
                  </tr>
                ";



                $query = "
									select *
									from book b
									where true";

                foreach ($_POST['genre_names'] as $gnr) {
                  $query = $query . " and " . "EXISTS( 
										select DISTINCT hg.book_id, hg.genre_id
										from has_genre hg
										where hg.genre_id = $gnr and hg.book_id = b.book_id)";
                }
								
                $res = mysqli_query($conn, $query);

                while ($books = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

                  $title = strtolower($books['title']);
                  $author = strtolower($books['author']);
                  $search = strtolower($search);

                  if (strpos($title, $search) !== false || strpos($author, $search) !== false) {

                    // echo "<div class='row text'>";
                    echo "<tr>";
                    echo "<td>";

                    // echo "<div class='col s4' style=''>";

                    $cover = $books['book_cover'];

                    $tmp = $books['title'];
                    echo '<form action="index.php" method="GET">
                                  <div class="container">
                                      <input type = "image" name="ordek"
                                      src="' . $cover . '" style="width: 100px; height: 135px;" alt="Image" formmethod="get">

                                  </div>';
                    echo "</td>";
                    // echo "</div>";



                    // echo "<div class='col s4' style='margin-top: 75px;'> 
                    echo "<td style='margin-top: 75px;'> 
                                <p class='text'>
                                  $tmp
                                </p>
                              </td>";

                    $tmp = $books['author'];
                    echo "<td style='margin-top: 75px'> 
                                <p>
                                  $tmp
                                </p>
                              </td>";

                    $tmp = $books['book_id'];

                    echo "<input type='hidden' name='xd' value='$tmp' style=''>";
                    echo '</form>';
                    echo "</tr>";
                  }
                }
              }
              ?>


            </div>
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

  </form>
</div>


</body>

</html>