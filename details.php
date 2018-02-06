<?php
session_start();
require 'connect1.php';


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
  <div class="banner">
    <div id="applogo">
      <a href="../index.php"><img class="img-responsive" src="../images/slider/logo.png" /></a>
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
    <div id="navbar">
			<?php if (!isset($_SESSION["loggedin"]["uname"])): ?>
      	<a href="./index.php"> Home</a>
     
      	<a href="contact-us.html"> Contact</a>
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
	<h3>Mobiles Selected</h3><br>
		<?php 
	

if(isset($_GET["itemnumber"])&& $_GET["itemnumber"]!=NULL){
	$itemnumber=$_GET["itemnumber"];
	 $query="select * from item where itemnumber=$itemnumber";
     $prefloc = $pdoConn->prepare($query);
     $prefloc->execute();
	 $numberofrows=$prefloc->rowCount();

	$rs = mysql_query( $query);
	if($numberofrows==0){echo "NO RECORDS FOUND!";}	
	while($row= $prefloc->fetch(PDO::FETCH_ASSOC)) {
	   
	  echo "<h3 align=center><u>". $row['manufacturer'] ." ". $row['model'] . "</u> </h3>";	
	     	
	  echo "<font color=red align=center>Item Number:</font><b>". $row['itemnumber'] . "</b><br>";
	  
	  $hits=$row['hits']+1;
	  	
 mysql_query("update item set hits='".$hits."' where itemnumber='".$itemnumber."'");
 setcookie("viewed",$row['category'],time()+60*60*24*365);  
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
	
	  	
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><img  src=images/" .$row['image'] ."></img></a> <br><br>";
	
	  if ($row['description']!=NULL)
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><h3 align=center><u>Description</u> </h3></a>";		
	  echo "<pre ><i>". $row['description'] . "</i></pre><br><br><br>";	
	    if ($row['price']>0)
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><font color=red align=center>Selling Price:</font><b>Ksh " . $row['price'] . "</b></a><br><br>";
	  
	  echo "<a href=guestcart.php?itemnumber=".$row['itemnumber']."><font color=red align='right'>ADD TO CART</font></a><br>";	
	  	
	  }
}else{echo "Enter a a valid item number";}



?>
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
