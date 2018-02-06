<?php
include 'connect.php';
if(isset($_REQUEST["e"])){
$username=$_REQUEST["e"];
$email=$_REQUEST["e"];
	if($username==""||$username==NULL)
	{
  echo "<script type='text/javascript'>
				document.location = 'administration.php';
				</script>";exit;
				}
	else
	{
	mysql_connect("$host", "$user", "$pass") or die (mysql_error());	
	mysql_select_db("$db") or die(mysql_error());
		
	    $strSQL = "SELECT * FROM administrators where username='$username'";
		$rs = mysql_query($strSQL);
	       while($row = mysql_fetch_array($rs))
	                {
		             if($row['logged']=="NO")
		             {	
					header("Location:administration.php"); 
					      
	                 echo "<script type='text/javascript'>
				          document.location = 'administration.php?e=''';
				           </script>";
                           
                           exit;
						   }
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
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<title>E-MobileStore</title>
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
      <a href="./index.php"><img class="img-responsive" src="images/slider/logo.png" float="left"/></a>
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
 


	
	<div id="navbar">
	
	
	<A HREF="administration.php?e=<?php echo $username ?>">LOG OUT</A>
		
	
	</div>
	


	


  

<?php
if(isset($_POST['tebo'])) {
    // The form has been submited
    // Check the values!
    mysql_connect("$host", "$user", "$pass") or die (mysql_error());	
	mysql_select_db("$db") or die(mysql_error());
	$item=$_POST['itemnumber'];
	echo "item number : $item";
	$delete_admin= "delete from administrators where nationalIdNo = '".$item."'";
	        
	 $rs = mysql_query( $delete_admin);
	
	echo "   deleted $item";
}
else
{
if(isset($_POST['itemdelete'])) {
    // The form has been submited
    // Check the values!
    mysql_connect("$host", "$user", "$pass") or die (mysql_error());	
	mysql_select_db("$db") or die(mysql_error());
	$item=$_POST['itemnumber'];
	echo "$item";
	$delete_product= "delete from item where itemnumber='".$item."'";
	 $rs = mysql_query( $delete_product);
	
	echo "deleted $item";
}
}


?>
	
</div>

</body>
</html>