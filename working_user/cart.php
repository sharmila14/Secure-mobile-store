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
  <title> E-Mobile Store - CheckOut</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="./upcomingevents.css">
  <script type="text/javascript">
  function hideText() {
    document.getElementById('prefloc').style.visibility = 'hidden';
  }
  </script>
</head>

<body>
 <h2><?php echo ($_SESSION["loggedin"]["fname"]); ?></h2>
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
     
        <div id="content3">
<div id="container">


    
    
    

	<div style="clear:both"></div>	
	<div id="leftsidebar">	
	<div style="padding-right:10px;padding-left:10px">
			
	<div align="center" style="margin-top:10px" id="user4">
	
	
	 <div class="moduletable_menu" style="min-height:250px;" >
	<h3>CHECKOUT</h3><br>
	<form action="cart.php" method="post">
	<table align="center" border="1"  cellspacing="0" width="550">
	<tr  ><td align="center" colspan="6"><h3><font color="#FF0000">SHOPPING CART</font></h3>
	</td></tr>
	<tr bgcolor="#F7706C" ><td align="center">ITEM NUMBER</td><td align="center">MANUFACTURER</td><td align="center">MODEL</td><td align="">QUANTITY</td><td align="center">UNIT PRICE</td><td align="center">SUB TOTAL</td></tr><tr>
			<?php 
	
           
	$total=0;

	if(isset($_REQUEST["delete"]))
	{	
		$cartname=$_SESSION["loggedin"]["fname"];
		$item=$_POST['delete'];
	 echo "inside delete";
	 $delete_product= "delete from $cartname where itemnumber='".$item."'";
	 
	 $preflocdelete = $pdoConn->prepare($delete_product );
     
	
	$resultset_delete= $preflocdelete->execute();
	

	
	
	$query="select * from $cartname";	
	 $prefloc7 = $pdoConn->prepare($query);
    $prefloc7->execute();
	while($row = $prefloc7->fetch(PDO::FETCH_ASSOC))
		echo "inside cartname $cartname"; 
	  $query5="SELECT * FROM item INNER JOIN $cartname ON item.itemnumber = $cartname.itemnumber ";	
      $prefloc8 = $pdoConn->prepare($query5);
		$prefloc8->execute();	  
	  
	  
	while($row1 = $prefloc8->fetch(PDO::FETCH_ASSOC))
	 {	     	
	
	
	  echo "<td align='center'>". $row1['itemnumber'] . "</td>";	
	  echo "<td align='center'>". $row1['manufacturer'] . "</td>";
	  echo "<td align='center' >". $row1['model'] . "</td>";
	  $quantity=$row1['itemnumber'];
	 if(isset($_REQUEST["update"]))
	  {
	  $q=$_REQUEST[$quantity];}	else{$q=1;}	
	  echo "<td align='center'><INPUT TYPE='text'size='6' value='".$q."' NAME='". $quantity ."'/>	  
           <input type='hidden' NAME='p". $row1['itemnumber'] ."' value ='". $row1['price'] . "' />";
		  
	  echo "<td align='center'><font color=red align=center>". $row1['price'] . "</font></td>";	
	  $subtotal= $q*$row1['price'] ; 
	  echo "<td align='center'>USD: ".$subtotal."</td>";
		echo "<td><INPUT NAME='delete' TYPE='submit' VALUE='". $row1['itemnumber'] . "'/></td></tr><tr>";	  
	  $total=$total+$subtotal;
	  
	  
	 
	 
	 }   
	
	
	
	
	
	
	
	
	}
	
	else
		
		{
	
	
		if(isset($_REQUEST["update"]))
 {
 $itemnumber=NULL;
 }else{
   
	$itemnumber=$_GET["itemnumber"];
	}
	$cartname=$_SESSION["loggedin"]["fname"];
	$checkcart = "select 1 from $cartname";
	$prefloc16 = $pdoConn->prepare($checkcart);
    $prefloc16->execute();
	
	
	
	if ($prefloc16->fetch(PDO::FETCH_ASSOC) == true)
	{
	$cartname=$_SESSION["loggedin"]["fname"];
	
	
	
	$find = "SELECT * FROM $cartname where itemnumber='".$itemnumber."'";
	
	$prefloc = $pdoConn->prepare($find );
     
	
	$rows= $prefloc->execute();
	
	$numberofrows=$prefloc->rowCount();
	
    if($numberofrows!=0)
		{
		$itemnumber=NULL;
		}		
	
	$find2="INSERT INTO $cartname( `itemnumber`)
              VALUES('$itemnumber')";
			  
    $prefloc2 = $pdoConn->prepare($find2 );
     
	
	$rows2= $prefloc2->execute();
			   
	$query="select * from $cartname ";	
	$prefloc3 = $pdoConn->prepare($query);
    $prefloc3->execute();
	
	while($row = $prefloc3->fetch(PDO::FETCH_ASSOC))
	 {	     	
	 $query2="SELECT * FROM item   where itemnumber=".$row['itemnumber']."";	
	 $prefloc4 = $pdoConn->prepare($query2);
    $prefloc4->execute();
	 
	while($row1 = $prefloc4->fetch(PDO::FETCH_ASSOC))
	 {	     	
	  echo "<td align='center'>". $row1['itemnumber'] . "</td>";	
	  echo "<td align='center'>". $row1['manufacturer'] . "</td>";
	  echo "<td align='center' >". $row1['model'] . "</td>";
	  $quantity=$row1['itemnumber'];
	  if(isset($_REQUEST["update"]))
	  {
	  $q=$_REQUEST[$quantity];
	}else
	{$q=1;}	
		$total_items = $row1['total'];
	  	if($q < $total_items){
	  echo "<td align='center'><INPUT TYPE='text'size='6' value='".$q."' NAME='". $quantity ."'/>	  
           <input type='hidden' NAME='p". $row1['itemnumber'] ."' value ='". $row1['price'] . "' />";
		  
	  echo "<td align='center'><font color=red align=center>". $row1['price'] . "</font></td>";
	     
	  $subtotal= $q*$row1['price'] ; 
	  echo "<td align='center'>USD: ".$subtotal."</td>";
   
echo "<td><INPUT NAME='delete' TYPE='submit' VALUE='". $row1['itemnumber'] . "'/></td></tr><tr>";	  
	  
	  
	  $total=$total+$subtotal;
	  
	 


$query11="update $cartname set itemname='".$row1['manufacturer']."".$row1['model']."',quantity='".$q."',cost='".$subtotal."'where itemnumber=". $row1['itemnumber'];
     $prefloc11 = $pdoConn->prepare($query11);
     $prefloc11->execute();	  
	  }else{
	  	$mess = "Maximum Order Items is ".$total_items;
	  } 
	  
	  

	  	}		
	  }   	
	
	}
	else
	{
	
  $db = new PDO("mysql:dbname=mobilestore;host=localhost", "root", "" );
     $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling

     $sql ="create table IF NOT EXISTS $cartname (itemnumber BIGINT NOT NULL ,
				itemname VARCHAR(100)  NULL ,
				quantity INT NULL ,
				cost DOUBLE NULL ,
                 createtime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);" ;
     $db->exec($sql);
   

	 
	
	
	$query4="INSERT INTO $cartname( `itemnumber`)
              VALUES('$itemnumber')";	
				   
				   
	$prefloc6 = $pdoConn->prepare($query4);
    $prefloc6->execute();
    
			  
			
	 $query="select * from $cartname ";	
	 $prefloc7 = $pdoConn->prepare($query);
    $prefloc7->execute();

	while($row = $prefloc7->fetch(PDO::FETCH_ASSOC))
		
	  $query5="SELECT * FROM item where itemnumber=".$row['itemnumber']."";	
      $prefloc8 = $pdoConn->prepare($query5);
		$prefloc8->execute();	  
	  
	while($row1 = $prefloc8->fetch(PDO::FETCH_ASSOC))
	 {	     	
	  echo "<td align='center'>". $row1['itemnumber'] . "</td>";	
	  echo "<td align='center'>". $row1['manufacturer'] . "</td>";
	  echo "<td align='center' >". $row1['model'] . "</td>";
	  $quantity=$row1['itemnumber'];
	 if(isset($_REQUEST["update"]))
	  {
	  $q=$_REQUEST[$quantity];}	else{$q=1;}	
	  echo "<td align='center'><INPUT TYPE='text'size='6' value='".$q."' NAME='". $quantity ."'/>	  
           <input type='hidden' NAME='p". $row1['itemnumber'] ."' value ='". $row1['price'] . "' />";
		   
	  echo "<td align='center'><font color=red align=center>". $row1['price'] . "</font></td>";	
	  $subtotal= $q*$row1['price'] ; 
	  echo "<td align='center'>Ksh: ".$subtotal."</td></tr><tr>";	
	  $total=$total+$subtotal;
	  
	 
	  
	  $query12="update $cartname set itemname='".$row1['manufacturer']."".$row1['model']."',quantity='".$q."',cost='".$subtotal."'where itemnumber=". $row1['itemnumber'];
     $prefloc12 = $pdoConn->prepare($query12);
     $prefloc12->execute();
	    
	  } 
	  
	} 
	  
	  

 }
 
