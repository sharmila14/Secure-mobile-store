<?php
session_start();
require 'connect1.php';


?>

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <title> E-Mobile Store</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="./working_user/upcomingevents.css">
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
      	
      	<a href="contact-us.html"> Contact</a>
      	<a href="./auth/authregister.php"> Register</a>
      	<a href="./auth/authlogin.php"> Login</a>
			<?php else: ?>
      
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
				<a href="../auth/authlogout.php">Sign Out</a>
		<?php endif; ?>
    </div>
  </div>

  <div class="main">
    <div id="inner">
     
        <div id="content3">
<div id="container">


    
    
    

	<div style="clear:both"></div>	
	<div id="leftsidebar">	
	<div style="padding-right:10px;padding-left:10px">
			
	<div align="center" style="margin-top:10px" id="user4">
	
	
	 <div class="moduletable_menu" style="min-height:250px;" >
	<h3>Mobiles Selected</h3><br>
		<?php 
	

if(isset($_GET["itemnumber"])&& $_GET["itemnumber"]!=NULL){
	$itemnumber=$_GET["itemnumber"];
	 $query="select * from item where itemnumber=$itemnumber";
     $prefloc = $pdoConn->prepare($query);
     $prefloc->execute();
	 $numberofrows=$prefloc->rowCount();

	
	if($numberofrows==0){echo "NO RECORDS FOUND!";}	
	while($row= $prefloc->fetch(PDO::FETCH_ASSOC)) {
	   
	  echo "<h3 align=center><u>". $row['manufacturer'] ." ". $row['model'] . "</u> </h3>";	
	     	
	  echo "<font color=red align=center>Item Number:</font><b>". $row['itemnumber'] . "</b><br>";
	  
	  $hits=$row['hits']+1;
	  	

 
	  if ($row['image']!=NULL)	
	  
                                                                              //Resize image	  //-------------------------------------------------------------------------------------------------------------------------------		

$source_pic ="images/".$row['image'] ;

$destination_pic ="images/".$row['image'] ;
$max_width = 400;
$max_height = 400;

$src = imagecreatefromjpeg($source_pic);
 list($width,$height)=getimagesize($source_pic);

$x_ratio = $max_width / $width;
$y_ratio = $max_height / $height;

 if( ($width <= $max_width) && ($height <= $max_height) ){
     $tn_width = $width;
     $tn_height = $height;
     }elseif (($x_ratio * $height) < $max_height){
         $tn_height = ceil($x_ratio * $height);
         $tn_width = $max_width;
     }else{
         $tn_width = ceil($y_ratio * $width);
         $tn_height = $max_height;
 }

$tmp=imagecreatetruecolor($tn_width,$tn_height);
imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

imagedestroy($src);
imagedestroy($tmp);
//--------------------------------------------------------------------------------------------------------------------------------
	
	  	
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><img  src=images/" .$row['image'] ."  class='w3-circle'  style='width:80px'></img></a> <br><br>";
	
	  if ($row['description']!=NULL)
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><h3 align=center><u>Description</u> </h3></a>";		
	  echo "<pre ><i>". $row['description'] . "</i></pre><br><br><br>";	
	    if ($row['price']>0)
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><font color=red align=center><p>Selling Price:</p></font><b>USD " . $row['price'] . "</b></a><br><br>";
	  
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><font color=red align='right'>ADD TO CART</font></a><br>";	
	  	
	  }
}else{echo "Enter a  valid item number";}



?>
		</div>



	
				
  </div>	
	
				
	</div>		
	</div>	
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
