<?php require 'connect1.php';
if(isset($_REQUEST["number"])){
	$nationalIdNo=$_REQUEST["number"];
		if($nationalIdNo==""||$nationalIdNo==NULL)
	        {
             echo "<script type='text/javascript'>
				document.location = 'administration.php';
				</script>";exit;
				}
			
	       else
	       {
	         
		   
		   $num=123456;
	       $strSQL = "SELECT * FROM administrators where nationalIdNo = $num ";	
	       $prefloc = $pdoConn->prepare($strSQL );
			$prefloc->execute();
		   echo "$nationalIdNo";
		   $numberofrows=$prefloc->rowCount();
	       if($numberofrows==0){
			   echo "number of rows 0";
	        echo "<script type='text/javascript'>
				document.location = 'administration.php';
				</script>";exit;
				}
			}
		}
		 else
	      {
		       echo "<script type='text/javascript'>
				document.location = 'administration.php';
				</script>";exit;
	          }			
	?>
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
   
    
			<?php else: ?>
   
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
	
		<?php endif; ?>

    </div>
		
 	
		
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
	<form  action="adminlogin.php"method="post">
	<p align="center"><font color="white" size="10">Administrator User Name:<br> <input type="text" size="30" name="username" /></p>
	<p align="center"><font color="white" size="10">Password:<br> <input type="password" size="30" name="password" /></p>
	<input type="hidden"  name="attempts" value="<?php echo $_REQUEST["attempts"]; ?>" />
	<input type="hidden"  name="number" value="<?php echo $_REQUEST["number"]; ?>" />
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
