<?php

require '../connect1.php';
session_start();

/*Session will stay alive for 10 seconds if user remains idle.*/
$session_duration = 600;


if (isset($_POST)):
  $username = $_POST["username"];
  $password = $_POST["password"];

  if ($username != '' AND $password != ''):
    $sql = "SELECT * FROM users WHERE AppUserName = :uname";
    $rec = $pdoConn->prepare($sql);
    $rec->execute(array(':uname' => $username));
    $userdetails = $rec->fetch(PDO::FETCH_ASSOC);
    #var_dump($userdetails);
	$pass=md5($password);
	
	
	$sql1 = "select * from users where AppUserName='$username' and AppUserPassword='$pass'";
    $rec12 = $pdoConn->prepare($sql1);
	$rec12->execute();

    if (count($userdetails) > 0 && $rec12->fetch(PDO::FETCH_ASSOC) == true ):
      //echo "Yes yes yes";
      $fullname = $userdetails['UserFName']." ".$userdetails['UserLName'];
      //echo $fullname;
      $fname = $userdetails['UserFName'];
      $_SESSION["loggedin"] = array("start" => time(), "uname" => $username, "duration" => $session_duration, "name" => $fullname, "fname" => $fname);
      #var_dump($_SESSION["loggedin"]);
      if (!empty($_POST['loc']) && !empty($_POST['eid'])):
        $queryStr = "location=".$_POST['loc']."&eventid=".urlencode($_POST['eid']);
        header("Location: ../eventDetail.php?".$queryStr);
      else:
        header("Location: ../working_user/userhome.php");
      endif;
    else:
      header("Location: ./authlogin.php?status=error&msg=Incorrect username/password");
    endif;
  else:
    $url = urlencode("Missing username or password");
    header("Location: ./authlogin.php?status=error&msg=$url" );
  endif;
else:
  header("Location: ./authlogin.php?status=error&msg=Please Login");
endif;


?>
