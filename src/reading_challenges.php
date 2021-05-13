<?php
require('template/header.php');
require('template/config.php');


?>

<br><br><br><br><br>


<div class="center1 text">
    <h4> All Reading Challenges</h4>

    <table>
        <tr>
            <th class="center   ">Subject</th>
            <th class="center   ">Book Amount</th>
            <th class="center   ">Start Date</th>
            <th class="center   ">End Date</th>
            <th></th>
        </tr>

        <?php
        $sql = "select *
            from reading_challenge;";

        $result = mysqli_query($conn, $sql);

        while ($reading_challenges = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            echo '<tr>';

            echo '<td >';
            echo $reading_challenges['subject'];
            echo '</td>';

            echo '<td >';
            echo $reading_challenges['amount'];
            echo '</td>';
            $_SESSION['bookAmount'] = $reading_challenges['amount'];

            echo '<td >';
            echo $reading_challenges['start_date'];
            echo '</td>';

            echo '<td >';
            echo $reading_challenges['end_date'];
            echo '</td>';

            echo '<td >';
            echo '<a style="text-decoration:underline; color:blue;" href="challenge.php?challenge_id=' 
							. $reading_challenges['rc_id'] . '">Go to challenge page</a>';

            echo '</td>';

            echo '</tr>';
        }


        ?>
    </table>

</div>





</body>

</html>