<?php

session_start();

if ( isset($_SESSION["loggedin"]["uname"]) ): {
  header("Location: ../working_user/userhome.php");
}
endif;

 ?>


<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./authregister.css">
  <title>E-Mobile Store.</title>
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
      <a href="../index.php"><img class="img-responsive" src="../images/slider/logo.png" /></a>
    </div>
    <div id="navbar">
      <a href="../index.php"> Home</a>
      <a href="#"> About</a>
      <a href="../locationSearch.php"> Explore</a>
      <a href="../contact-us.html"> Contact</a>
      <!--<a href="#register" onclick='showRegDiv()'> Register</a>-->
      <!--<a href="#login" onclick='showLoginDiv()'> Login</a>-->
	  <a href="#"> Register</a>
      <a href="./authlogin.php"> Login</a>
    </div>
	  <script>

	</script>
    </div>
  </div>

  <div class="regdiv">
  <!-- All of our markup and php logic goes here! -->
  <?php
		require_once('../connect1.php');
		if (isset($_POST["submit"])){
			//echo "1";
			//echo $_POST['username'];
			//echo $_POST['sportpref1'];
			//echo $_POST['loc'];

      $sql = "INSERT INTO Users(AppUserName, AppUserPassword, UserFName, UserLName, UserPhoneNum,UserEmail) VALUES (:user, :pwd, :fname, :lname, :phno, :email)";

      $stmt = $pdoConn->prepare($sql);

      $stmt->bindParam(':user', $_POST['username']);
      $encrypted_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $stmt->bindParam(':pwd', $encrypted_password);
      $stmt->bindParam(':fname', $_POST['fname']);
      $stmt->bindParam(':lname', $_POST['lname']);
      $stmt->bindParam(':phno', $_POST['phno']);
     
      $stmt->bindParam(':email', $_POST['Email']);
      

		  if ($stmt->execute()) {
        //echo "Success";
        $message = "Successfuly registered your new user account";
		  }
      else {
        //echo "failure";
        $message = "Sorry! There must have been an issue creating your account";
		  }
		}

		/*if(isset($_POST["confirmsignup"])):
				$username=$_POST['username'];
				$password=$_POST['password'];
				$firstname=$_POST['fname'];
				$lastname=$_POST['lname'];
				$dofbirth=$_POST['dob'];
				$contact=$_POST['phno'];
				$ps1=$_POST['sportpref1'];
				$ps2=$_POST['sportpref2'];
				$ps3=$_POST['sportpref3'];
				$e=$_POST['Email'];
				$location=$_POST['loc'];

				$sql = "INSERT INTO Users (AppUserName, AppUserPassword, UserFName, UserLName, DateOfBirth, UserPhoneNum,PrefSport1, PrefSport2, PrefSport3,UserEmail,PreferredLoc) VALUES (:user, :pwd, :fname, :lname, :dob, :phno, :prefsp1, :prefsp2, :prefsp3, :email, :loc)";

				$stmt = $pdoConn->prepare($sql);
				$res = $stmt->execute(['user' => $username, 'pwd' => $password, 'fname' => $firstname,'ltname' => $lastname, 'dob' => $dofbirth, 'phno' => $contact,'prefsp1' => $ps1, 'prefsp2' => $ps2, 'prefsp3' => $ps3,'email' => $dofbirth, 'loc' => $location]);

		  if ($res):
			echo "Successfully registered your new user account";
		  else:
			echo "Sorry! There must have been an issue creating your account";
		  endif;
		endif;*/
	?>

  <div class="regcontainer" id="register" >
      <form class="form-horizontal" method="post" align="right" action="">
        <fieldset>
            <!-- Sign Up Form -->
			<div >
              <p>Join us today!  </p>
            </div>
            <br />
			<div class="sub-entry">
            <!-- Text input-->
            <div class="control-group"></br>
              <label for="username">UserName:
                <input id="username" name="username" type="text" placeholder="Username" required="" onblur="checkAvailability();">
                <span id="valuser" class=""></span>
			        </label>

              <script>
              function checkAvailability() {
      					jQuery.ajax({
      					url: "check-availability-ajax.php",
      					data:'username='+$("#username").val(),
      					type: "POST",
      					success:function(res){
							/*if(res===true)
							{
								document.getElementById("valuser").innerHTML =$("#username").val()+" is not available";
								//document.getElementById("valuser").addclass('success');
							}else{
								document.getElementById("valuser").innerHTML =$("#username").val()+" is available";
								//document.getElementById("valuser").addclass('errorText');
							}*/
      						setTimeout(function() {document.getElementById("valuser").innerHTML =$("#username").val()+res;}, 300);
      					},
      					error:function (){document.getElementById("valuser").innerHTML ="error";}
      					});
      					//get the username
      					  /*  var username = $('#username').val();

      						//use ajax to run the check
      						$.post("check-availability-ajax.php", { username: username },
      							function(result){
      								//if the result is 1
      								if(result == 1){
      									//show that the username is available
      									document.getElementById("valuser").innerHTML = username + ' is Available';
      								}else{
      									//show that the username is NOT available
      									document.getElementById("valuser").innerHTML =username + ' is not Available';
      								}
      						}); */
      				}
              </script>
            </div>

            <!-- Text input-->
            <div class="control-group"></br>
              <label class="control-label" for="Email">Email:
                <input id="Email" name="Email" type="text" placeholder="CrazyPlayer@gmail.com" required="" >
                <span id="valemail" class="errorText"></span>
              </label>
            </div>
		</p>


            

            

			
		
		<div class="sub-entry">
		   <!-- Text input-->
            <div class="control-group"></br>
              <label class="control-label" for="phno">Phone Number:
                <input id="phno" name="phno" type="text" min="10" max="10" placeholder="123-456-7878" required="">
				        <span id="valdigit" class="errorText"></span>
			        </label>
			      </div>

            <!-- Text input-->
            <div class="control-group"></br>
              <label for="fname">First Name:
                <input id="fname" name="fname" class="form-control" type="text" placeholder="FirstName"  required="">
              </label>
            </div>

            <!-- Text input-->
            <div class="control-group"></br>
              <label for="lname">Last Name:
                <input id="lname" name="lname" class="form-control" type="text" placeholder="LastName" required="">
              </label>
            </div>

            <!-- Password input-->
            <div class="control-group"></br>
              <label for="password">Password:
                <input id="password" name="password" class="form-control" type="password" placeholder="********"  required=""></br>
                <em>1-8 Characters</em>
              </label>
            </div>

            <!-- Text input-->
            <!--<div class="control-group"></br>
              <label class="control-label" for="reenterpassword">Re-Enter Password:
                <input id="reenterpassword" class="form-control" name="reenterpassword" type="password" placeholder="********" required="" onblur="verifyPassword();">
                <span id="password-mismatch"></span>
              </label>
            </div>
            <script>
      				function verifyPassword(){
      					if(isset($_POST["reenterpassword"]) && isset($_POST["password"])){
      						if($reenterpassword!=$password)
      							document.getElementById("password-mismatch").innerHTML ="Passwords doesnot match!";
      					}

      				}
      			</script>-->

            <!-- Text input-->

		</div>

            <!-- Button -->
            <div id="regdiv" class="control-group" align="center"></br></br>
              <!--<label class="control-label" for="confirmsignup"></label>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
              <input id="confirmsignup" name="submit" type="submit"></input>
            </div>
          </fieldset>
        </form>

        <div id="wrapper">
        <?php if (isset($_GET['status'])):
          $id = $_GET['status'];
          $message = $_GET['msg'];
          echo "<div id='$id'>$message</div>";
        endif; ?>
      </div>

      </div>    <!-- #register div container ends -->

  </div>


    <div class="footer">
      <div>
        <span> Powered by University of North Texas </span>
      </div>
    </div>
</body>
</html>
