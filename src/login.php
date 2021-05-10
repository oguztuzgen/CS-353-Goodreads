<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
		<?php require('template/style.php'); ?>

    <meta charset="utf-8">
    <title>Login</title>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!-- Compiled and minified JavaScript -->
  </head>
  <body>

    <div class="center1">
			<div class="text" style="float:left">
				<img src="../image/ordek.png" width="200" height="170" alt="">
			</div>
      <h1 style="text-align: left; margin-left: 40%;">DUCKREAD</h1>

			

    </div>

    <div>

        <table class="" cellspacing="20px">
            <tr>
                <td style="width:2%"></td>

                <td>
                  <div class="" style="" >
                      <table style="width:100%;">
                        <td><button class="button text" id = "log" style="width:100%; border-color:white; background-color:#7fa1bf;" onclick="openPanel('Login', 'log')">Login</button></td>
                        <td><button class="button text " id = "reg" style="width:100%; border-color: #7fa1bf; background-color:#7fa1bf;" onclick="openPanel('Register', 'reg')">Register</button></td>
                      </table>

                  </div>

                  <div id="Login" class="logs text" style="">
                    <h2 style="text-align: left; margin-left:29%;">Login</h2>

                    <form class="z-depth-0" action="index.html" method="post">
                      <p style="text-decoration:underline; text-align:left; margin-left:29%;">Email</p>
                      <input type="text" name="" value="" placeholder="E-mail" style="padding: 15px; width: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text">
                      <p style="text-decoration:underline; text-align:left; margin-left:29%;">Password</p>
                      <input type="text" name="" value="" placeholder="Password" style="padding: 15px; width: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text">
                      <br> <br>
                      <input type="button" name="" value="Login" style="padding: 15px; background-color:#7fa1bf;" class="text">
                    </form>
                  </div>

                  <div id="Register" class="logs text" style="display:none;">
                    <h2 style="text-align: left; margin-left:29%;">Register</h2>

                    <form class="" action="" method="post">
                      <p style="text-decoration:underline; text-align:left; margin-left:29%;">Email</p>
                      <input type="text" name="" value="" placeholder="E-mail" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text">
                      <p style="text-decoration:underline; text-align:left; margin-left:29%;">Password</p>
                      <input type="text" name="" value="" placeholder="Password" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text">
                      <p style="text-decoration:underline; text-align:left; margin-left:29%;">Name</p>
                      <input type="text" name="" value="" placeholder="Name" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text ">
                      <p style="text-decoration:underline; text-align:left; margin-left:29%;">Surname</p>
                      <input type="text" name="" value="" placeholder="Surname" style="padding: 15px; width: 40%; background-color:#7fa1bf;border-color: white;" class="z-depth-0 text">
                      <p style="text-decoration:underline; text-align:left; margin-left:29%;">Birth Day</p>

                      <div class="input-field" style="width:40.5%; margin-left:29%; ">
                        <input type="text" class="datepicker text" id="date" style="background-color:#7fa1bf; border-color: white; padding:12px;">
                      </div>
                      <br>
                      <input type="button" name="" value="Register" style="padding: 15px; background-color:#7fa1bf;" class="text">
                    </form>
                  </div>

                  <script>
                      function openPanel(Name, evt) {
                          var i;
                          var x = document.getElementsByClassName("logs text");
                          var logs = document.getElementsByClassName("button text");
                          for (i = 0; i < x.length; i++) {
                              x[i].style.display = "none";
                              logs[i].style.borderColor = "#7fa1bf";
                          }
                         document.getElementById(Name).style.display = "block";
                         document.getElementById(evt).style.borderColor = "white";
                      }


                  </script>

                </td>

                <td style="width:2%"></td>

            </tr>
        </table>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		
    <script>
      $(document).ready(function(){
        $('.datepicker').datepicker({


        });
      });
    </script>

  </body>
</html>