?>

</tr>
<tr bgcolor="#F7706C" ><td align="center">TOTAL</td><td align="center" colspan="4"><font color="#FF0000">
<?php
if(isset($mess)){
	echo $mess;
}else{
	echo "Please Enter the desired Quantities and Click  below to Update";
}
?>
</font></td><td align="center"><b><?php echo "$: ".$total; ?></b></td></tr>
<tr  ><td align="center"></td><td align="center" colspan="4"><font color="#FF0000"><p  align='center'><INPUT NAME='update' TYPE='submit' VALUE='Update Cart'/></p></font></td><td align="center"></td></tr>
</table>
</form>


<form action="paypal_ec_redirect.php" method="POST">
  <input type="hidden" name="PAYMENTREQUEST_0_AMT" value='<?php echo "$total";?>'></input>
  <input type="hidden" name="currencyCodeType" value="USD"></input>
  <input type="hidden" name="paymentType" value="Sale"></input>
  <input type="hidden" name="cart" value='<?php echo "$cartname";?>'</input>
  <!--Pass additional input parameters based on your shopping cart. For complete list of all the parameters click here -->
  <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" alt="Check out with PayPal"></input>
  
</form>



		</div>

	</div>	



	
				
  </div>	
	
				
	</div>		
	</div>	
	</div>

	
		
		
         
           
            <br/>

    

        <br /> <br />

       
        

        <br /><br />

        
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