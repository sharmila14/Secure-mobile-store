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
 $uname=$_SESSION["loggedin"]["fname"];
   echo "$uname";

  if ((time() - $start) > $durn):
    unset($_SESSION["loggedin"]["duration"]);
    unset($_SESSION["loggedin"]["start"]);
    unset($_SESSION["loggedin"]["name"]);
    unset($_SESSION["loggedin"]["fname"]);
    unset($_SESSION["loggedin"]);

    header("Location: ../auth/authlogout.php?status=error&msg=** Session has been expired after $durn seconds. **");
  else:
    $_SESSION["loggedin"]["start"] = time();    /* to track if the user is not idle */
    //echo "<h2>Welcome to Posts Page: ".$_SESSION["loggedin"]["name"]."</h2>";
  endif;
else:
  header("Location: ../auth/authlogin.php?status=error&msg=** No session found. Please login **");
endif;

?>

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> E-Mobile Store. User Home </title>
  <link rel="stylesheet" href="./userhome.css">
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
      	<a href="./contact-us.html"> Contact</a>
      	<a href="../auth/authregister.php"> Register</a>
      	<a href="../auth/authlogin.php"> Login</a>
			<?php else: ?>
      	
        <a href="./yourcart.php"> CART</a>
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
				<a href="../auth/authlogout.php">Sign Out</a>
		<?php endif; ?>
    </div>
  </div>

  <div class="main">
    <div id="inner">
      <span> Hi, <?= $_SESSION["loggedin"]["name"]; ?> </span>
      <h2><?php echo ($_SESSION["loggedin"]["fname"]); ?></h2>
  </div>
    <div id="container">
      <div id="container1">
        <a href="./upcomingevents.php?itemnumber=0&rows=0&category=apple"><img class="img-responsive" src="../images/apple logo1.jpg" /></a>
      </div>
      <div id="container2">
        <a href="./eventshistory.php"><h3> Samsung </h3></a>
      </div>
      
    </div>
  </div>

    <div class="footer">
      <div>
        <span> Powered by University of North Texas </span>
      </div>
    </div>

</body>
</html>
