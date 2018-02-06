
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<title>E-MobileStore</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> E-Mobile Store</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="upcomingevents.css">
  <script type="text/javascript">
  function hideText() {
    document.getElementById('prefloc').style.visibility = 'hidden';
  }
  </script>




</head>


<body>
<div class="banner">
    <div id="applogo">
      <a href="./index.php"><img class="img-responsive" src="images/slider/logo.png" float="left"/></a>
     
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
    <div id="navbar">
			<?php if (!isset($_SESSION["loggedin"]["uname"])): ?>
      	<a href="./index.php"> Home</a>
   
    
			<?php else: ?>
   
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
	
		<?php endif; ?>

    </div>

	<div id="header">
	<div id="headerinside">	
		

		
	</div>
	<div id="topmenu">
	
	
	

	
	
	
	</div>


	</div>  

<div id="container">




<div id="inner_contentColumn" class="middlecolumn" align="center" >

	<div id="wrong">
	 
	  
	  
	  <?php
	include 'connect.php';
	mysql_connect("$host", "$user", "$pass") or die (mysql_error());	
	mysql_select_db("$db") or die(mysql_error());
	
	$username=$_POST["username"];
	$password=$_POST["password"];
		
	$strSQL = "SELECT * FROM administrators where username='$username'";	
	$rs = mysql_query($strSQL);
	if(mysql_num_rows($rs)!=0)
	{
		
	while($row = mysql_fetch_array($rs))
	 {
	 
	 if ($row['status']==1)
	 
	   {
	  
	   if($_POST["attempts"]<3)
	     {	
			
  		if(($password==$row['pass'])&& ($username==$row['username']))
				{
					// If correct, we set the session to YES
	 			   
				$Login="YES";    		
	 			mysql_query("UPDATE administrators SET logged='".$Login."' WHERE username='".$username."'");	 
	 			 $username = $_POST["username"];
				
				 				 
				 echo "<script type='text/javascript'>
				document.location = 'controlpanel.php?e=".$username."';
				</script>";

				// header("Location:controlpanel.php");
	 
				}//end if pass
					else {	 
					// If not correct, we set the session to NO				  
				   					  
	 			   		$attempts=$_POST["attempts"]+1;				
				   		$left=3-$attempts;				
				  		echo "<br><br>";
				 		echo "<p><b>  Your username and password combination is incorrect!!</b><br><br></p>";
				  		echo "<p><a href='admin.php?attempts=".$attempts."&&number=".$_POST["number"]."'>Try Loging In Once Again</a><br><b></p>";
				  		echo "<p>YOU HAVE ".$left." ATTEMPTS LEFT!!!<br><br></p>";
						}//end else incorrect 
	  		}//end if attempts
			  else{
			      mysql_query("UPDATE administrators
  			      SET status=2
			      WHERE username='$username'");
			      echo "<br><br><br>";
			      echo "<p>DUE TO TOO MANY LOG-IN ATTEMPTS,YOUR ACCOUNT IS NOW LOCKED.TO UNLOCK, CONTACT ANOTHER ADMINISTRATOR</p>"; 					
			     }//end else too many			
		}//end if status 
			else
			{
			echo "<br><br><br>";
			echo "<p>SORRY! YOUR ACCOUNT IS LOCKED. TO UNLOCK, CONTACT ANOTHER ADMINISTRATOR</p> ";
			}//end else locked	
		}//end while				
	}//end if username
	else
	{
	$attempts=$_POST["attempts"]+1;				
	$left=3-$attempts;
	echo "<br><br><br>";
	echo "<p>SORRY! THE USERNAME YOU ENTERED DOES NOT EXIST</p> ";
	$number=$_POST["number"];
	echo "<p><a href='admin.php?attempts=".$attempts."&&number=".$number."'>Try Loging In Once Again</a><br><b></p>";
	echo "<p>YOU HAVE ".$left." ATTEMPTS LEFT!!!<br><br></p>";
	 if($left==0)echo "<script type='text/javascript'>
				document.location = 'administration.php';
				</script>";//header("Location:administration.php");
	}//end else USERNAME
	// Close the database connection
	mysql_close();
	?>
	  
	   
	 	
	  
	      

	
	</div>
	</div>		



</div>
</body>
</html>
