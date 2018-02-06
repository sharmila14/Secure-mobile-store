<?php
session_start();
require '../connect1.php';

if(!isset($_SESSION["loggedin"]["uname"])):
  header("Location: ../auth/authlogin.php");
endif;

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

    header("Location: ../auth/authlogin.php?status=error&msg=Session has been expired after $durn seconds.");
  else:
    $_SESSION["loggedin"]["start"] = time();    /* to track if the user is not idle */
    //echo "<h2>Welcome to Posts Page: ".$_SESSION["loggedin"]["name"]."</h2>";
  endif;
else:
  header("Location: ../auth/authlogin.php?status=error&msg=No session found. Please login");
endif;

?>

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> E-Mobile Store</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="./upcomingevents.css">
  <link rel="stylesheet" href="./image.css">
  <script type="text/javascript">
  function hideText() {
    document.getElementById('prefloc').style.visibility = 'hidden';
  }
  </script>
</head>

<body>

  <div class="banner">
    <div id="applogo">
      <a href="../index.php"><img class="img-responsive" src="../images/slider/logo.png" /></a>
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
    <div id="navbar">
			<?php if (!isset($_SESSION["loggedin"]["uname"])): ?>
      	<a href="./index.php"> Home</a>
      
      	<a href="#"> Contact</a>
      	<a href="../auth/authregister.php"> Register</a>
      	<a href="../auth/authlogin.php"> Login</a>
			<?php else: ?>
      
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
				<a href="../auth/authlogout.php">Sign Out</a>
		<?php endif; ?>
    </div>
  </div>

  <div class="main">
    <div id="inner">
      <h2> <?php echo ($_SESSION["loggedin"]["fname"]); ?></h2> <br/ >
        <div id="content3">
<div id="container">

<div class="main2">	
<div id="inner2">
 <table cellspacing="10"  >
 

	<div class="w3-container">
	
	<tr >
		  
	<?php

	
  
	
	if(isset($_GET["manufacturer"])){
	$manufacturer=($_GET["manufacturer"]);
	}
	$category=($_GET["category"]);
	$itemnumber=($_GET["itemnumber"]);	
	$oldnumber=$itemnumber;
	
	if(isset($_GET["manufacturer"])){
    $query="select * from item where itemnumber >'".$itemnumber."'  and category= '".$category."'
	and manufacturer like '%".$manufacturer."%' ORDER BY itemnumber ";

	}
	else
	{
	$query="select * from item where itemnumber >'".$itemnumber."'  and category= '".$category."' ORDER BY itemnumber ";
	}
	
	 $prefloc = $pdoConn->prepare($query);
     $prefloc->execute();
	 

	 
	 
	if($prefloc->fetch(PDO::FETCH_ASSOC)==0){
		echo("NO RECORDS FOUND!!");
	}
	else
	{
    
	$numberofrows=$prefloc->rowCount();
	$counter=0;
	$cells=0;
	
	
	/*echo"<h2 align=center><u>".$numberofrows." records to check out!</u></h2>";*/

	while($row=$prefloc->fetch(PDO::FETCH_ASSOC)) {
	echo "<td align=center>";
	
	  
	   echo "<a href=details.php?itemnumber=".$row['itemnumber']." ><h5 align=center><u>".$row['manufacturer']." ".$row['model']. "</u> </h5></a>";	  	
		

if ($row['image']!=NULL)
	echo "<a href=details.php?itemnumber=".$row['itemnumber']." ><img align=center src=../images/".$row['image']. " class='w3-circle'  style='width:80px'></img></a><br>";	  
	  	if ($row['price']>0)	 
	  echo "<font color=red align=center >Price:<br></font><b> USD ". $row['price'] . "</b><br>";	  
	
		echo "</td>";
	$cells=$cells+1;
	if($cells==7)
	{
	echo "</tr><tr>";
	$cells=0;
	}
	
	
	  $counter=$counter+1;	 
	  if($counter==3)
	  break;
	  
	  }
	  
	  if($numberofrows>3)	  
 echo "</tr><tr><td colspan='3' align='center' ><a href=results.php?itemnumber=". $row['itemnumber']."&category=".$category."&manufacturer=".$row['manufacturer']." align=right>Next</a></td>";
	}

   	

?>
	

	</tr>
	</div>
	
	</table>
	</div>
	</div>


        
      <br /><br />

    </div>
  </div>


  <div class="footer">
    <div>
      <span> Powered by University of North Texas </span>
    </div>
  </div>

</body>
</html>
