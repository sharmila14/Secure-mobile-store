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
  <title> Go!Play. Upcoming Events</title>
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
      <a href="../index.php"><img class="img-responsive" src="../images/Logo_216x80.png" /></a>
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
    <div id="navbar">
			<?php if (!isset($_SESSION["loggedin"]["uname"])): ?>
      	<a href="./index.php"> Home</a>
      	<a href="#"> About</a>
      	<a href="./locationSearch.php"> Explore</a>
      	<a href="#msgDialog"> Events</a>
      	<a href="#msgDialog"> Scores</a>
      	<a href="#"> Contact</a>
      	<a href="../auth/authregister.php"> Register</a>
      	<a href="../auth/authlogin.php"> Login</a>
			<?php else: ?>
      	<a href="../locationSearch.php"> Explore</a>
        <a href="../createEvent.php"> Host Event</a>
      	<a href="#"> Events</a>
      	<a href="./eventshistory.php"> Scores</a>
        <a href="#"> Notifications</a>
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
				<a href="../auth/authlogout.php">Sign Out</a>
		<?php endif; ?>
    </div>
  </div>

  <div class="main">
    <div id="inner">
      <h2> YOUR UPCOMING EVENTS </h2> <br/ >
        <div id="content3">
<div id="container">


    
    
    

	<div style="clear:both"></div>	
	<div id="leftsidebar">	
	<div style="padding-right:10px;padding-left:10px">
			
	<div align="center" style="margin-top:10px" id="user4">
	
	
	 <div class="moduletable_menu" style="min-height:250px;" >
	<h3>CHECKOUT</h3><br>
	<form action="cart.php" method="post"/>
	<table align="center" border="1"  cellspacing="0" width="550">
	<tr  ><td align="center" colspan="6"><h3><font color="#FF0000">SHOPPING CART</font></h3>
	</td></tr>
	<tr bgcolor="#F7706C" ><td align="center">ITEM NUMBER</td><td align="center">MANUFACTURER</td><td align="center">MODEL</td><td align="">QUANTITY</td><td align="center">UNIT PRICE</td><td align="center">SUB TOTAL</td></tr><tr>
			<?php 
	

	
	$cartname=$_SESSION["loggedin"]["fname"];
	 $query20="select * from $cartname where itemnumber<>0";	
	 $prefloc20 = $pdoConn->prepare($query20);
	$prefloc20->execute();
		$numberofrows=$prefloc20->rowCount();
		$total=0;
		if($numberofrows>0)
		{		
		
		
	
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
	  echo "<td align='center'>Ksh: ".$subtotal."</td>";
		echo "<td><INPUT NAME='delete' TYPE='submit' VALUE='". $row1['itemnumber'] . "'/></td></tr><tr>";	  
	  $total=$total+$subtotal;
	  
	  
	 
	 
	 }   
	
	
	
	
	
	
	
	
	}
	
	else
		
		{
			
			
			
			
	$cartname=$_SESSION["loggedin"]["fname"];
	
	$val = "select 1 from $cartname";
	$prefloc15 = $pdoConn->prepare($val);
    $prefloc15->execute();
	
	

if($prefloc15->fetch(PDO::FETCH_ASSOC) == true)
	{
		
		
		
		
	$cartname=$_SESSION["loggedin"]["name"];
	echo "$cartname";
	
	
	$find = "SELECT * FROM $cartname ";
	
	$prefloc = $pdoConn->prepare($find );
     
	
	$rows= $prefloc->execute();
	
	$numberofrows=$prefloc->rowCount();
	
    if($numberofrows!=0)
		{
		$itemnumber=NULL;
		}		

else
{
	
	$find2="INSERT INTO $cartname( `itemnumber`)VALUES('$itemnumber')";
			  
    $prefloc2 = $pdoConn->prepare($find2 );
     
	
	$rows2= $prefloc2->execute();
}		   
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
	  echo "<td align='center'>Ksh: ".$subtotal."</td>";
   
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
	$cartname=$_SESSION["loggedin"]["name"];
	
			
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
}

else
	
	{
		echo " your cart is empty";
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




<form action="iframe.php" method="post">
<table width="550" align="center">
<tr ><td colspan="3" align="center"><font color="#FF0000"><h3>PLEASE ENTER YOUR PERSONAL INFORMATION</h3></font></td></tr>
	
	<input type="hidden" name="amount" value="<?php echo $total; ?>" />
	<input type="hidden" name="type" value="MERCHANT" readonly="readonly" />
	<input type="hidden" name="description" value="Account load-up" />
	<input type="hidden" name="reference" value="001" />    
    
	<input type="hidden" name="cartname" value="<?php echo $cartname; ?>" />
	<tr><td>FIRST NAME:</td><td><input type="text" size="30"  name="first_name" value="" /></td><td rowspan="3"><img src="images/payments.PNG" width="200" height="100"</td></tr>
	<tr><td>LAST NAME:</td><td><input type="text" size="30" name="last_name" value="" /></td></tr>
<tr><td>ADDRESS:</td><td><input type="text" size="30" name="address" value="" /></td></tr>
<tr><td>EMAIL:</td><td><input type="text" size="30" name="email" value="" /></td></tr>
<tr><td>PHONE:</td><td><input type="text" size="30" name="phone" value="" /></td></tr>
<tr  ><td colspan="3" align="center" ><input align="right" type="submit" value="CHECK OUT" /></td></tr>
</table>

</form>
		</div>

	</div>	



	
				
  </div>	
	
				
	</div>		
	</div>	
	</div>

	
		
		
          <details>
           
            <br/>

    

        <br /> <br />

        <div id="eventDetail" class="modalDialog">
          <div id="container">
          </div>
        </div>
        <script type="text/javascript">
        $(document).on("click", ".style-button", function() {
          var myuname = "<?= $_SESSION["loggedin"]["uname"]; ?>";
          var myeId = $(this).data('eid');
          //alert(myeId);
          //alert(this.id);
          if(this.id == "btn1") {
            dataStr = "eventid=" + myeId + "&button=" + this.id;
          }
          else if (this.id == "btn2") {
            dataStr = "eventid=" + myeId + "&username=" + myuname + "&button=" + this.id;
          }
          //alert(dataStr);
          $.ajax({
            type: "POST",
            url: "upcomingevents-ajax.php",
            data: dataStr,
            dataType: "html",
            cache: false,
            success: function(response) {
              //alert(response);
              $('#container').html(response);
            }
          });
        });
        </script>

        <br /><br />

        <div id="content4">
          <details>
            <summary id="summary2">Events that you are hosting</summary>
            <br/>
            <?php $sqlQuery = "SELECT e.EventId, e.EventName, e.SportCategory, s.SportName, e.StartTime, e.EndTime, e.Venue, v.VenueName, v.Address1, v.Address2, e.EventStatus
            FROM Events e, Venues v, Sports s
            WHERE e.EventHost = :user and e.Venue = v.VenueId and e.EventStatus != 'Completed' and e.SportCategory = s.SportId;";
            $record = $pdoConn->prepare($sqlQuery);
            $record->bindParam(':user', $_SESSION["loggedin"]["uname"]);
            # var_dump($record);
            $record->execute();
            #$result = $record->fetchAll();
            if ($record->rowCount() > 0): ?>
            <table id="t1" text-align="center" cellpadding="3px" width="100%">
              <tr>
                <th> Event Name </th>
                <th> Sport Category </th>
                <th> Event Starts </th>
                <th></th>
              </tr>
            <?php
              foreach ($record->fetchAll() as $res): ?>
                <tr>
                  <td> <?php echo $res['EventName']; ?> </td>
                  <td> <?php echo $res['SportName']; ?> </td>
                  <?php $time = strtotime($res['StartTime']);
                  $startTime = date("l, j F Y g:i A", $time); ?>
                  <td> <?php echo $startTime; ?> </td>
                  <td><a id="btn2" class="style-button" data-eid="<?= $res['EventId']; ?>" href="#eventDetail">More...</a></td>
                </tr>
           <?php endforeach; ?>
         </table>
         <?php else: ?>
           <p style="text-align: center;">No upcoming events found that is being hosted by you. Do you want to host an event?&nbsp;&nbsp;&nbsp; <a href="../createEvent.php">Click here</a></p>
         <?php endif; ?>
          </details>
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
