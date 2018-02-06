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
  <link rel="stylesheet" href="./shr_testlogin.css">
  <title>Login to Go!Play.</title>
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
      <a href="../index.php"><img class="img-responsive" src="../images/Logo_216x80.png" /></a>
    </div>
    <div id="navbar">
      <a href="../index.php"> Home</a>
      <a href="#"> About</a>
      <a href="../locationSearch.php"> Explore</a>
      <a href="#"> Contact</a>
      <!--<a href="#register" onclick='showRegDiv()'> Register</a>-->
      <!--<a href="#login" onclick='showLoginDiv()'> Login</a>-->
	  <a href="#registration"> Register</a>
      <a href="#login"> Login</a>
    </div>
	  <script>

	</script>
    </div>
  </div>

  <div class="main">
  <!-- All of our markup and php logic goes here! -->
  <?php
		require_once('../connect.php');
		if (isset($_POST["submit"])){
			//echo "1";
			//echo $_POST['username'];
			//echo $_POST['sportpref1'];
			//echo $_POST['loc'];

      $sql = "INSERT INTO Users(AppUserName, AppUserPassword, UserFName, UserLName, DateOfBirth, UserPhoneNum,PrefSport1, PrefSport2, PrefSport3,UserEmail,PreferredLoc) VALUES (:user, :pwd, :fname, :lname, :birthdate, :phno, :prefsp1, :prefsp2, :prefsp3, :email,:loca)";

      $stmt = $pdoConn->prepare($sql);

      $stmt->bindParam(':user', $_POST['username']);
      $encrypted_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $stmt->bindParam(':pwd', $encrypted_password);
      $stmt->bindParam(':fname', $_POST['fname']);
      $stmt->bindParam(':lname', $_POST['lname']);
      $timestamp = strtotime($_POST['dob']);
      $date=date("Y-m-d", $timestamp);
      $stmt->bindParam(':birthdate', $date);
      $stmt->bindParam(':phno', $_POST['phno']);
      $stmt->bindParam(':prefsp1', $_POST['sportpref1']);
      $stmt->bindParam(':prefsp2', $_POST['sportpref2']);
      $stmt->bindParam(':prefsp3', $_POST['sportpref3']);
      $stmt->bindParam(':email', $_POST['Email']);
      $stmt->bindParam(':loca', $_POST['loc']);

		  if ($stmt->execute()) {
        echo "Success";
        $message = "Successfuly registered your new user account";
		  }
      else {
        echo "failure";
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

  <div class="container" id="register" >
      <form class="form-horizontal" method="post" align="right" action="">
        <fieldset>
            <!-- Sign Up Form -->
			<div >
              <p>Join us today!  </p>
            </div>
            <br />
            <!-- Text input-->
            <div class="control-group"></br>
              <label for="username">UserName:
                <input id="username" name="username" type="text" placeholder="Username" required="" onblur="checkAvailability();">
                <span id="valuser" class="errorText"></span>
			        </label>

              <script>
              function checkAvailability() {
      					jQuery.ajax({
      					url: "check-availability-ajax.php",
      					data:'username='+$("#username").val(),
      					type: "POST",
      					success:function(data){
      						setTimeout(function() {document.getElementById("valuser").innerHTML =$("#username").val()+data;}, 5);
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
                <input id="Email" name="Email" type="text" placeholder="CrazyPlayer@gmail.com" required="" onblur="validateEmailId();">
                <span id="valemail" class="errorText"></span>
              </label>
            </div>
			      <script>
            function validateEmailId()
            {	/*
              if(isset($_POST["Email"]))
              {
                var email=$("#Email").val();
                var EMAIL_REGEX = "/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm";

                if(EMAIL_REGEX.test(email){
                  document.getElementById("valemail").innerHTML="correct";
                }else{
                  document.getElementById("valemail").innerHTML="incorrect";
                }
              }*/
              $email = $_POST["Email"];
              document.getElementById("valemail").innerHTML="inside function!";
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                document.getElementById("valemail").innerHTML="Invalid email format!";
              }else{
                document.getElementById("valemail").innerHTML="Valid email format!";
              }

            }
  				  </script>

            <!-- Text input-->
            <div class="control-group"></br>
              <label class="control-label" for="dob">DOB:
                <input id="dob" name="dob"  type="text" placeholder="YYYY-MM-DD" required="">
              </label>
            </div>

			      <!-- Text input-->
            <div class="control-group"></br>
              <label class="control-label" for="phno">Phone Number:
                <input id="phno" name="phno" type="text" min="10" max="10" placeholder="123-456-7878" required="" onblur="checkDigits();">
				        <span id="valdigit" class="errorText"></span>
			        </label>
			      </div>


            <!-- Text input-->
            <div class="control-group"></br>
              <label class="control-label" for="sportpref1">Sport Preference 1:
                <select name="sportpref1" id="sportpref1" onchange="changeList()" required="">
                  <option value="">Select your 1st preference</option>
                  <?php
          				// Run the query to fetch records from sports table
          				$sport_list_query="SELECT SportName,SportId FROM sports";
          				$response=$pdoConn->prepare($sport_list_query);
          				$response->execute();

          				// Loop through the query results, outputing the options one by one
          				foreach ($response->fetchAll() as $sports) {
          					echo '<option value="'.$sports['SportName']. '">'. $sports['SportName'].'</option>';

          				}
          			  ?>
                </select>
              </label>
            </div>

            <script>
            function changeList() {
              var i;
    					for(i=sportpref1.options.length-1;i>=0;i--)
    					{
    					if(sportpref1.options[i].selected){
    						sportpref2.remove(i);
    					sportpref3.remove(i);}
    					}
    				}
    			  </script>

            <!-- Text input-->
            <div class="control-group"></br>
              <label class="control-label" for="sportpref2">Sport Preference 2:
                <select name="sportpref2" id="sportpref2" onchange="changeList2()" required="">
                  <option value="">Select your 2nd preference</option>
                  <?php

          				// Run the query to fetch records from sports table
          				$sport_list_query="SELECT SportName,SportId FROM sports";
          				$response=$pdoConn->prepare($sport_list_query);
          				$response->execute();
          				// Loop through the query results, outputing the options one by one
          				foreach ($response->fetchAll() as $sports) {

          					echo '<option value="'.$sports['SportName']. '">'. $sports['SportName'].'</option>';

          				}


          				//echo '<option value="Denton">'.$row2.'</option>';
          				//echo '<option value="Arlington">'.$row3.'</option>';
          				//$val1=$_POST["sportpref2"];
          			  ?>
                </select>
              </label>
            </div>

            <script>
      				function changeList2(){

      					var i;
      					for(i=sportpref2.options.length-1;i>=0;i--)
      					{
      					if(sportpref2.options[i].selected){
      						sportpref3.remove(i);}
      					}
      				}
      			</script>

            <!-- Text input-->
            <div class="control-group"></br>
              <label class="control-label" for="sportpref3">Sport Preference 3:
                <select name="sportpref3" id="sportpref3" required="">
                  <option value="">Select your 3rd preference</option>
                  <?php
          				// Run the query to fetch records from sports table
          				$sport_list_query="SELECT SportName,SportId FROM sports";
          				$response=$pdoConn->prepare($sport_list_query);
          				$response->execute();

          				// Loop through the query results, outputing the options one by one
          				foreach ($response->fetchAll() as $sports) {
          						echo '<option value="'.$sports['SportName']. '">'. $sports['SportName'].'</option>';

          				}
          			  ?>
                </select>
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
            <div class="control-group"></br>
              <label class="control-label" for="loc">Sport Location:</label>
              <select name="loc" id="loc" required="">
                <option value="">Select your location</option>
                <?php
        				// Run the query to fetch records from location table
        				$loc_query="SELECT LocationName,LocationId FROM locations";
        				$response=$pdoConn->prepare($loc_query);
        				$response->execute();

        				// Loop through the query results, outputing the options one by one
        				foreach ($response->fetchAll() as $loc) {
        						echo '<option value="'.$loc['LocationName']. '">'. $loc['LocationName'].'</option>';

        				}
        			  ?>
              </select>
            </div>

            <!-- Button -->
            <div class="control-group"></br></br>
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


      <!-- login Page -->
      <!--<div class="container" id="login" style="display:none">-->
      <div class="container" id="login" style="display:none">
        <form class="form-horizontal" method="post" align="right" action="./shr_testauth.php" >
          <fieldset>
            <!-- Login Form -->
            <div >
              <h3>HELLO!</h3>
              <p>Enter the sports community that brings together with up-to-date scores and highlights, exclusively for web platforms.  </p>
            </div>
            <br />
            <p> Login </p>
            <!-- Text input-->
            <div class="control-group"></br>
              <!--<label for="username">UserName:</label>-->
              <!--<input id="username" name="username" type="text" placeholder="Username" required="" >-->
              <input id="username" name="username" type="text" placeholder="Username" autofocus>
            </div>

            <!-- Password input-->
            <div class="control-group"></br>
              <!--<label for="password">Password:</label>-->
              <!--<input id="password" name="password" type="password" placeholder="********" required="">-->
              <input id="password" name="password" type="password" placeholder="Password">
            </div>
            <?php if (!empty($_POST['eid']) && !empty($_POST['loc'])): ?>
                  <input type="hidden" name="eid" value="<?= $_POST['eid']; ?>" />
                  <input type="hidden" name="loc" value="<?= $_POST['loc']; ?>" />
            <?php endif; ?>

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

            <br /><br /><br /><p class="lbl"> Don't have an account yet? </p>
            <!-- Button -->
            <div id="lastdiv" class="control-group"><br />
              <!--<label for="regflogin">
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
               <button id="regflogin" name="regflogin" class="register">Register</button>
             </label>
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
