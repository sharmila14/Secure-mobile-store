<?php include 'connect.php';
if(isset($_GET["e"])){
$username=$_GET["e"];
$email=$_GET["e"];
if($username!=""||$username!=NULL){
    $Login="NO";
	mysql_connect("$host", "$user", "$pass") or die (mysql_error());	
	mysql_select_db("$db") or die(mysql_error());
	mysql_query("UPDATE administrators SET logged='".$Login."' WHERE username='".$username."'");
		}
		}
		 else
      $email=""; ?>	

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> E-Mobile Store</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="working_user/upcomingevents.css">
  <script type="text/javascript">
  function hideText() {
    document.getElementById('prefloc').style.visibility = 'hidden';
  }
  </script>
</head>

<body>
  <div class="banner">
    <div id="applogo">
      <a href="../index.php"><img class="img-responsive" src="images/slider/logo.png" /></a>
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
    <div id="navbar">
			<?php if (!isset($_SESSION["loggedin"]["uname"])): ?>
      	<a href="./index.php"> Home</a>
   
    
      	<a href="auth/authregister.php"> Register</a>
      	<a href="auth/authlogin.php"> Login</a>
			<?php else: ?>
   
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
	
		<?php endif; ?>
    </div>
  </div>


<body>
	<div id="header">
	<div id="headerinside">	

		
	</div>
	<div id="topmenu">
	

		
	
	</div>
<div id="search" align="center">  
           <div align="center" style="float:left;  width:450px; margin:auto;">  </div>
		  
		 <div align="center" style=" width:450px; float:left">		
	</div>
			
</div>

	</div>  

<div id="container">




<div id="inner_contentColumn" class="middlecolumn" align="center" >

	<div id=log1 style="margin-top:20px; margin-bottom:20px;"><br>	
	<form  action="admin.php"method="post">
	
	<p align="center" ><font color="white" size="15">Enter Your Identification Number<br> <input type="text" size="30" name="number" /><input type="hidden"  name="attempts" value="0" /></font></p>
	<input type="hidden"  name="e" value="" />	
	<p align="center"><input type="submit" value="Log Me In" /></p>
	</form>
			
	</div>
	</div>		



	



<div id="footer">
  <div class="footer">
    <div>
      <span> Powered by University of North Texas </span>
    </div>



</div>
</div>
</body>
</html>
