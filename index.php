<?php
session_start();
require 'connect1.php';
if(isset($_SESSION["loggedin"]["uname"])):
  $query = "SELECT PreferredLoc FROM Users WHERE AppUserName = :user";
  $prefloc = $pdoConn->prepare($query);
  $prefloc->execute(array(':user' => $_SESSION["loggedin"]["uname"]));

  $queryRes = $prefloc->fetch(PDO::FETCH_ASSOC);
  #var_dump($queryRes);
endif;

if (isset($_SESSION["loggedin"])):
  $durn = $_SESSION["loggedin"]["duration"];
  $start = $_SESSION["loggedin"]["start"];

  if ((time() - $start) > $durn):
    unset($_SESSION["loggedin"]["duration"]);
    unset($_SESSION["loggedin"]["start"]);
    unset($_SESSION["loggedin"]["name"]);
    unset($_SESSION["loggedin"]);

    header("Location: ./auth/authlogin.php?status=error&msg=Session has been expired after $durn seconds.");
  else:
    $_SESSION["loggedin"]["start"] = time();    /* to track if the user is not idle */
    //echo "<h2>Welcome to Posts Page: ".$_SESSION["loggedin"]["name"]."</h2>";
  endif;
endif;

/* Session information check ends */


?>

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Fullscreen Background Image Slideshow with CSS3 - A Css-only fullscreen background image slideshow" />
        <meta name="keywords" content="css3, css-only, fullscreen, background, slideshow, images, content" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="./css/demo.css" />
        <link rel="stylesheet" type="text/css" href="./css/style4.css" />
		<script type="text/javascript" src="./js/modernizr.custom.86080.js"></script>
 
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <title>E-Mobile Store.</title>
  <link rel="stylesheet" href="./index.css">
  <script type="text/javascript">
  function hideText() {
    document.getElementById('prefloc').style.visibility = 'hidden';
  }
  </script>
</head>
<body id="page">
<ul class="cb-slideshow">
            <li><span>Image 01</span><div><h3></h3></div></li>
            <li><span>Image 02</span><div><h3></h3></div></li>
            <li><span>Image 03</span><div><h3></h3></div></li>
            <li><span>Image 04</span><div><h3></h3></div></li>
            <li><span>Image 05</span><div><h3></h3></div></li>
            <li><span>Image 06</span><div><h3></h3></div></li>
        </ul>

  <div class="banner">
    <div id="navbar">
    <?php if(!isset($_SESSION["loggedin"]["uname"])): ?>
	  
      <a href="contact-us.html">Contact</a>
      <!--<a href="./auth/authregister.php"> Register</a>-->
      <a href="./auth/authregister.php">Register</a>
      <a href="./auth/authlogin.php"> Login</a>
  <?php else: ?>
  
    <a href="./working_user/userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
    <a href="./auth/authlogout.php">Sign Out</a>
  <?php endif; ?>
    </div>
  </div>

  <div class="main2">
    <div id="inner2">
     
	 
	  <table cellspacing="20">
	  <div class="w3-container">
	
	<tr >
	  <?php

	
   
	
	$counter=0;
	$cells=0;
	
	
	
	if(isset($_COOKIE['viewed']))
	{
	$category=$_COOKIE['viewed'];

$query="select * from item where category ='".$category."' ORDER BY  price DESC" ;
	}
	else	
    {
		$query="select * from item  ORDER BY  price DESC" ;
    }
	
     $prefloc = $pdoConn->prepare($query);
     $prefloc->execute();

	
	
	
	
	while($row= $prefloc->fetch(PDO::FETCH_ASSOC))
	{
	
	echo "<td align=center>";
	
	  
	   echo "<a href=details1.php?itemnumber=".$row['itemnumber']." ><h5 align=center><u>".$row['model']. "</u> </h5></a>";	  	
		

if ($row['image']!=NULL)
	
	echo "<a href=details1.php?itemnumber=".$row['itemnumber']." ><img align=center src=images/".$row['image']. " class='w3-circle'  style='width:120px'></img></a><br>";	  
	  	if ($row['price']>0)	 
	  echo "<font color=red align=center >Price:<br></font><b> USD ". $row['price'] . "</b><br>";	  
	
		echo "</td>";
	$cells=$cells+1;
	if($cells==5)
	{
	echo "</tr><tr>";
	$cells=0;
	}
	
	
	  $counter=$counter+1;	 
	  if($counter==5)
	  break;
	  
	  }



?>
	 </tr>
	 </div>
</table>	 
	  
	  
    </div>
  </div>

  <div class="pagination">

  </div>

  <div class="footer">
    <div>
      <span> Powered by University of North Texas </span>
	  <A HREF="./admin/authlogin.php">Admin Login</A>
    </div>
  </div>

</body>
</html>
