<?php include 'connect.php';$email=""; ?>	

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
   
      	<a href="contact-us.html"> Contact</a>
      	<a href="auth/authregister.php"> Register</a>
      	<a href="auth/authlogin.php"> Login</a>
			<?php else: ?>
      	
       
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
				<a href="../auth/authlogout.php">Sign Out</a>
		<?php endif; ?>
    </div>
  </div>

  <div class="main">
    <div id="inner">
      <h2> PAYMENT</h2> <br/ >
        <div id="content3">
<div id="container">


    
    
    

	<div style="clear:both"></div>	
	<div id="leftsidebar">	
	<div style="padding-right:10px;padding-left:10px">
			
	<div align="center" style="margin-top:10px" id="user4">
	
	
	 <div class="moduletable_menu" style="min-height:250px;" >
	<h3>CHECKOUT</h3><br>
	<form action="guestcart.php" method="post">
	<table align="center" border="1"  cellspacing="0" width="550">
	<tr  ><td align="center" colspan="6"><h3><font color="#FF0000">SHOPPING CART</font></h3>
	</td></tr>
	<tr bgcolor="#F7706C" ><td align="center">ITEM NUMBER</td><td align="center">MANUFACTURER</td><td align="center">MODEL</td><td align="">QUANTITY</td><td align="center">UNIT PRICE</td><td align="center">SUB TOTAL</td></tr><tr>
			<?php 
	
mysql_connect("$host", "$user", "$pass") or die (mysql_error());	
	mysql_select_db("$db") or die(mysql_error());
	$total=0;
 if(isset($_REQUEST["update"]))
 {
 $itemnumber=NULL;
 }else{
   
	$itemnumber=$_GET["itemnumber"];
	}
	
	if(isset($_REQUEST["delete"]))
	{	
		$cartname=$_COOKIE["cart"];
		$item=$_POST['delete'];
	 
	 $delete_product= "delete from $cartname where itemnumber='".$item."'";
	 $rs = mysql_query( $delete_product);
	}
	if (isset($_COOKIE["cart"]))
	{
	$cartname=$_COOKIE["cart"];
	echo "g  $cartname ";
	$find = "SELECT * FROM $cartname where itemnumber='".$itemnumber."'";	
	
	$rows= mysql_query($find );
	$numberofrows=mysql_num_rows($rows);
    if($numberofrows!=0)
		{
		$itemnumber=NULL;
		}		
	
	mysql_query("INSERT INTO $cartname( `itemnumber`)
              VALUES('$itemnumber')");
			   
	$query="select * from $cartname ";	
	$rs = mysql_query( $query);	
	while($row = mysql_fetch_array($rs))
	 {	     	
	 $rs1=mysql_query("SELECT * FROM item   where itemnumber=".$row['itemnumber']."");	 
	while($row1 = mysql_fetch_array($rs1))
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
           <input type='hidden' NAME='p". $row1['itemnumber'] ."' value ='". $row1['price'] . "' />
		   <input type='hidden' NAME='update' value ='update' />";
	  echo "<td align='center'><font color=red align=center>". $row1['price'] . "</font></td>";
	     
	  $subtotal= $q*$row1['price'] ; 
	  echo "<td align='center'>USD: ".$subtotal."</td>";	
	  	  echo "<td><INPUT NAME='delete' TYPE='submit' VALUE='". $row1['itemnumber'] . "'/></td></tr><tr>";
	  $total=$total+$subtotal;
	  
	    mysql_query("update $cartname set 
	  itemname='".$row1['manufacturer']."".$row1['model']."',
	  quantity='".$q."',
	  cost='".$subtotal."'
	  where itemnumber=". $row1['itemnumber'] 
	  );	  
	  }else{
	  	$mess = "Maximum Order Items is ".$total_items;
	  } 
	  
	  

	  	}		
	  }   	
	
	}
	else
	{
	$cartname=md5(mt_rand(1,1000000)*time());
	
	setcookie("cart",$cartname, time()+15*60);
	
	mysql_query("CREATE TABLE`$db`.`$cartname` 
	            (`itemnumber` BIGINT NOT NULL ,
				`itemname` VARCHAR(100)  NULL ,
				`quantity` INT NULL ,
				`cost` DOUBLE NULL ,
                 `createtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                   )");
    echo "before insert $cartname  values $itemnumber";				   
    mysql_query("INSERT INTO $cartname( `itemnumber`)
              VALUES('$itemnumber')"); 
			  
			
	 $query="select * from $cartname ";	
	$rs = mysql_query( $query);	
	while($row = mysql_fetch_array($rs))
	  $rs1=mysql_query("SELECT * FROM item   where itemnumber=".$row['itemnumber']."");	 
	  
	while($row1 = mysql_fetch_array($rs1))
	 {	     	
	  echo "<td align='center'>". $row1['itemnumber'] . "</td>";	
	  echo "<td align='center'>". $row1['manufacturer'] . "</td>";
	  echo "<td align='center' >". $row1['model'] . "</td>";
	  $quantity=$row1['itemnumber'];
	 if(isset($_REQUEST["update"]))
	  {
	  $q=$_REQUEST[$quantity];}	else{$q=1;}	
	  
	  echo "<td align='center'><INPUT TYPE='text'size='6' value='".$q."' NAME='". $quantity ."'/>	  
           <input type='hidden' NAME='p". $row1['itemnumber'] ."' value ='". $row1['price'] . "' />
		   <input type='hidden' NAME='update' value ='update' />";
	  echo "<td align='center'><font color=red align=center>". $row1['price'] . "</font></td>";	
	  $subtotal= $q*$row1['price'] ; 
	  echo "<td align='center'>USD: ".$subtotal."</td></tr><tr>";	
	  $total=$total+$subtotal;
	  
	  mysql_query("update $cartname set 
	  itemname='".$row1['manufacturer']."".$row1['model']."',
	  quantity='".$q."',
	  cost='".$subtotal."'
	  where itemnumber=". $row1['itemnumber'] 
	  );
	    
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
<tr  ><td align="center"></td><td align="center" colspan="4"><font color="#FF0000"><p  align='center'><INPUT NAME='update' TYPE='submit' VALUE='UPDATE CART'/></p></font></td><td align="center"></td></tr>
</table>
</form>





<form action="paypal_ec_redirect.php" method="POST">
  <input type="hidden" name="PAYMENTREQUEST_0_AMT" value="10.00"></input>
  <input type="hidden" name="currencyCodeType" value="USD"></input>
  <input type="hidden" name="paymentType" value="Sale"></input>
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

        


  <div class="footer">
    <div>
      <span> Powered by University of North Texas </span>
    </div>
  </div>

</body>
</html>
