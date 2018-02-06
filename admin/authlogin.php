<?php
session_start();//session starts here

?>


<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./authlogin.css">
  <title>Login to E-Mobile Store.</title>
  <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/smoothness/jquery-ui.css" media="all">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
  <script>
  function checkDigits() {
    var inpObj = document.getElementById("phno");
    if (inpObj.checkValidity() == false) {
        document.getElementById("valdigit").innerHTML = inpObj.validationMessage;
    } else {
        document.getElementById("valdigit").innerHTML = "Input OK";
    }
  }

  $(function() {
    $( "#dob" ).datepicker();
  });

  function showRegDiv() {
    if (document.getElementById('register').style.display == 'block') {
      document.getElementById('register').style.display = 'none';
    } else {
      document.getElementById('register').style.display = 'block';
      document.getElementById('login').style.display = 'none';
    }
  }

  /*function showLoginDiv() {
		if (document.getElementById('login').style.display == 'block') {
			document.getElementById('login').style.display = 'none';
		} else {
			document.getElementById('login').style.display = 'block';
			document.getElementById('register').style.display = 'none';
		}
	}*/
  </script>
</head>

<body>
  <div class="banner">
    <div id="applogo">
  
    </div>
    <div id="navbar">
   <a href="../index.php"> Home</a>
      <a href="./authregister.php"> Register</a>
      <a href="./authlogin.php"> Login</a>
    </div>
	  <script>

	</script>
    </div>
  </div>

  <div class="main">
  <!-- All of our markup and php logic goes here! -->



      <!-- login Page -->
      <!--<div class="container" id="login" style="display:none">-->
      <div class="container" id="login">
        <form role="form" method="post" action="authlogin.php">
          <fieldset>
            <!-- Login Form -->
        
             
            <br />
            <p> Login </p>
            <!-- Text input-->
            <div class="control-group"></br>
              <!--<label for="username">UserName:</label>-->
              <!--<input id="username" name="username" type="text" placeholder="Username" required="" >-->
              <input id="email" placeholder="E-mail" name="email" type="text" autofocus>
            </div>

            <!-- Password input-->
            <div class="control-group"></br>
              <!--<label for="password">Password:</label>-->
              <!--<input id="password" name="password" type="password" placeholder="********" required="">-->
              <input id="password" placeholder="Password" name="pass" type="password" value=""">
            </div>
            

            <!-- Button -->
            <div id="btndiv" class="control-group"></br>
              <!--<label for="login">-->
               <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
               <button id="login" name="login" class="login" type="submit">Login</button>
             </label>
            </div>

            <div id="wrapper">
              <br />
              <?php if (isset($_GET['status'])):
                $id = $_GET['status'];
                $message = $_GET['msg'];
                echo "<div id='$id'>$message</div>";
              endif; ?>
            </div>

           
          </fieldset>
        </form>



		</div>    <!-- #login div container ends -->

  </div>


    <div class="footer">
      <div>
        <span> Powered by University of North Texas </span>
      </div>
    </div>
</body>
</html>
<?php

include("../connect1.php");

if(isset($_POST['login']))
{
    $user_email=$_POST['email'];
    $user_pass=$_POST['pass'];

    $check_user="select * from users1 WHERE user_email='$user_email'AND user_pass='$user_pass'";

    $prefloc = $pdoConn->prepare($check_user);
    $prefloc->execute();
    $numberofrows=$prefloc->rowCount();
    if( $numberofrows!=0)
    {
        echo "<script>window.open('welcome.php','_self')</script>";

        $_SESSION['email']=$user_email;//here session is used and value of $user_email store in $_SESSION.

    }
    else
    {
        echo "<script>alert('Email or password is incorrect!')</script>";
    }
}
?>
authlogin.php
Sign In
Displaying authlogin.php. 