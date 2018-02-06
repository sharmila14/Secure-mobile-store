<?php

/* Session information check starts */
if(!isset($_SESSION["loggedin"]["uname"])):
  header("Location: ../auth/authlogin.php");
endif;

if(isset($_SESSION["loggedin"]["uname"])):
  $query = "SELECT PreferredLoc FROM Users WHERE AppUserName = :user";
  $prefloc = $pdoConn->prepare($query);
  $prefloc->execute(['user' => $_SESSION["loggedin"]["uname"]]);
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

/* Session information check ends */

require '../connect.php';

$eventid = $_POST['eid'];
//echo $eventid;
$eventname = $_POST['ename'];
//echo $eventname;
$eventscore = $_POST['escore'];
//echo $eventscore;
$eventcomment = $_POST['ecomment'];
//echo $eventcomment;

$sql = "UPDATE Scores SET EventScore = :score , Comments = :comment WHERE Event = :id";
$psql = $pdoConn->prepare($sql);
$res = $psql->execute(['score' => $eventscore, 'comment' => $eventcomment, 'id' => $eventid]);
#var_dump($res);

if($res):
  header("Location: ./submitscores.php?scoresubmit=success#msg");
else:
  header("Location: ./submitscores.php?scoresubmit=failure#msg");
endif;

 ?>
