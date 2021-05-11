<?php

    //connection to database
    $conn = mysqli_connect('localhost', 'oguz', 'BilkentBois', 'duckread');

    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>